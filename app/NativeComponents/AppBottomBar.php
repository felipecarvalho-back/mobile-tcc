<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class AppBottomBar extends NativeComponent
{
    public string $active = 'monitoring'; // 'monitoring' | 'capture' | 'history' | 'profile'

    public function goToMonitoring(): void
    {
        $this->navigate('/monitoramento');
    }

    public function goToCapture(): void
    {
        $this->navigate('/capturar');
    }

    public function goToHistory(): void
    {
        $this->navigate('/historico');
    }

    public function goToProfile(): void
    {
        $this->navigate('/perfil');
    }

    public function render(): View
    {
        return view('native.app-bottom-bar');
    }
}
