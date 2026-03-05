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

class LanguageManagementSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static \UnitEnum|string|null $navigationGroup = 'Pengaturan';

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-language';

    protected static ?string $title = 'Bahasa & Kurs Mata Uang';

    protected string $view = 'filament.pages.language-management-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'default_language'   => Setting::get('default_language', 'id'),
            'timezone'           => Setting::get('timezone', 'Asia/Jakarta'),
            'exchange_rate_myr'  => Setting::get('exchange_rate_myr', '0.00029'),
            'exchange_rate_sgd'  => Setting::get('exchange_rate_sgd', '0.000085'),
        ]);
    }

    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema([
                Schemas\Section::make('Bahasa & Lokalisasi')
                    ->description('Atur bahasa default dan zona waktu.')
                    ->schema([
                        Forms\Select::make('default_language')
                            ->label('Bahasa Utama')
                            ->options([
                                'id' => '🇮🇩  Bahasa Indonesia (IDR)',
                                'ms' => '🇲🇾  Bahasa Malaysia (MYR)',
                                'en' => '🇸🇬  English (SGD)',
                            ])
                            ->required(),
                        Forms\Select::make('timezone')
                            ->label('Zona Waktu')
                            ->options([
                                'Asia/Jakarta'  => 'WIB (GMT+7)',
                                'Asia/Makassar' => 'WITA (GMT+8)',
                                'Asia/Jayapura' => 'WIT (GMT+9)',
                            ])
                            ->required(),
                    ])->columns(2),

                Schemas\Section::make('Nilai Tukar Mata Uang')
                    ->description('Atur kurs konversi dari IDR ke mata uang lain. Nilai ini digunakan untuk menampilkan harga dalam Ringgit Malaysia (MYR) dan Dolar Singapura (SGD) bagi pengunjung yang memilih bahasa Malaysia atau English.')
                    ->schema([
                        Forms\TextInput::make('exchange_rate_myr')
                            ->label('Kurs IDR → MYR (Ringgit Malaysia)')
                            ->helperText('Contoh: 0.00029 berarti 1 IDR = 0.00029 MYR (atau Rp 3.400 ≈ RM 1)')
                            ->numeric()
                            ->step(0.0000001)
                            ->minValue(0.00001)
                            ->maxValue(1)
                            ->required()
                            ->prefix('1 IDR =')
                            ->suffix('MYR'),
                        Forms\TextInput::make('exchange_rate_sgd')
                            ->label('Kurs IDR → SGD (Dolar Singapura)')
                            ->helperText('Contoh: 0.000085 berarti 1 IDR = 0.000085 SGD (atau Rp 11.700 ≈ S$ 1)')
                            ->numeric()
                            ->step(0.0000001)
                            ->minValue(0.000001)
                            ->maxValue(1)
                            ->required()
                            ->prefix('1 IDR =')
                            ->suffix('SGD'),
                    ])->columns(2),

                Schemas\Section::make('Panduan Kurs')
                    ->description('Referensi cepat konversi berdasarkan kurs yang diisi di atas.')
                    ->schema([
                        Forms\Placeholder::make('preview_myr')
                            ->label('Contoh: Rp 1.000.000')
                            ->content(function () {
                                $rate = (float) Setting::get('exchange_rate_myr', 0.00029);
                                $myr  = number_format(1000000 * $rate, 2);
                                return "≈ RM {$myr}";
                            }),
                        Forms\Placeholder::make('preview_sgd')
                            ->label('Contoh: Rp 1.000.000')
                            ->content(function () {
                                $rate = (float) Setting::get('exchange_rate_sgd', 0.000085);
                                $sgd  = number_format(1000000 * $rate, 2);
                                return "≈ S\$ {$sgd}";
                            }),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Pengaturan bahasa & kurs berhasil disimpan')
            ->success()
            ->send();
    }
}
