<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Katalog Produk';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'Paket Wisata';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Paket Wisata';

    protected static ?string $pluralModelLabel = 'Paket Wisata';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([

                // ─────────────────────────────────────────────────────────────
                // 1. IDENTITAS PAKET  (ditampilkan di kartu listing & header detail)
                // ─────────────────────────────────────────────────────────────
                // 1. IDENTITAS PAKET
                Schemas\Components\Section::make('Identitas Paket')
                    ->icon('heroicon-o-identification')
                    ->description('Informasi utama yang tampil di kartu listing dan halaman detail.')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->options(fn () => Category::query()
                                ->where('is_active', true)
                                ->orderBy('sort_order')
                                ->pluck('name', 'id'))
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Paket Wisata')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                            ->placeholder('Contoh: Wisata Danau Toba 2D1N')
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Otomatis terisi dari nama. URL: /product/kategori/slug')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('location_tag')
                            ->label('Tag Lokasi')
                            ->maxLength(255)
                            ->placeholder('Contoh: Samosir, Sumatera Utara')
                            ->helperText('Tampil sebagai badge di atas foto')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('pre_order_info')
                            ->label('Label Pre Order')
                            ->maxLength(100)
                            ->placeholder('Contoh: Pre Order')
                            ->helperText('Tampil sebagai badge oranye di pojok foto')
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('duration')
                            ->label('Durasi Perjalanan')
                            ->placeholder('Contoh: 2 Hari 1 Malam')
                            ->columnSpanFull(),
                    ]),

                // 2. FOTO
                Schemas\Components\Section::make('Foto Paket')
                    ->icon('heroicon-o-camera')
                    ->description('Foto utama tampil di kartu listing. Galeri tampil sebagai thumbnail di halaman detail.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Banner Utama (Bisa Lebih dari 1)')
                            ->disk('public')
                            ->directory('products')
                            ->visibility('public')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->imagePreviewHeight('200')
                            ->required()
                            ->helperText('Jika lebih dari satu, akan tampil sebagai slider di halaman detail'),

                        Forms\Components\FileUpload::make('gallery_images')
                            ->label('Galeri Foto')
                            ->disk('public')
                            ->directory('products/gallery')
                            ->visibility('public')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->imagePreviewHeight('150')
                            ->helperText('Foto tambahan yang tampil sebagai thumbnail di halaman detail'),
                    ]),

                // 3. HARGA
                Schemas\Components\Section::make('Harga')
                    ->icon('heroicon-o-banknotes')
                    ->description('Isi harga per orang untuk setiap jumlah peserta. Harga tampil di kartu listing diambil dari baris pertama dan terakhir.')
                    ->schema([
                        Forms\Components\Repeater::make('pricing_details')
                            ->label('Tabel Harga per Orang')
                            ->schema([
                                Forms\Components\TextInput::make('pax')
                                    ->label('Jumlah Peserta (Orang)')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->placeholder('Contoh: 2'),
                                Forms\Components\TextInput::make('price_per_person')
                                    ->label('Harga per Orang (Rp)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required()
                                    ->placeholder('Contoh: 500000'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel('+ Tambah Baris Harga')
                            ->helperText('Harga ditampilkan ke pelanggan berdasarkan jumlah peserta yang dipilih. Urutan bebas.')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (empty($state)) {
                                    return;
                                }
                                $prices = array_filter(array_column($state, 'price_per_person'));
                                if (! empty($prices)) {
                                    $set('price_min', min($prices));
                                    $set('price_max', max($prices));
                                }
                            }),

                        Schemas\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('price_min')
                                ->label('Harga Dewasa Terendah (auto)')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->helperText('Otomatis diisi dari tabel harga di atas'),

                            Forms\Components\TextInput::make('price_max')
                                ->label('Harga Dewasa Tertinggi (auto)')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->helperText('Otomatis diisi dari tabel harga di atas'),
                        ]),

                        Schemas\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('child_price')
                                ->label('Harga Anak-anak (8 Thn Kebawah)')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->helperText('Harga flat per anak (8 tahun kebawah)'),

                            Forms\Components\TextInput::make('price_display')
                                ->label('Teks Harga Custom')
                                ->placeholder('Contoh: Mulai Rp 500.000/pax')
                                ->helperText('Opsional — kosongkan untuk gunakan format otomatis'),
                        ]),
                    ]),

                // 4. DESKRIPSI
                Schemas\Components\Section::make('Deskripsi')
                    ->icon('heroicon-o-document-text')
                    ->description('Short description tampil tepat di bawah harga. Deskripsi lengkap di dalam tab.')
                    ->schema([
                        Forms\Components\Textarea::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->placeholder('1–2 kalimat ringkasan paket yang muncul di bawah harga')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('description')
                            ->label('Deskripsi Lengkap')
                            ->required()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline',
                                'bulletList', 'orderedList',
                                'h2', 'h3',
                                'link', 'blockquote',
                            ])
                            ->columnSpanFull(),
                    ]),

                // 5. ITINERARY
                Schemas\Components\Section::make('Itinerary (Jadwal Perjalanan)')
                    ->icon('heroicon-o-map')
                    ->description('Tampil di Brosur PDF dan Timeline (jika aktif). Gunakan kolom ini untuk detail hari demi hari.')
                    ->schema([
                        Forms\Components\Repeater::make('itinerary')
                            ->label('Jadwal Harian')
                            ->schema([
                                Forms\Components\TextInput::make('day')->label('Hari Ke')->placeholder('Contoh: 1')->required(),
                                Forms\Components\TextInput::make('title')->label('Tujuan/Judul')->placeholder('Contoh: Penjemputan di Kualanamu')->required(),
                                Forms\Components\Textarea::make('description')->label('Detail Kegiatan')->rows(3),
                            ])
                            ->collapsible()
                            ->reorderable()
                            ->addActionLabel('+ Tambah Hari')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('itinerary_text')
                            ->label('Isi Itinerary (Teks Bebas)')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline',
                                'bulletList', 'orderedList',
                                'h2', 'h3',
                                'blockquote',
                            ])
                            ->placeholder('Opsi cadangan: Tuliskan jadwal perjalanan secara bebas jika tidak ingin menggunakan format struktural di atas.')
                            ->columnSpanFull(),
                    ]),

                // 5a. LAYANAN TAMBAHAN
                Schemas\Components\Section::make('Layanan Drone (Opsional)')
                    ->icon('heroicon-o-video-camera')
                    ->description('Detail untuk paket video/foto cinematic menggunakan drone.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('drone_price')
                            ->label('Biaya Tambahan Drone')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(1500000),
                        Forms\Components\TextInput::make('drone_location')
                            ->label('Lokasi Drone')
                            ->placeholder('Contoh: Bukit Cinta & Holbung')
                            ->helperText('Lokasi spesifik di mana drone akan digunakan'),
                    ]),

                // 6. FASILITAS
                Schemas\Components\Section::make('Fasilitas & Catatan')
                    ->icon('heroicon-o-list-bullet')
                    ->description('Tampil di tab "NOTE" pada halaman detail.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TagsInput::make('includes')
                            ->label('Sudah Termasuk (Includes)')
                            ->placeholder('Contoh: Transportasi AC, Guide, Tiket masuk')
                            ->helperText('Tekan Enter setelah setiap item'),

                        Forms\Components\TagsInput::make('excludes')
                            ->label('Tidak Termasuk (Excludes)')
                            ->placeholder('Contoh: Biaya pribadi, Tip guide')
                            ->helperText('Tekan Enter setelah setiap item'),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Penting')
                            ->rows(4)
                            ->placeholder('Persyaratan, informasi penting, perhatian khusus untuk wisatawan...')
                            ->columnSpanFull(),
                    ]),

                // 7. STATUS & URUTAN
                Schemas\Components\Section::make('Status & Urutan')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->description('Kontrol visibilitas dan urutan tampil di halaman listing.')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif (tampil di website)')
                            ->default(true),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Unggulan (tampil di halaman utama)')
                            ->default(false),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka kecil tampil lebih dulu'),
                    ]),

                // 9. SEO
                Schemas\Components\Section::make('SEO (Opsional)')
                    ->icon('heroicon-o-magnifying-glass')
                    ->description('Judul dan deskripsi yang muncul di hasil pencarian Google. Kosongkan untuk menggunakan nama & short description.')
                    ->collapsed()
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->placeholder('Judul halaman untuk Google (maks. 60 karakter)'),

                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(2)
                            ->maxLength(160)
                            ->placeholder('Deskripsi singkat untuk Google (maks. 160 karakter)'),
                    ]),

                // 10. TERJEMAHAN
                Schemas\Components\Section::make('Terjemahan (Bahasa Asing)')
                    ->icon('heroicon-o-language')
                    ->description('Isi konten dalam bahasa Inggris dan Melayu.')
                    ->collapsed()
                    ->schema([
                        Schemas\Components\Tabs::make('Translations')
                            ->tabs([
                                Schemas\Components\Tabs\Tab::make('English (EN)')
                                    ->schema([
                                        Forms\Components\TextInput::make('translations.en.name')->label('Judul Paket (EN)'),
                                        Forms\Components\TextInput::make('translations.en.duration')->label('Durasi (EN)'),
                                        Forms\Components\Textarea::make('translations.en.short_description')->label('Deskripsi Singkat (EN)'),
                                        Forms\Components\RichEditor::make('translations.en.description')->label('Deskripsi Lengkap (EN)'),
                                        Forms\Components\TagsInput::make('translations.en.includes')->label('Includes (EN)'),
                                        Forms\Components\TagsInput::make('translations.en.excludes')->label('Excludes (EN)'),
                                        Forms\Components\Textarea::make('translations.en.notes')->label('Catatan/Notes (EN)'),
                                        Forms\Components\RichEditor::make('translations.en.itinerary_text')->label('Isi Itinerary Text (EN)'),
                                    ]),
                                Schemas\Components\Tabs\Tab::make('Malaysia (MS)')
                                    ->schema([
                                        Forms\Components\TextInput::make('translations.ms.name')->label('Judul Paket (MS)'),
                                        Forms\Components\TextInput::make('translations.ms.duration')->label('Durasi (MS)'),
                                        Forms\Components\Textarea::make('translations.ms.short_description')->label('Deskripsi Singkat (MS)'),
                                        Forms\Components\RichEditor::make('translations.ms.description')->label('Deskripsi Lengkap (MS)'),
                                        Forms\Components\TagsInput::make('translations.ms.includes')->label('Includes (MS)'),
                                        Forms\Components\TagsInput::make('translations.ms.excludes')->label('Excludes (MS)'),
                                        Forms\Components\Textarea::make('translations.ms.notes')->label('Catatan/Notes (MS)'),
                                        Forms\Components\RichEditor::make('translations.ms.itinerary_text')->label('Isi Itinerary Text (MS)'),
                                    ]),
                            ])->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Foto')
                    ->circular()
                    ->limit(1),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Paket')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->description(fn (Product $record): string => $record->category?->name ?? 'Tanpa Kategori'),
                Tables\Columns\TextColumn::make('price_min')
                    ->label('Harga Mulai')
                    ->money('IDR', true)
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Update Terakhir')
                    ->dateTime()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Status Unggulan'),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy('sort_order');
    }
}
