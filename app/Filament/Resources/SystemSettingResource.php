<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SystemSettingResource\Pages;
use App\Models\SystemSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SystemSettingResource extends Resource
{
    protected static ?string $model = SystemSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ===== KOLOM KIRI: Form Input =====
                Forms\Components\Section::make('Setting')
                    ->schema([
                        Forms\Components\TextInput::make('setting_key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->helperText('Gunakan key yang sesuai dari tabel referensi di samping.'),

                        Forms\Components\Textarea::make('setting_value')
                            ->label('Value')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1),

                // ===== KOLOM KANAN: Referensi Setting Key =====
                Forms\Components\Section::make('📋 Daftar Setting Key')
                    ->description('Gunakan key berikut sesuai kebutuhan.')
                    ->schema([
                        Forms\Components\Placeholder::make('reference')
                            ->label('')
                            ->content(function () {
                                $keys = [
                                    // Hero Section
                                    ['key' => 'titleHero',          'desc' => 'Judul utama di hero section halaman beranda'],
                                    ['key' => 'descriptionHero',    'desc' => 'Deskripsi/subjudul di bawah judul hero'],

                                    // General
                                    ['key' => 'siteName',           'desc' => 'Nama website/aplikasi'],
                                    ['key' => 'siteTagline',        'desc' => 'Tagline singkat website'],
                                    ['key' => 'contactWhatsapp',    'desc' => 'Nomor WhatsApp untuk tombol hubungi kami'],
                                    ['key' => 'contactEmail',       'desc' => 'Email kontak yang ditampilkan'],
                                    ['key' => 'contactAddress',     'desc' => 'Alamat kantor'],

                                    // Footer
                                    ['key' => 'footerText',         'desc' => 'Teks copyright/info di footer'],
                                    ['key' => 'footerDescription',  'desc' => 'Deskripsi singkat di footer'],

                                    // Social Media
                                    ['key' => 'socialInstagram',    'desc' => 'URL Instagram'],
                                    ['key' => 'socialFacebook',     'desc' => 'URL Facebook'],
                                    ['key' => 'socialYoutube',      'desc' => 'URL YouTube'],
                                ];

                                $rows = collect($keys)->map(function ($item) {
                                    return '
                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                            <td class="py-2 pr-4">
                                                <code class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded font-mono">
                                                    ' . $item['key'] . '
                                                </code>
                                            </td>
                                            <td class="py-2 text-sm text-gray-600">
                                                ' . $item['desc'] . '
                                            </td>
                                        </tr>
                                    ';
                                })->join('');

                                return new \Illuminate\Support\HtmlString('
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left">
                                            <thead>
                                                <tr class="border-b-2 border-gray-200">
                                                    <th class="pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wide pr-4">Setting Key</th>
                                                    <th class="pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wide">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ' . $rows . '
                                            </tbody>
                                        </table>
                                    </div>
                                ');
                            }),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('setting_key')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('setting_value')
                    ->limit(60)
                    ->wrap(),

                Tables\Columns\TextColumn::make('updater.name')
                    ->label('Updated By')
                    ->default('-'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSystemSettings::route('/'),
            'create' => Pages\CreateSystemSetting::route('/create'),
            'edit'   => Pages\EditSystemSetting::route('/{record}/edit'),
        ];
    }
}