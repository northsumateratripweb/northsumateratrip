<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components as Forms;
use Filament\Schemas\Components as Schemas;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class BusinessProfileSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \UnitEnum|string|null $navigationGroup = 'Sistem & Pengaturan';

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $title = 'Profil Bisnis';

    protected string $view = 'filament.pages.business-profile-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => Setting::get('site_name', 'NorthSumateraTrip'),
            'whatsapp_number' => Setting::get('whatsapp_number', '6281298622143'),
            'site_email' => Setting::get('site_email', 'hello@northsumateratrip.com'),
            'site_address' => Setting::get('site_address', 'Medan, Sumatera Utara, Indonesia'),
            'working_hours' => Setting::get('working_hours', '08:00 - 17:00'),
            'timezone' => Setting::get('timezone', 'Asia/Jakarta'),
            'facebook_url' => Setting::get('facebook_url'),
            'instagram_url' => Setting::get('instagram_url'),
            'tiktok_url' => Setting::get('tiktok_url'),
            'youtube_url' => Setting::get('youtube_url'),
            'twitter_url' => Setting::get('twitter_url'),
            'site_logo' => Setting::get('site_logo'),
            'site_favicon' => Setting::get('site_favicon'),
            'default_hero_image' => Setting::get('default_hero_image'),
            'primary_color' => Setting::get('primary_color', '#1D4ED8'),
            'secondary_color' => Setting::get('secondary_color', '#10B981'),
            'meta_title' => Setting::get('meta_title', 'NorthSumateraTrip'),
            'meta_description' => Setting::get('meta_description'),
            'meta_keywords' => Setting::get('meta_keywords'),
            'google_analytics_id' => Setting::get('google_analytics_id'),
            'bank_name_1' => Setting::get('bank_name_1'),
            'bank_account_1' => Setting::get('bank_account_1'),
            'bank_holder_1' => Setting::get('bank_holder_1'),
            'bank_name_2' => Setting::get('bank_name_2'),
            'bank_account_2' => Setting::get('bank_account_2'),
            'bank_holder_2' => Setting::get('bank_holder_2'),
            'qris_image' => Setting::get('qris_image'),
            'mail_host' => Setting::get('mail_host', '127.0.0.1'),
            'mail_port' => Setting::get('mail_port', '2525'),
            'mail_username' => Setting::get('mail_username'),
            'mail_password' => Setting::get('mail_password'),
            'hero_badge_text' => Setting::get('hero_badge_text', 'Layanan Premium'),
            'hero_title' => Setting::get('hero_title', 'Jelajahi Keindahan Sumatera Utara'),
            'hero_subtitle' => Setting::get('hero_subtitle', 'Nikmati pengalaman wisata terbaik dengan layanan private trip eksklusif kami.'),
            'cta_title' => Setting::get('cta_title', 'Siap Memulai Petualangan?'),
            'cta_subtitle' => Setting::get('cta_subtitle', 'Hubungi kami sekarang untuk konsultasi perjalanan gratis.'),
            'cta_button_text' => Setting::get('cta_button_text', 'Hubungi Kami'),
        ]);
    }

    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema([
                Schemas\Tabs::make('Settings')
                    ->tabs([
                        Schemas\Tabs\Tab::make('Informasi Bisnis')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Schemas\Section::make('Profil Perusahaan')
                                    ->schema([
                                        Forms\TextInput::make('site_name')
                                            ->label('Nama Perusahaan')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\TextInput::make('whatsapp_number')
                                            ->label('Nomor WhatsApp')
                                            ->required()
                                            ->tel()
                                            ->maxLength(20),
                                        Forms\TextInput::make('site_email')
                                            ->label('Email Bisnis')
                                            ->required()
                                            ->email()
                                            ->maxLength(255),
                                        Forms\Textarea::make('site_address')
                                            ->label('Alamat Kantor')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ])->columns(2),
                                
                                Schemas\Section::make('Jam Operasional & Waktu')
                                    ->schema([
                                        Forms\TextInput::make('working_hours')
                                            ->label('Jam Kerja (e.g. 08:00 - 17:00)')
                                            ->placeholder('08:00 - 17:00'),
                                        Forms\Select::make('timezone')
                                            ->label('Timezone')
                                            ->options([
                                                'Asia/Jakarta' => 'WIB (Asia/Jakarta)',
                                                'Asia/Makassar' => 'WITA (Asia/Makassar)',
                                                'Asia/Jayapura' => 'WIT (Asia/Jayapura)',
                                            ])
                                            ->default('Asia/Jakarta'),
                                    ])->columns(2),
                            ]),
                        
                        Schemas\Tabs\Tab::make('Media Sosial')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Schemas\Section::make('SOSMED')
                                    ->description('Masukkan URL lengkap akun media sosial Anda')
                                    ->schema([
                                        Forms\TextInput::make('facebook_url')
                                            ->label('Facebook')
                                            ->url()
                                            ->placeholder('https://facebook.com/username'),
                                        Forms\TextInput::make('instagram_url')
                                            ->label('Instagram')
                                            ->url()
                                            ->placeholder('https://instagram.com/username'),
                                        Forms\TextInput::make('tiktok_url')
                                            ->label('TikTok')
                                            ->url()
                                            ->placeholder('https://tiktok.com/@username'),
                                        Forms\TextInput::make('youtube_url')
                                            ->label('YouTube')
                                            ->url()
                                            ->placeholder('https://youtube.com/@channel'),
                                        Forms\TextInput::make('twitter_url')
                                            ->label('Twitter / X')
                                            ->url()
                                            ->placeholder('https://twitter.com/username'),
                                    ])->columns(1),
                            ]),

                        Schemas\Tabs\Tab::make('Branding & UI')
                            ->icon('heroicon-o-swatch')
                            ->schema([
                                Schemas\Section::make('Logo & Favicon')
                                    ->schema([
                                        Forms\FileUpload::make('site_logo')
                                            ->label('Logo Website')
                                            ->image()
                                            ->disk('public')
                                            ->visibility('public')
                                            ->directory('settings')
                                            ->maxSize(2048)
                                            ->imagePreviewHeight('100'),
                                        Forms\FileUpload::make('site_favicon')
                                            ->label('Favicon (32x32)')
                                            ->image()
                                            ->disk('public')
                                            ->visibility('public')
                                            ->directory('settings')
                                            ->maxSize(512),
                                        Forms\FileUpload::make('default_hero_image')
                                            ->label('Banner Carousel (Hero Images)')
                                            ->helperText('Upload satu atau lebih gambar untuk slider. Gunakan format JPG/PNG/WebP (HEIC tidak didukung oleh browser).')
                                            ->image()
                                            ->disk('public')
                                            ->visibility('public')
                                            ->directory('settings')
                                            ->multiple()
                                            ->reorderable()
                                            ->maxSize(5120)
                                            ->columnSpanFull(),
                                    ])->columns(2),
                                
                                Schemas\Section::make('Warna Tema')
                                    ->schema([
                                        Forms\ColorPicker::make('primary_color')
                                            ->label('Warna Utama')
                                            ->default('#1D4ED8'),
                                        Forms\ColorPicker::make('secondary_color')
                                            ->label('Warna Sekunder')
                                            ->default('#10B981'),
                                    ])->columns(2),
                            ]),

                        Schemas\Tabs\Tab::make('SEO & Analytics')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Schemas\Section::make('Meta Tags')
                                    ->schema([
                                        Forms\TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->maxLength(60)
                                            ->columnSpanFull(),
                                        Forms\Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->maxLength(160)
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        Forms\Textarea::make('meta_keywords')
                                            ->label('Meta Keywords (pisahkan dengan koma)')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ]),
                                
                                Schemas\Section::make('Scripts')
                                    ->schema([
                                        Forms\TextInput::make('google_analytics_id')
                                            ->label('Google Analytics ID / Tag')
                                            ->placeholder('G-XXXXXXXXXX atau UA-XXXXXXXXX-X'),
                                    ]),
                            ]),

                        Schemas\Tabs\Tab::make('Integrasi & Pembayaran')
                            ->icon('heroicon-o-credit-card')
                            ->schema([
                                Schemas\Section::make('Rekening Bank & Pembayaran Manual')
                                    ->description('Detail rekening yang akan ditampilkan kepada pelanggan untuk transfer bank manual.')
                                    ->schema([
                                        Forms\TextInput::make('bank_name_1')
                                            ->label('Nama Bank 1')
                                            ->placeholder('BCA, Mandiri, BNI, dll'),
                                        Forms\TextInput::make('bank_account_1')
                                            ->label('Nomor Rekening 1')
                                            ->placeholder('1234567890'),
                                        Forms\TextInput::make('bank_holder_1')
                                            ->label('Atas Nama 1')
                                            ->placeholder('Nama Pemilik Rekening'),
                                        Forms\TextInput::make('bank_name_2')
                                            ->label('Nama Bank 2')
                                            ->placeholder('BCA, Mandiri, BNI, dll'),
                                        Forms\TextInput::make('bank_account_2')
                                            ->label('Nomor Rekening 2')
                                            ->placeholder('1234567890'),
                                        Forms\TextInput::make('bank_holder_2')
                                            ->label('Atas Nama 2')
                                            ->placeholder('Nama Pemilik Rekening'),
                                        Forms\FileUpload::make('qris_image')
                                            ->label('Gambar QRIS')
                                            ->image()
                                            ->disk('public')
                                            ->visibility('public')
                                            ->directory('payment')
                                            ->maxSize(2048)
                                            ->columnSpanFull(),
                                    ])->columns(3),
                                
                                Schemas\Section::make('Email Configuration (SMTP)')
                                    ->schema([
                                        Forms\TextInput::make('mail_host')
                                            ->label('Mail Host')
                                            ->placeholder('smtp.gmail.com'),
                                        Forms\TextInput::make('mail_port')
                                            ->label('Mail Port')
                                            ->placeholder('587')
                                            ->numeric(),
                                        Forms\TextInput::make('mail_username')
                                            ->label('Mail Username')
                                            ->placeholder('your-email@gmail.com'),
                                        Forms\TextInput::make('mail_password')
                                            ->label('Mail Password')
                                            ->password()
                                            ->revealable(),
                                    ])->columns(2),
                            ]),

                        Schemas\Tabs\Tab::make('Konten Landing Page')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Schemas\Section::make('Hero Section')
                                    ->schema([
                                        Forms\TextInput::make('hero_badge_text')
                                            ->label('Badge Text (atas judul)')
                                            ->placeholder('Layanan Premium')
                                            ->maxLength(100),
                                        Forms\TextInput::make('hero_title')
                                            ->label('Judul Utama (Hero Title)')
                                            ->placeholder('Jelajahi Keindahan Sumatera Utara')
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        Forms\Textarea::make('hero_subtitle')
                                            ->label('Sub-judul (Hero Subtitle)')
                                            ->placeholder('Nikmati pengalaman wisata terbaik...')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                                
                                Schemas\Section::make('CTA Section (Bawah)')
                                    ->schema([
                                        Forms\TextInput::make('cta_title')
                                            ->label('Judul CTA')
                                            ->placeholder('Siap Memulai Petualangan?')
                                            ->maxLength(255),
                                        Forms\Textarea::make('cta_subtitle')
                                            ->label('Sub-judul CTA')
                                            ->placeholder('Hubungi kami sekarang untuk...')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        Forms\TextInput::make('cta_button_text')
                                            ->label('Teks Tombol CTA')
                                            ->placeholder('Hubungi Kami')
                                            ->maxLength(50),
                                    ])->columns(2),
                            ]),
                    ])->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_site')
                ->label('Lihat Website')
                ->url(url('/'))
                ->openUrlInNewTab()
                ->color('gray')
                ->icon('heroicon-o-arrow-top-right-on-square'),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save')
                ->color('success'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // File fields - Filament sudah handle upload ke disk('public')
        // getState() mengembalikan path string (single) atau array path (multiple)
        $singleFileFields = ['site_logo', 'site_favicon', 'qris_image'];

        foreach ($data as $key => $value) {
            // Single file fields: Filament returns array with one entry, extract the path
            if (in_array($key, $singleFileFields) && is_array($value)) {
                $value = !empty($value) ? array_values($value)[0] : null;
            }

            // Multiple file field (hero): Filament returns associative array, normalize to indexed
            if ($key === 'default_hero_image' && is_array($value)) {
                $value = array_values($value);
            }

            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
