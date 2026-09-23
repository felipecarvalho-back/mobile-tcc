<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class VehicleCard extends NativeComponent
{
    public string $plate = '';

    public int $ocr = 0;

    public string $title = '';

    public string $subtitle = '';

    public string $status = 'waiting'; // 'waiting' | 'authorized' | 'unregistered'

    public string $statusLabel = '';

    public string $time = '';

    public bool $corrected = false;

    public int $photosCount = 0;

    public function render(): View
    {
        return view('native.vehicle-card');
    }
}
