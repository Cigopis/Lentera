<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Spatie\Permission\Models\Role;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;

use Illuminate\Support\Facades\Auth;


class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('full_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('username')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context) => $context === 'create')
                    ->maxLength(255),

                Select::make('roles')
                ->relationship(
                    'roles',
                    'name',
                    modifyQueryUsing: function ($query) {

                        $user = \Filament\Facades\Filament::auth()->user();

                        if (! $user) {
                            return $query->whereRaw('1 = 0');
                        }

                        // PRIORITAS PERTAMA: Super Admin
                        if ($user->hasRole('super admin')) {
                            return $query; // lihat semua role
                        }

                        // PRIORITAS KEDUA: Admin
                        if ($user->hasRole('admin')) {
                            return $query->where('name', '!=', 'super admin');
                        }

                        // Staff tidak boleh assign role
                        return $query->whereRaw('1 = 0');
                    }
                )
                ->multiple(false)
                ->preload()
                ->required(),

                Toggle::make('is_active')
                    ->default(true),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

               Tables\Columns\TextColumn::make('full_name')
                ->searchable()
                ->color(fn (Employee $record) =>
                    $record->id === Filament::auth()->id()
                        ? 'primary'
                        : null
                )
                ->weight(fn (Employee $record) =>
                    $record->id === Filament::auth()->id()
                        ? 'bold'
                        : null
                )
                ->description(fn (Employee $record) =>
                    $record->id === Filament::auth()->id()
                        ? 'You'
                        : null
                ),


                Tables\Columns\TextColumn::make('username')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('roles.name')
                ->label('Role')
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'super admin' => 'info',
                    'admin' => 'success',
                    'staff' => 'warning',
                    default => 'gray',
                }),



                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->visible(function (Employee $record) {

                    // Jika bukan super admin terakhir → tampilkan normal
                    if (! $record->hasRole('super admin')) {
                        return true;
                    }

                    $superAdminCount = Employee::role('super admin')->count();

                    return $superAdminCount > 1;
                }),


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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Filament()->auth()->user()?->hasRole(['super admin', 'admin']);
    }

    
}