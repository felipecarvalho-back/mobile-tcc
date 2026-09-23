<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

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

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $queue = [
        [
            'plate' => 'BRA-2819',
            'ocr' => 72,
            'title' => 'Possível Prof. Dr. Marcos Souza',
            'subtitle' => 'Docente DSM — Desenv. de Software',
            'status' => 'waiting',
            'statusLabel' => 'Aguardando Liberação',
            'time' => '14:32:05',
            'corrected' => false,
            'photosCount' => 0,
        ],
        [
            'plate' => 'ABC-1234',
            'ocr' => 99,
            'title' => 'Carlos Silva',
            'subtitle' => 'Manutenção Predial (Prestador) • Tag Ativa',
            'status' => 'authorized',
            'statusLabel' => 'Autorizado',
            'time' => '14:28:40',
            'corrected' => false,
            'photosCount' => 0,
        ],
        [
            'plate' => 'FKX-9A42',
            'ocr' => 88,
            'title' => 'Veículo Não Cadastrado',
            'subtitle' => 'Motocicleta Entregador / Visitante Eventual',
            'status' => 'unregistered',
            'statusLabel' => 'Não Cadastrado',
            'time' => '14:21:12',
            'corrected' => false,
            'photosCount' => 0,
        ],
    ];

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
        return view('native.monitoring');
    }
}
