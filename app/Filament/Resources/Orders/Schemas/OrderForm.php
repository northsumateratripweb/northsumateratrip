<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Hotel;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pelanggan')
                    ->icon('heroicon-o-user')
                    ->description('Informasi kontak pelanggan yang melakukan pemesanan.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('customer_name')->required()->label('Nama Lengkap'),
                        TextInput::make('customer_email')->email()->label('Email'),
                        TextInput::make('customer_phone')
                            ->tel()
                            ->required()
                            ->label('Nomor Telepon / WhatsApp')
                            ->placeholder('Contoh: 08123456789')
                            ->helperText('Gunakan format internasional jika perlu, misal: 62812...'),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->label('User Account (Opsional)')
                            ->helperText('Hubungkan dengan akun terdaftar jika ada.'),
                    ]),
                Section::make('Detail Pesanan')
                    ->icon('heroicon-o-shopping-bag')
                    ->description('Rincian item yang dipesan dan jadwal perjalanan.')
                    ->columns(2)
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Paket Wisata')
                            ->columnSpan(1),
                        Select::make('vehicle_id')
                            ->relationship('vehicle', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Kendaraan/Mobil')
                            ->columnSpan(1),
                        Select::make('rental_package_id')
                            ->relationship('rentalPackage', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Paket Rental')
                            ->columnSpanFull(),
                        DatePicker::make('trip_date')->required()->label('Tanggal Mulai Trip'),
                        DatePicker::make('trip_end_date')->label('Tanggal Selesai'),
                        Grid::make(2)->schema([
                            TextInput::make('pax_adult')->numeric()->required()->label('Peserta Dewasa'),
                            TextInput::make('pax_child')->numeric()->required()->label('Peserta Anak (8 Thn Kebawah)'),
                        ]),
                        TextInput::make('quantity')->numeric()->required()->label('Total Peserta (Pax)'),
                        TextInput::make('total_price')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->label('Total Harga')
                            ->hint('Gunakan angka saja tanpa titik/koma'),
                        TextInput::make('trip_type')->label('Tipe Trip (Custom)')->placeholder('Contoh: Reguler / VIP'),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('pending')
                            ->required()
                            ->native(false),
                    ]),
                Section::make('Pembayaran & Transaksi')
                    ->icon('heroicon-o-credit-card')
                    ->description('Status pembayaran dan bukti transfer.')
                    ->columns(2)
                    ->schema([
                        Select::make('payment_status')
                            ->label('Status Bayar')
                            ->options([
                                'unpaid' => 'Belum Lunas',
                                'paid' => 'Lunas',
                                'partial' => 'DP (Sebagian)',
                            ])
                            ->default('unpaid')
                            ->required()
                            ->native(false),
                        TextInput::make('transaction_id')
                            ->label('ID Transaksi (Manual/Otomatis)')
                            ->placeholder('TRIP-XXXX / CAR-XXXX'),
                        FileUpload::make('payment_proof')
                            ->label('Unggah Bukti Pembayaran')
                            ->image()
                            ->disk('public')
                            ->directory('payment_proofs')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),
                Section::make('Akomodasi & Logistik')
                    ->icon('heroicon-o-building-office-2')
                    ->description('Detail hotel dan informasi kedatangan.')
                    ->columns(2)
                    ->schema([
                        Select::make('hotel_category')
                            ->label('Kategori Hotel (Pilihan Pelanggan)')
                            ->options([
                                'bintang_1' => '⭐ Bintang 1',
                                'bintang_3' => '⭐⭐⭐ Bintang 3',
                                'bintang_5' => '⭐⭐⭐⭐⭐ Bintang 5',
                                'non_hotel' => '🏠 Non Hotel',
                            ])
                            ->columnSpanFull()
                            ->native(false),
                        ...collect([1, 2, 3, 4])->map(fn ($i) => Select::make("hotel_{$i}")
                            ->label("Hotel Malam {$i}")
                            ->options(fn () => Hotel::active()->orderBy('city')->pluck('name', 'name')->toArray())
                            ->searchable()
                            ->preload()
                            ->allowHtml()
                            ->getSearchResultsUsing(fn (string $search) => Hotel::active()
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('city', 'like', "%{$search}%")
                                ->limit(20)
                                ->get()
                                ->pluck('name', 'name')
                                ->toArray()
                            )
                            ->createOptionForm([
                                TextInput::make('custom_hotel')
                                    ->label('Nama Hotel (Manual)')
                                    ->required(),
                            ])
                            ->createOptionUsing(fn (array $data) => $data['custom_hotel'])
                        )->toArray(),
                        Textarea::make('flight_info')
                            ->label('Info Penerbangan')
                            ->placeholder('Nomor pesawat, Jam kedatangan/keberangkatan...')
                            ->rows(2)
                            ->columnSpanFull(),
                        Toggle::make('use_drone')->label('Gunakan Layanan Drone')->default(false),
                    ]),
                Section::make('Catatan Tambahan')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        Textarea::make('notes')->rows(3)->label('Catatan dari Admin/Pelanggan'),
                    ]),
            ]);
    }
}
