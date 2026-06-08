<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->poll('30s')

            ->columns([
                TextColumn::make('created_at')
                    ->label('Tgl Pesan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->description(fn ($record) => "{$record->customer_phone} — {$record->customer_email}")
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->vehicle_id ? 'Mobil' : ($record->rental_package_id ? 'Paket Rental' : 'Paket Wisata'))
                    ->color(fn (string $state): string => match ($state) {
                        'Mobil' => 'warning',
                        'Paket Rental' => 'info',
                        'Paket Wisata' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('item')
                    ->label('Item')
                    ->getStateUsing(fn ($record) => $record->vehicle?->name ?? $record->rentalPackage?->name ?? $record->product?->name ?? '-')
                    ->wrap()
                    ->limit(40),
                TextColumn::make('trip_date')
                    ->label('Tgl Trip')
                    ->date('d M Y')
                    ->sortable()
                    ->color('primary'),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR', true)
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),
                ImageColumn::make('payment_proof')
                    ->label('Bukti')
                    ->circular()
                    ->placeholder('Belum ada'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label('Bayar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'paid' => 'success',
                        'partial' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'unpaid' => 'Belum Lunas',
                        'paid' => 'Lunas',
                        'partial' => 'DP',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('transaction_id')
                    ->label('ID Transaksi')
                    ->placeholder('-')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('payment_status')
                    ->label('Status Bayar')
                    ->options([
                        'unpaid' => 'Belum Lunas',
                        'paid' => 'Lunas',
                        'partial' => 'DP (Sebagian)',
                    ]),
                Filter::make('created_at_month')
                    ->form([
                        Select::make('month')
                            ->label('Bulan')
                            ->options([
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                            ]),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when($data['month'], fn ($query, $month) => $query->whereMonth('created_at', $month));
                    }),
                Filter::make('created_at_year')
                    ->form([
                        Select::make('year')
                            ->label('Tahun')
                            ->options(array_combine(range(now()->year, now()->year - 5), range(now()->year, now()->year - 5)))
                            ->default(now()->year),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when($data['year'], fn ($query, $year) => $query->whereYear('created_at', $year));
                    }),
                Filter::make('is_vehicle')
                    ->label('Sewa Mobil')
                    ->query(fn ($query) => $query->whereNotNull('vehicle_id')),
                Filter::make('is_product')
                    ->label('Paket Wisata')
                    ->query(fn ($query) => $query->whereNotNull('product_id')),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('invoice')
                    ->label('Invoice')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->url(fn ($record) => route('order.invoice', $record->id))
                    ->openUrlInNewTab(),
                Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->url(fn ($record) => route('order.invoice', $record->id))
                    ->openUrlInNewTab(),
                Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn ($record) => 'https://wa.me/'.preg_replace('/\D/', '', $record->customer_phone).'?text='.urlencode("Halo {$record->customer_name}, kami ingin menginformasikan status pesanan Anda #ORD-".str_pad($record->id, 5, '0', STR_PAD_LEFT).' saat ini adalah '.strtoupper($record->status).'.'))
                    ->openUrlInNewTab(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
