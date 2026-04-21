<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuctionCatalogResource\Pages;
use App\Filament\Resources\AuctionCatalogResource\RelationManagers;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\ImageColumn;
use App\Models\AuctionCatalog;
use App\Models\CatalogImage;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Symfony\Component\HttpFoundation\StreamedResponse;

class AuctionCatalogResource extends Resource
{
    protected static ?string $model = AuctionCatalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Auction Management';
    protected static ?string $navigationLabel = 'Auction Catalogs';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Katalog Details')
                    ->tabs([
                        // TAB 1: INFORMASI DASAR
                        Forms\Components\Tabs\Tab::make('Informasi Dasar')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Section::make('Informasi Katalog')
                                    ->schema([
                                        Forms\Components\TextInput::make('catalog_code')
                                            ->label('Kode Katalog')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(50)
                                            ->placeholder('Contoh: LNT-2026-001')
                                            ->helperText('Kode unik untuk identifikasi katalog'),

                                        Forms\Components\TextInput::make('shop_number')
                                            ->label('Nomor Surat')
                                            ->maxLength(50)
                                            ->placeholder('Contoh: SHM No. 1234/Surabaya')
                                            ->helperText('Nomor Sertifikat Hak Milik (opsional)'),

                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul Katalog')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                            ->placeholder('Contoh: Rumah 2 Lantai Siap Huni di Surabaya Timur')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->disabled()
                                            ->dehydrated()
                                            ->helperText('URL-friendly version dari judul')
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('description')
                                            ->label('Deskripsi')
                                            ->required()
                                            ->placeholder('Deskripsikan aset secara detail...')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'bulletList',
                                                'orderedList',
                                            ])
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Kategori & Lokasi')
                                    ->schema([
                                        Forms\Components\Select::make('category_id')
                                            ->label('Kategori')
                                            ->required()
                                            ->options(Category::pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->live()
                                            ->afterStateUpdated(fn (Set $set) => $set('sub_category_id', null)),

                                        Forms\Components\Select::make('sub_category_id')
                                            ->label('Sub Kategori')
                                            ->options(fn (Get $get) => SubCategory::where('category_id', $get('category_id'))->pluck('name', 'id'))
                                            ->searchable()
                                            ->preload()
                                            ->disabled(fn (Get $get) => !$get('category_id')),

                                        Forms\Components\Select::make('city_id')
                                            ->label('City')
                                            ->options(
                                                City::where('is_active', true)
                                                    ->orderBy('province')
                                                    ->orderBy('name')
                                                    ->get()
                                                    ->mapWithKeys(fn ($city) => [
                                                        $city->id => "{$city->name} - {$city->province}"
                                                    ])
                                            )
                                            ->searchable()
                                            ->required(),

                                        Forms\Components\Textarea::make('address')
                                            ->label('Alamat Lengkap')
                                            ->required()
                                            ->rows(3)
                                            ->placeholder('Contoh: Jl. Raya Kenjeran No. 123, Kenjeran, Bulak')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(3),
                            ]),

                        // TAB 2: HARGA & JADWAL
                        Forms\Components\Tabs\Tab::make('Harga & Jadwal')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Forms\Components\Section::make('Informasi Harga')
                                    ->schema([
                                        Forms\Components\TextInput::make('reserve_price')
                                            ->label('Nilai Limit')
                                            ->required()
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->placeholder('2150000000')
                                            ->helperText('Harga limit/dasar lelang'),

                                        Forms\Components\TextInput::make('deposit_amount')
                                            ->label('Uang Jaminan')
                                            ->required()
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->placeholder('150000000')
                                            ->helperText('Jumlah uang jaminan yang harus disetor'),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Jadwal Lelang')
                                    ->schema([
                                        Forms\Components\DatePicker::make('auction_date')
                                            ->label('Tanggal Penutupan Lelang')
                                            ->required()
                                            ->native(false)
                                            ->displayFormat('d/m/Y')
                                            ->helperText('Tanggal saat lelang resmi ditutup')
                                            ->minDate(now()),

                                        Forms\Components\TimePicker::make('auction_time')
                                            ->label('Jam Penutupan')
                                            ->seconds(false)
                                            ->displayFormat('H:i')
                                            ->placeholder('10:00')
                                            ->helperText('Jam saat lelang ditutup · contoh: 10:00 WIB'),

                                        Forms\Components\TextInput::make('official_auction_url')
                                            ->label('Link Lelang Resmi')
                                            ->url()
                                            ->placeholder('https://lelang.go.id/catalog/xxx')
                                            ->helperText('URL ke website lelang resmi')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ]),

                        // TAB 3: SPESIFIKASI ASET
                        Forms\Components\Tabs\Tab::make('Spesifikasi Aset')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Forms\Components\Section::make('Spesifikasi Properti')
                                    ->description('Isi spesifikasi untuk properti (rumah, tanah, gedung)')
                                    ->schema([
                                        Forms\Components\TextInput::make('land_area')
                                            ->label('Luas Tanah (LT)')
                                            ->numeric()
                                            ->suffix('m²')
                                            ->placeholder('365'),

                                        Forms\Components\TextInput::make('building_area')
                                            ->label('Luas Bangunan (LB)')
                                            ->numeric()
                                            ->suffix('m²')
                                            ->placeholder('45'),

                                        Forms\Components\TextInput::make('bedrooms')
                                            ->label('Kamar Tidur')
                                            ->numeric()
                                            ->placeholder('3')
                                            ->minValue(0),

                                        Forms\Components\TextInput::make('bathrooms')
                                            ->label('Kamar Mandi')
                                            ->numeric()
                                            ->placeholder('2')
                                            ->minValue(0),

                                        Forms\Components\TextInput::make('floors')
                                            ->label('Jumlah Lantai')
                                            ->numeric()
                                            ->placeholder('1')
                                            ->minValue(1),
                                    ])
                                    ->columns(3),

                                Forms\Components\Section::make('Fasilitas & Akses')
                                    ->description('Fasilitas yang tersedia di sekitar properti')
                                    ->schema([
                                        Forms\Components\Repeater::make('facilities')
                                            ->label('Fasilitas')
                                            ->relationship('facilities')
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Nama Fasilitas')
                                                    ->required()
                                                    ->placeholder('Contoh: Bandara, ATM, Bar, Bioskop, Apotek')
                                                    ->maxLength(100),
                                            ])
                                            ->defaultItems(0)
                                            ->addActionLabel('Tambah Fasilitas')
                                            ->reorderableWithButtons()
                                            ->collapsible()
                                            ->collapsed()
                                            ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                            ->grid(2)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // TAB 4: MEDIA
                        Forms\Components\Tabs\Tab::make('Media')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\Section::make('Upload Foto Baru')
                                    ->description('Upload foto-foto aset (maks 10 foto, format otomatis dikonversi ke WebP)')
                                    ->schema([
                                        Forms\Components\FileUpload::make('catalogImages')
                                            ->label('Foto Aset')
                                            ->image()
                                            ->multiple()
                                            ->reorderable()
                                            ->directory('catalog_images')
                                            ->disk('public')
                                            ->imageEditor()
                                            ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                                            ->maxFiles(10)
                                            ->required(fn (string $operation) => $operation === 'create')
                                            ->getUploadedFileNameForStorageUsing(fn ($file) => Str::uuid() . '.webp')
                                            ->saveUploadedFileUsing(function ($file, $get, $state, $record) {
                                                $manager = new ImageManager(new Driver());
                                                $image = $manager->read($file)
                                                    ->resize(1920, null, function ($constraint) {
                                                        $constraint->aspectRatio();
                                                        $constraint->upsize();
                                                    })
                                                    ->toWebp(80);

                                                $path = 'catalog_images/' . Str::uuid() . '.webp';
                                                Storage::disk('public')->put($path, (string) $image);

                                                if ($record && $record->exists) {
                                                    $hasPrimary = CatalogImage::where('catalog_id', $record->id)
                                                        ->where('is_primary', true)
                                                        ->exists();

                                                    CatalogImage::create([
                                                        'catalog_id' => $record->id,
                                                        'image_path' => $path,
                                                        'is_primary' => !$hasPrimary,
                                                        'is_visible' => true,
                                                        'sort_order' => CatalogImage::where('catalog_id', $record->id)->max('sort_order') + 1,
                                                    ]);
                                                }

                                                return $path;
                                            })
                                            ->columnSpanFull(),
                                    ]),

                                Forms\Components\Section::make('Kelola Foto')
                                    ->description('Drag untuk ubah urutan · Klik bintang untuk set thumbnail · Toggle mata untuk sembunyikan')
                                    ->schema([
                                        Forms\Components\View::make('components.catalog-image-manager-wrapper')
                                            ->columnSpanFull(),
                                    ])
                                    ->hidden(fn ($record) => $record === null),
                            ]),

                        // TAB 5: STATUS & PENGATURAN
                        Forms\Components\Tabs\Tab::make('Status & Pengaturan')
                            ->icon('heroicon-o-cog')
                            ->schema([
                                Forms\Components\Section::make('Status Katalog')
                                    ->schema([
                                        Forms\Components\Select::make('status')
                                            ->label('Status Katalog')
                                            ->required()
                                            ->options(AuctionCatalog::statusOptions())
                                            ->default(AuctionCatalog::STATUS_DRAFT)
                                            ->native(false)
                                            ->helperText('
                                                Tersedia = lelang sedang berjalan · 
                                                Terjual = ada pemenang, tanggal mungkin masih berjalan · 
                                                Tutup = lelang dibatalkan/ditutup tanpa pemenang
                                            '),

                                        Forms\Components\Toggle::make('is_featured')
                                            ->label('Katalog Unggulan')
                                            ->helperText('Tampilkan di halaman utama sebagai katalog unggulan')
                                            ->default(false),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Informasi Sistem')
                                    ->schema([
                                        Forms\Components\Placeholder::make('created_at')
                                            ->label('Dibuat Pada')
                                            ->content(fn ($record) => $record?->created_at ? $record->created_at->format('d/m/Y H:i') : '-'),

                                        Forms\Components\Placeholder::make('updated_at')
                                            ->label('Terakhir Diubah')
                                            ->content(fn ($record) => $record?->updated_at ? $record->updated_at->format('d/m/Y H:i') : '-'),

                                        Forms\Components\Placeholder::make('created_by')
                                            ->label('Dibuat Oleh')
                                            ->content(fn ($record) => $record?->creator?->name ?? '-'),

                                        Forms\Components\Placeholder::make('deadline_info')
                                            ->label('Info Deadline')
                                            ->content(function ($record) {
                                                if (!$record || !$record->auction_date) return '-';

                                                $daysLeft = $record->getDaysUntilAuction();

                                                $icon = match (true) {
                                                    $daysLeft < 0   => '⚫',
                                                    $daysLeft === 0 => '🔴',
                                                    $daysLeft === 1 => '🟠',
                                                    $daysLeft <= 7  => '🟡',
                                                    default         => '🟢',
                                                };

                                                $note = ($daysLeft === 0 || $daysLeft === 1)
                                                    ? ' — Akan hilang dari listing publik'
                                                    : '';

                                                return $icon . ' ' . $record->getDeadlineStatus() . $note;
                                            }),
                                    ])
                                    ->columns(2)
                                    ->hidden(fn ($record) => $record === null),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('catalog_code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Kode berhasil disalin!')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) <= 50 ? null : $state;
                    }),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Bangunan'  => 'info',
                        'Tanah'     => 'success',
                        'Kendaraan' => 'warning',
                        default     => 'gray',
                    }),

                Tables\Columns\TextColumn::make('city.name')
                    ->label('City')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('reserve_price')
                    ->label('Limit Value')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('auction_date')
                    ->label('Auction Date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->description(function (AuctionCatalog $record): ?string {
                        if (!$record->auction_date) return null;

                        $daysLeft = $record->getDaysUntilAuction();

                        $icon = match (true) {
                            $daysLeft < 0   => '⚫',
                            $daysLeft === 0 => '🔴',
                            $daysLeft === 1 => '🟠',
                            $daysLeft <= 7  => '🟡',
                            default         => '🟢',
                        };

                        return $icon . ' ' . $record->getDeadlineStatus();
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        AuctionCatalog::STATUS_DRAFT   => 'gray',
                        AuctionCatalog::STATUS_ACTIVE  => 'success',
                        AuctionCatalog::STATUS_SOLD    => 'warning',   // amber/kuning
                        AuctionCatalog::STATUS_CLOSED  => 'danger',
                        default                        => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        AuctionCatalog::STATUS_DRAFT   => 'Draft',
                        AuctionCatalog::STATUS_ACTIVE  => 'Tersedia',
                        AuctionCatalog::STATUS_SOLD    => 'Terjual',
                        AuctionCatalog::STATUS_CLOSED  => 'Tutup',
                        default                        => $state,
                    }),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->preload(),

                Tables\Filters\SelectFilter::make('city_id')
                    ->label('City')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(AuctionCatalog::statusOptions()),

                Tables\Filters\Filter::make('is_featured')
                    ->label('Featured')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true)),

