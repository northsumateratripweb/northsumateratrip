Param(
    [switch]$DryRun,
    [switch]$Force,
    [switch]$IgnorePlatform
)

Set-StrictMode -Version Latest
$ErrorActionPreference = 'Stop'

function Assert-Php84 {
    param([switch]$ForceBypass)
    $phpVersion = (& php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;") 2>$null
    if (-not $phpVersion) { throw "PHP tidak ditemukan di PATH." }
    Write-Host "Versi PHP terdeteksi: $phpVersion"
    if (-not $ForceBypass -and [version]$phpVersion -lt [version]'8.4') {
        throw "PHP >= 8.4 dibutuhkan. Versi saat ini: $phpVersion"
    }
    return $phpVersion
}

function Backup-And-Replace-ComposerJson {
    if (-not (Test-Path -Path ".\composer.l12.json")) {
        throw "File composer.l12.json tidak ditemukan."
    }
    if (-not (Test-Path -Path ".\composer.json.bak")) {
        Copy-Item -Path ".\composer.json" -Destination ".\composer.json.bak"
        Write-Host "Backup composer.json -> composer.json.bak"
    }
    Copy-Item -Path ".\composer.l12.json" -Destination ".\composer.json" -Force
    Write-Host "composer.json diganti dengan composer.l12.json"
}

function Restore-ComposerJson {
    if (Test-Path ".\composer.json.bak") {
        Copy-Item -Path ".\composer.json.bak" -Destination ".\composer.json" -Force
        Write-Host "composer.json dipulihkan dari backup."
    }
}

try {
    $phpVer = Assert-Php84 -ForceBypass:$Force

    if ($DryRun) {
        Write-Host "Mode DryRun: tidak ada perubahan pada composer.json."
    } else {
        Backup-And-Replace-ComposerJson
    }

    & composer self-update

    if (Test-Path ".\vendor") {
        Write-Host "Menghapus vendor/ untuk instalasi bersih..."
        Remove-Item -Recurse -Force ".\vendor"
    }

    if ($IgnorePlatform) {
        & composer update --with-all-dependencies --ignore-platform-reqs
    } else {
        & composer update --with-all-dependencies
    }

    if (-not (Test-Path ".\.env") -and (Test-Path ".\.env.example")) {
        Copy-Item ".\.env.example" ".\.env"
    }

    $canRunPhp84OnlySteps = ([version]$phpVer -ge [version]'8.4') -and (-not $IgnorePlatform)
    if ($canRunPhp84OnlySteps) {
        & php artisan key:generate
        & php artisan package:discover
        & php artisan optimize:clear
        & php artisan migrate --force

        & php vendor/bin/pint
        & php artisan test
    } else {
        Write-Host "Melewati langkah artisan/pint/test karena lingkungan bukan PHP >= 8.4 atau menggunakan --ignore-platform-reqs."
        Write-Host "Silakan verifikasi di CI atau mesin dengan PHP 8.4."
    }

    Write-Host "Upgrade selesai."
    Write-Host "Jika stabil, commit perubahan ke branch upgrade-l12-php84 lalu merge ke main."
}
catch {
    Write-Error $_
    Write-Host "Terjadi error saat upgrade. Memulihkan composer.json jika perlu..."
    if (-not $DryRun) { Restore-ComposerJson }
    exit 1
}
