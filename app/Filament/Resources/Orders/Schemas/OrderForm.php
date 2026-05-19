<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use App\Models\Hotel;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Pelanggan')
                    ->icon('heroicon-o-user')
                    ->description('Informasi kontak pelanggan yang melakukan pemesanan.')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('customer_name')->required()->label('Nama Lengkap'),
                        \Filament\Forms\Components\TextInput::make('customer_email')->email()->label('Email'),
                        \Filament\Forms\Components\TextInput::make('customer_phone')
                            ->tel()
                            ->required()
                            ->label('Nomor Telepon / WhatsApp')
                            ->placeholder('Contoh: 08123456789')
                            ->helperText('Gunakan format internasional jika perlu, misal: 62812...'),
                        \Filament\Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->label('User Account (Opsional)')
                            ->helperText('Hubungkan dengan akun terdaftar jika ada.'),
                    ]),
                \Filament\Schemas\Components\Section::make('Detail Pesanan')
                    ->icon('heroicon-o-shopping-bag')
                    ->description('Rincian item yang dipesan dan jadwal perjalanan.')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Paket Wisata')
                            ->columnSpan(1),
                        \Filament\Forms\Components\Select::make('vehicle_id')
                            ->relationship('vehicle', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Kendaraan/Mobil')
                            ->columnSpan(1),
                        \Filament\Forms\Components\Select::make('rental_package_id')
                            ->relationship('rentalPackage', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Paket Rental')
                            ->columnSpanFull(),
                        \Filament\Forms\Components\DatePicker::make('trip_date')->required()->label('Tanggal Mulai Trip'),
                        \Filament\Forms\Components\DatePicker::make('trip_end_date')->label('Tanggal Selesai'),
                        \Filament\Schemas\Components\Grid::make(2)->schema([
                            \Filament\Forms\Components\TextInput::make('pax_adult')->numeric()->required()->label('Peserta Dewasa'),
                            \Filament\Forms\Components\TextInput::make('pax_child')->numeric()->required()->label('Peserta Anak (8 Thn Kebawah)'),
                        ]),
                        \Filament\Forms\Components\TextInput::make('quantity')->numeric()->required()->label('Total Peserta (Pax)'),
                        \Filament\Forms\Components\TextInput::make('total_price')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->label('Total Harga')
                            ->hint('Gunakan angka saja tanpa titik/koma'),
                        \Filament\Forms\Components\TextInput::make('trip_type')->label('Tipe Trip (Custom)')->placeholder('Contoh: Reguler / VIP'),
                        \Filament\Forms\Components\Select::make('status')
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
                \Filament\Schemas\Components\Section::make('Pembayaran & Transaksi')
                    ->icon('heroicon-o-credit-card')
                    ->description('Status pembayaran dan bukti transfer.')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\Select::make('payment_status')
                            ->label('Status Bayar')
                            ->options([
                                'unpaid' => 'Belum Lunas',
                                'paid' => 'Lunas',
                                'partial' => 'DP (Sebagian)',
                            ])
                            ->default('unpaid')
                            ->required()
                            ->native(false),
                        \Filament\Forms\Components\TextInput::make('transaction_id')
                            ->label('ID Transaksi (Manual/Otomatis)')
                            ->placeholder('TRIP-XXXX / CAR-XXXX'),
                        \Filament\Forms\Components\FileUpload::make('payment_proof')
                            ->label('Unggah Bukti Pembayaran')
                            ->image()
                            ->disk('public')
                            ->directory('payment_proofs')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),
                \Filament\Schemas\Components\Section::make('Akomodasi & Logistik')
                    ->icon('heroicon-o-building-office-2')
                    ->description('Detail hotel dan informasi kedatangan.')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\Select::make('hotel_category')
                            ->label('Kategori Hotel (Pilihan Pelanggan)')
                            ->options([
                                'bintang_1' => '⭐ Bintang 1',
                                'bintang_3' => '⭐⭐⭐ Bintang 3',
                                'bintang_5' => '⭐⭐⭐⭐⭐ Bintang 5',
                                'non_hotel' => '🏠 Non Hotel',
                            ])
                            ->columnSpanFull()
                            ->native(false),
                        ...collect([1, 2, 3, 4])->map(fn ($i) =>
                            \Filament\Forms\Components\Select::make("hotel_{$i}")
                                ->label("Hotel Malam {$i}")
                                ->options(fn () => Hotel::active()->orderBy('city')->pluck('name', 'name')->toArray())
                                ->searchable()
                                ->preload()
                                ->allowHtml()
                                ->getSearchResultsUsing(fn (string $search) =>
                                    Hotel::active()
                                        ->where('name', 'like', "%{$search}%")
                                        ->orWhere('city', 'like', "%{$search}%")
                                        ->limit(20)
                                        ->get()
                                        ->pluck('name', 'name')
                                        ->toArray()
                                )
                                ->createOptionForm([
                                    \Filament\Forms\Components\TextInput::make('custom_hotel')
                                        ->label('Nama Hotel (Manual)')
                                        ->required(),
                                ])
                                ->createOptionUsing(fn (array $data) => $data['custom_hotel'])
                        )->toArray(),
                        \Filament\Forms\Components\Textarea::make('flight_info')
                            ->label('Info Penerbangan')
                            ->placeholder('Nomor pesawat, Jam kedatangan/keberangkatan...')
                            ->rows(2)
                            ->columnSpanFull(),
                        \Filament\Forms\Components\Toggle::make('use_drone')->label('Gunakan Layanan Drone')->default(false),
                    ]),
                \Filament\Schemas\Components\Section::make('Catatan Tambahan')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        \Filament\Forms\Components\Textarea::make('notes')->rows(3)->label('Catatan dari Admin/Pelanggan'),
                    ]),
            ]);
    }
}
