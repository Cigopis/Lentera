<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentProofResource\Pages;
use App\Models\Employee;
use App\Models\PaymentProof;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class PaymentProofResource extends Resource
{
    protected static ?string $model = PaymentProof::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationGroup = 'Auction Management';
    protected static ?string $navigationLabel = 'Payment Proofs';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Peserta')
                    ->schema([
                        Forms\Components\TextInput::make('user_name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('user_email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('user_phone')
                            ->label('No. Telepon')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Detail Pembayaran')
                    ->schema([
                        Forms\Components\Select::make('catalog_id')
                            ->label('Katalog Lelang')
                            ->relationship('catalog', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('payment_type')
                            ->label('Jenis Pembayaran')
                            ->options([
                                'ujl'       => 'Uang Jaminan Lelang (UJL)',
                                'pelunasan' => 'Pelunasan',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\TextInput::make('amount')
                            ->label('Nominal')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Bukti Transfer')
                    ->schema([
                        Forms\Components\FileUpload::make('proof_image')
                            ->label('File Bukti')
                            ->image()
                            ->disk('public')
                            ->directory('payment-proofs')
                            ->required()
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan dari Peserta')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Verifikasi Admin')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending'  => 'Pending',
                                'verified' => 'Terverifikasi',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),

                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Alasan Penolakan')
                            ->rows(3)
                            ->visible(fn ($get) => $get('status') === 'rejected'),

                        // Tampilan nama user yang login — hanya UI, tidak disimpan ke DB
                        Forms\Components\TextInput::make('verified_by_display')
                            ->label('Diverifikasi Oleh')
                            ->afterStateHydrated(function ($set) {
                                // Selalu isi dengan nama user yang sedang login
                                // sama seperti cara EmployeeResource cek Filament::auth()->user()
                                $set('verified_by_display', Filament::auth()->user()?->name ?? '-');
                            })
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn ($get) => $get('status') === 'verified'),

                        // Menyimpan ID user login ke database
                        Forms\Components\Hidden::make('verified_by')
                            ->afterStateHydrated(function ($set) {
                                $set('verified_by', Filament::auth()->id());
                            })
                            ->dehydrateStateUsing(fn () => Filament::auth()->id()),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Upload Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('catalog.title')
                    ->label('Catalog')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 40) return null;
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('user_name')
                    ->label('Name')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user_email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user_phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('payment_type')
                    ->label('Payment Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ujl'       => 'info',
                        'pelunasan' => 'success',
                        default     => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'ujl'       => 'UJL',
                        'pelunasan' => 'Pelunasan',
                        default     => $state,
                    }),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'  => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'  => 'Pending',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                        default    => $state,
                    }),

                Tables\Columns\ImageColumn::make('proof_image')
                    ->label('Proof Image')
                    ->disk('public')
                    ->square()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('verifier.name')
                    ->label('Verified by')
                    ->default('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('verified_at')
                    ->label('Verified At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending'  => 'Pending',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                    ]),

                Tables\Filters\SelectFilter::make('payment_type')
                    ->label('Payment Type')
                    ->options([
                        'ujl'       => 'UJL',
                        'pelunasan' => 'Pelunasan',
                    ]),

                Tables\Filters\Filter::make('pending_only')
                    ->label('Hanya Pending')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'pending'))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (PaymentProof $record) => $record->status === 'pending')
                    ->action(function (PaymentProof $record): void {
                        $record->update([
                            'status'      => 'verified',
                            'verified_by' => Filament::auth()->id(),
                            'verified_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Bukti pembayaran berhasil diverifikasi')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3),
                    ])
                    ->visible(fn (PaymentProof $record) => $record->status === 'pending')
                    ->action(function (PaymentProof $record, array $data): void {
                        $record->update([
                            'status'      => 'rejected',
                            'admin_notes' => $data['admin_notes'],
                            'verified_by' => Filament::auth()->id(),
                            'verified_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Bukti pembayaran ditolak')
                            ->warning()
                            ->send();
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('verify_bulk')
                        ->label('Verifikasi Semua')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records): void {
                            foreach ($records as $record) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'status'      => 'verified',
                                        'verified_by' => Filament::auth()->id(),
                                        'verified_at' => now(),
                                    ]);
                                }
                            }

                            Notification::make()
                                ->title('Bukti pembayaran berhasil diverifikasi')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Input Manual')
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
            'index'  => Pages\ListPaymentProofs::route('/'),
            'create' => Pages\CreatePaymentProof::route('/create'),
            'view'   => Pages\ViewPaymentProof::route('/{record}'),
            'edit'   => Pages\EditPaymentProof::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}