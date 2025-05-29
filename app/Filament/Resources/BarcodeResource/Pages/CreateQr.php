<?php

namespace App\Filament\Resources\BarcodeResource\Pages;

use App\Filament\Resources\BarcodeResource;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Page;
use App\Models\Barcode;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CreateQr extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = BarcodeResource::class;
    protected static string $view = 'filament.resources.barcode-resource.pages.create-qr';

    public array $formData = [];

    public function mount(): void
    {
        $generated = strtoupper(chr(rand(65, 90)) . rand(1000, 9999));
        $this->formData = [
            'table_number' => $generated,
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('formData')
            ->schema([
                TextInput::make('table_number')
                    ->label('Table number')
                    ->required()
                    ->disabled(),
            ]);
    }

    public function save(): void
    {
        $tableNumber = $this->formData['table_number'];
        $host = $_SERVER['HTTP_HOST'] . '/' . $tableNumber;
        $svgContent = QrCode::margin(1)->size(200)->generate($host);
        $svgFilePath = 'qr_codes/' . $tableNumber . '.svg';

        Storage::disk('public')->put($svgFilePath, $svgContent);

        Barcode::create([
            'table_number' => $tableNumber,
            'user_id' => Auth::user()->id,
            'image' => $svgFilePath,
            'qr_value' => $host,
        ]);

        Notification::make()
            ->success()
            ->title('QR Code Generated')
            ->icon('heroicon-o-check-circle')
            ->send();

        $this->redirect('/admin/barcodes');
    }
}
