<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannersResource\Pages;
use App\Filament\Resources\BannersResource\RelationManagers;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use App\Models\Banners;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;


use Illuminate\Support\Str;
use Filament\Forms\Get;
use Filament\Forms\Components\Radio;

class BannersResource extends Resource
{
    protected static ?string $model = Banners::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 1;




    public static function form(Form $form): Form
    {
        return $form->schema([

            TextInput::make('title')
            ->nullable()
            ->maxLength(255),


            Radio::make('aspect_ratio')
            ->label('Aspect Ratio')
            ->options([
                'ultrawide' => 'Hero Ultrawide (21:9 - Recommended)',
                'custom'    => 'Custom (No Crop)',
            ])
            ->default('ultrawide')
            ->required()
            ->inline(),

            Toggle::make('is_active')
                ->default(true),

            Select::make('type')
                ->label('Banner Type')
                ->options([
                    'hero'  => 'Hero Banner',
                    'promo' => 'Promotional Banner',
                ])
                ->default('hero')
                ->required(),



            FileUpload::make('image_path')
                ->label('Banner Image')
                ->image()
                ->directory('banners')
                ->disk('public')
                ->imageEditor()
                ->imageEditorAspectRatios([
                    '21:9',
                    '16:9',
                    '1:1',
                ])

                ->maxSize(2048)
                ->getUploadedFileNameForStorageUsing(function ($file) {
                    return Str::uuid() . '.webp';
                })
                ->saveUploadedFileUsing(function ($file, Get $get) {

                $manager = new ImageManager(new Driver());

                $ratio = $get('aspect_ratio');

                if ($ratio === 'custom') {

                    $image = $manager->read($file)
                        ->toWebp(80);

                } else {
                    $image = $manager->read($file)
                        ->cover(1920, 820) 
                        ->toWebp(80);
                }

                $path = 'banners/' . Str::uuid() . '.webp';

                Storage::disk('public')->put($path, (string) $image);

                return $path;

            })

            ->required(),

            TextInput::make('link_url')
                ->label('Link URL')
                ->url()
                ->nullable(),

            Select::make('catalog_id')
                ->relationship('catalog', 'title')
                ->searchable()
                ->preload()
                ->nullable(),

            Toggle::make('is_active')
                ->default(true),

        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('type')
            ->label('Banner Type')
            ->badge()
            ->color('primary'),

            ImageColumn::make('image_path')
                ->label('Image'),

            TextColumn::make('aspect_ratio')
            ->badge()
            ->color('info'),


            TextColumn::make('title')
                ->searchable()
                ->sortable(),

            TextColumn::make('catalog.title')
                ->label('Catalog')
                ->sortable(),

            TextColumn::make('creator.name')
                ->label('Created By'),

            IconColumn::make('is_active')
                ->boolean(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanners::route('/create'),
            'edit' => Pages\EditBanners::route('/{record}/edit'),
        ];
    }

    
}
