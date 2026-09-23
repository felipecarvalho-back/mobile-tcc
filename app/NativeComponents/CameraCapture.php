<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

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
        $this->navigate('/monitoramento');
    }

    public function toggleFlash(): void
    {
        $this->flashOn = ! $this->flashOn;
    }

    public function flipCamera(): void
    {
        // Alternância de câmera
    }

    public function capture(): void
    {
        $this->isCapturing = true;
        $this->navigate('/monitoramento');
    }

    public function openLastCapture(): void
    {
        $this->navigate('/historico');
    }

    public function render(): View
    {
        return view('native.camera-capture');
    }
}
