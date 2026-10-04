<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class CameraCapture extends NativeComponent
{
    public string $gateTitle = 'Cancela 01 • Entrada Principal';

    public string $terminalId = 'GDA - 104';

    public string $detectedPlate = 'BRA - 2819';

    public string $lastPlate = 'ABC-1234';

    public int $lastPlateBadge = 2;

    public bool $flashOn = true;

    public bool $isCapturing = false;

    public function close(): void
    {
        $this->replace('/historico')->transition(Transition::Fade);
    }

    public function toggleFlash(): void
    {
        $this->flashOn = ! $this->flashOn;
    }

    public function flipCamera(): void
    {
        // Alternância de câmera frontal/traseira
    }

    public function capture(): void
    {
        $this->isCapturing = true;
        $this->replace('/historico')->transition(Transition::Fade);
    }

    public function openLastCapture(): void
    {
        $this->replace('/historico')->transition(Transition::Fade);
    }

    public function render(): View
    {
        return view('native.camera-capture');
    }
}
