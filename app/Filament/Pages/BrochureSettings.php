<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use App\Models\SystemSetting;

class BrochureSettings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.brochure-settings';
    protected static ?string $navigationLabel = 'Pengaturan Brosur';
    protected static ?string $navigationGroup = 'Pengaturan Website';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'showCity'     => SystemSetting::getValue('brochure_show_city') == '1',
            'showDate'     => SystemSetting::getValue('brochure_show_date') == '1',
            'showTime'     => SystemSetting::getValue('brochure_show_time') == '1',
            'showWhatsapp' => SystemSetting::getValue('brochure_show_wa') == '1',
            'showQr'       => SystemSetting::getValue('brochure_show_qr') == '1',
            'showFooter'   => SystemSetting::getValue('brochure_show_footer') == '1',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Kontrol Tampilan Brosur')
                    ->schema([
                        Forms\Components\Toggle::make('showCity')
                            ->label('Tampilkan Kota'),

                        Forms\Components\Toggle::make('showDate')
                            ->label('Tampilkan Tanggal Lelang'),

                        Forms\Components\Toggle::make('showTime')
                            ->label('Tampilkan Jam Lelang'),

                        Forms\Components\Toggle::make('showWhatsapp')
                            ->label('Tampilkan WhatsApp'),

                        Forms\Components\Toggle::make('showQr')
                            ->label('Tampilkan QR Code'),

                        Forms\Components\Toggle::make('showFooter')
                            ->label('Tampilkan Footer'),
                    ])
            ])
            ->statePath('data');
    }

    public function save()
    {
        $state = $this->form->getState();

        $this->saveSetting('brochure_show_city', $state['showCity']);
        $this->saveSetting('brochure_show_date', $state['showDate']);
        $this->saveSetting('brochure_show_time', $state['showTime']);
        $this->saveSetting('brochure_show_wa', $state['showWhatsapp']);
        $this->saveSetting('brochure_show_qr', $state['showQr']);
        $this->saveSetting('brochure_show_footer', $state['showFooter']);

        Notification::make()
            ->title('Pengaturan Brosur Disimpan')
            ->success()
            ->send();
    }

    private function saveSetting($key, $value)
    {
        SystemSetting::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value ? '1' : '0']
        );
    }
}