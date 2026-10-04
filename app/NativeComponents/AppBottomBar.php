<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class AppBottomBar extends NativeComponent
{
    public string $active = 'capture'; // 'capture' | 'history' | 'profile' | 'monitoring'

    public string $transitionType = 'none'; // 'none' | 'fade' | 'slide_from_bottom' | 'slide_from_right'

    protected function resolveTransition(): Transition
    {
        return match ($this->transitionType) {
            'fade' => Transition::Fade,
            'slide_from_bottom' => Transition::SlideFromBottom,
            'slide_from_right' => Transition::SlideFromRight,
            default => Transition::None,
        };
    }

    public function goToCapture(): void
    {
        if ($this->active === 'capture') {
            return;
        }

        $this->replace('/capturar')->transition($this->resolveTransition());
    }

    public function goToHistory(): void
    {
        if ($this->active === 'history') {
            return;
        }

        $this->replace('/historico')->transition($this->resolveTransition());
    }

    public function goToProfile(): void
    {
        if ($this->active === 'profile') {
            return;
        }

        $this->replace('/perfil')->transition($this->resolveTransition());
    }

    public function goToMonitoring(): void
    {
        if ($this->active === 'monitoring') {
            return;
        }

        $this->replace('/monitoramento')->transition($this->resolveTransition());
    }

    public function render(): View
    {
        return view('native.app-bottom-bar');
    }
}