                Tables\Filters\Filter::make('deadline_soon')
                    ->label('H-1 Lelang (Akan Hilang)')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereDate('auction_date', '=', Carbon::tomorrow())
                              ->orWhereDate('auction_date', '=', Carbon::today())
                    )
                    ->toggle(),

                Tables\Filters\Filter::make('upcoming_week')
                    ->label('Lelang Minggu Ini')
                    ->query(fn (Builder $query): Builder =>
                        $query->whereBetween('auction_date', [
                            Carbon::today(),
                            Carbon::today()->addWeek(),
                        ])
                    )
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('change_status')
                    ->label('Ubah Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status Baru')
                            ->options(AuctionCatalog::statusOptions())
                            ->required()
                            ->native(false)
                            ->helperText('Terjual = ada pemenang · Tutup = dibatalkan/ditutup tanpa pemenang'),
                    ])
                    ->action(function (AuctionCatalog $record, array $data): void {
                        $record->update(['status' => $data['status']]);

                        Notification::make()
                            ->title('Status berhasil diubah menjadi ' . AuctionCatalog::statusOptions()[$data['status']])
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('download_brochure')
                    ->label('Download Brosur')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        $pdfContent = app(\App\Services\BrochureService::class)->generate($record);

                        return response()->streamDownload(
                            fn () => print($pdfContent),
                            'brosur-' . $record->slug . '.pdf'
                        );
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan (Tersedia)')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['status' => AuctionCatalog::STATUS_ACTIVE])),

                    Tables\Actions\BulkAction::make('mark_sold')
                        ->label('Tandai Terjual')
                        ->icon('heroicon-o-trophy')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['status' => AuctionCatalog::STATUS_SOLD])),

                    Tables\Actions\BulkAction::make('close')
                        ->label('Tandai Tutup')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['status' => AuctionCatalog::STATUS_CLOSED])),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Katalog Pertama')
                    ->icon('heroicon-o-plus'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAuctionCatalogs::route('/'),
            'create' => Pages\CreateAuctionCatalog::route('/create'),
            'edit'   => Pages\EditAuctionCatalog::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()
            ->whereDate('auction_date', '=', Carbon::tomorrow())
            ->orWhereDate('auction_date', '=', Carbon:: today())
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}