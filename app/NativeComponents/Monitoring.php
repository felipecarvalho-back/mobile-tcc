<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class Monitoring extends NativeComponent
{
    public string $operatorName = 'Operador Guarita';

    public string $stationName = 'Terminal da Guarita • Posto Principal';

    public string $terminalId = 'GDA - 104';

    public string $gateStatus = 'Cancela 01: OPERACIONAL';

    public string $currentTime = '14:35:21';

    public int $totalPassages = 412;

    public int $autoReleases = 389;

    public int $plateCorrections = 17;

    public int $campusBalance = 27;

    public function goToCapture(): void
    {
        $this->replace('/capturar')->transition(Transition::Fade);
    }

    public function goToHistory(): void
    {
        $this->replace('/historico')->transition(Transition::Fade);
    }

    public function goToProfile(): void
    {
        $this->replace('/perfil')->transition(Transition::Fade);
    }

    public function render(): View
    {
        return view('native.monitoring');
    }
}
