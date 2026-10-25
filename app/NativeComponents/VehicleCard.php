<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class VehicleCard extends NativeComponent
{
    public string $plate = '';

    public bool $plateIdentified = false;

    public string $photo = '';

    public int $ocr = 0;

    public string $title = '';

    public string $subtitle = '';

    public string $status = 'waiting'; // 'waiting' | 'authorized' | 'unregistered'

    public string $statusLabel = '';

    public string $time = '';

    public bool $corrected = false;

    public int $photosCount = 0;

    public bool $showPhoto = false;

    public function togglePhoto(): void
    {
        if (blank($this->photo)) {
            return;
        }

        $this->showPhoto = ! $this->showPhoto;
    }

    public function render(): View
    {
        return view('native.vehicle-card');
    }
}
