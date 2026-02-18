<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\RelationManagers\SubCategoriesRelationManager;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-funnel';
    protected static ?string $navigationGroup = 'Auction Management';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => 
                        $set('slug', Str::slug($state))
                    ),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(100),

                Forms\Components\Select::make('icon')
                ->label('Icon')
                ->options([
                    'heroicon-o-home' => 'Home',
                    'heroicon-o-tag' => 'Tag',
                    'heroicon-o-cube' => 'Cube',
                    'heroicon-o-shopping-bag' => 'Shopping Bag',
                    'heroicon-o-building-storefront' => 'Store',
                    'heroicon-o-archive-box' => 'Archive',
                    'heroicon-o-globe-alt' => 'Globe',
                ])
                ->searchable()
                ->live()
                ->nullable(),

                Forms\Components\Placeholder::make('icon_preview')
                ->label('Icon Preview')
                ->content(function (callable $get) {
                    $icon = $get('icon');

                    if (!$icon) {
                        return 'No icon selected';
                    }

                    return new \Illuminate\Support\HtmlString(
                        "<div class='flex items-center gap-2'>
                            <x-filament::icon icon='{$icon}' class='w-8 h-8 text-primary-600' />
                            <span>{$icon}</span>
                        </div>"
                    );
                }),



                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),

                Tables\Columns\IconColumn::make('icon')
                ->label('Icon')
                ->icon(fn ($record) => $record->icon)
                ->color('primary'),


                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            SubCategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
