<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class History extends NativeComponent
{
    public string $search = '';

    public string $selectedFilter = 'hoje';

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $todayCaptures = [
        [
            'plate' => 'BRA-2819',
            'ocr' => 72,
            'title' => 'Possível Prof. Dr. Marcos Souza',
            'subtitle' => 'Docente DSM — Desenv. de Software',
            'status' => 'waiting',
            'statusLabel' => 'Aguardando Liberação',
            'time' => '14:32:05',
            'corrected' => false,
            'photosCount' => 2,
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
        [
            'plate' => 'GTR-4C88',
            'ocr' => 98,
            'title' => 'Profa. Dra. Juliana Rezende',
            'subtitle' => 'Docente GTI • Vaga Docente Reservada',
            'status' => 'authorized',
            'statusLabel' => 'Autorizado',
            'time' => '14:14:02',
            'corrected' => true,
            'photosCount' => 0,
        ],
    ];

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $yesterdayCaptures = [
        [
            'plate' => 'FTC-1090',
            'ocr' => 96,
            'title' => 'Prof. Dr. Marcos Souza',
            'subtitle' => 'Docente DSM — Honda Civic Preto',
            'status' => 'authorized',
            'statusLabel' => 'Autorizado',
            'time' => '18:45:10',
            'corrected' => false,
            'photosCount' => 0,
        ],
    ];

    public function setFilter(string $filter): void
    {
        $this->selectedFilter = $filter;
    }

    public function openFilterSheet(): void
    {
        // Abertura de modal / opções de filtro
    }

    public function render(): View
    {
        return view('native.history');
    }
}
