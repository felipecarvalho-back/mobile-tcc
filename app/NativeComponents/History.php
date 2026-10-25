<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\MonitorsNetwork;
use App\Services\ApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;
use Throwable;

class History extends NativeComponent
{
    use MonitorsNetwork;

    public string $search = '';

    public string $selectedFilter = 'hoje';

    public string $dataReferencia = '';

    public int $total = 0;

    public bool $isLoading = true;

    public string $errorMessage = '';

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $todayCaptures = [];

    public function mount(): void
    {
        $this->dataReferencia = now()->format('d/m/Y');
        $this->syncNetworkState();
        $this->loadHistory();
    }

    public function onResume(): void
    {
        $this->syncNetworkState();
        $this->loadHistory();
    }

    public function onNetworkRestored(): void
    {
        $this->errorMessage = '';
        $this->loadHistory();
    }

    public function setFilter(string $filter): void
    {
        $this->selectedFilter = $filter;
    }

    public function loadHistory(): void
    {
        if (! ApiService::hasValidLocalToken()) {
            ApiService::clearSession();
            $this->replace('/login')->transition(Transition::Fade);

            return;
        }

        $this->syncNetworkState();

        if ($this->isOffline) {
            $this->isLoading = false;
            $this->errorMessage = 'Sem conexão com a internet. Verifique o Wi-Fi ou dados móveis.';

            return;
        }

        $this->isLoading = true;
        $this->errorMessage = '';

        $baseUrl = ApiService::baseUrl();
        $token = (string) ApiService::getToken();

        $this->async(static function () use ($baseUrl, $token): array {
            $response = Http::baseUrl($baseUrl)
                ->withToken($token)
                ->acceptJson()
                ->timeout(15)
                ->get('/historico');

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $response->json() ?? [],
            ];
        })->finished(function (array $result): void {
            $this->isLoading = false;

            if (in_array($result['status'], [401, 403], true)) {
                ApiService::clearSession();
                $this->replace('/login')->transition(Transition::Fade);

                return;
            }

            if ($result['success']) {
                $payload = $result['data'];
                $this->dataReferencia = (string) ($payload['data_referencia'] ?? now()->format('d/m/Y'));
                $this->total = (int) ($payload['total'] ?? 0);

                $historico = is_array($payload['historico'] ?? null) ? $payload['historico'] : [];
                $this->todayCaptures = array_map(
                    fn (array $item): array => $this->mapHistoryItem($item),
                    $historico
                );

                return;
            }

            $this->errorMessage = (string) ($result['data']['message'] ?? 'Não foi possível carregar o histórico de hoje.');
        })->failed(function (Throwable $e): void {
            $this->isLoading = false;
            Log::error('Erro ao buscar histórico na API:', ['error' => $e->getMessage()]);
            $this->errorMessage = 'Falha ao conectar ao servidor para buscar o histórico.';
        });
    }

    /**
     * Converte um item da resposta de `/api/historico` para o formato exibido pelo card.
     *
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>
     */
    protected function mapHistoryItem(array $item): array
    {
        $placaIdentificada = (bool) ($item['placa_identificada'] ?? false);
        $placaExibicao = (string) ($item['placa_exibicao'] ?? ($item['placa'] ?: 'SEM-PLACA'));
        $condutorTipo = $item['condutor_tipo'] ?? null;
        $rawStatus = (string) ($item['status'] ?? 'pendente');

        [$visualStatus, $statusLabel] = match ($rawStatus) {
            'autorizado' => ['authorized', 'Autorizado'],
            'em_patio' => ['authorized', 'Em Pátio'],
            'liberado_manual' => ['authorized', 'Liberado Manual'],
            'finalizado' => ['authorized', 'Finalizado'],
            'nao_cadastrado' => ['unregistered', 'Não Cadastrado'],
            'bloqueado' => ['unregistered', 'Bloqueado'],
            default => ['waiting', 'Aguardando Liberação'],
        };

        $subtitle = match ($condutorTipo) {
            'professor' => 'Docente • FATEC',
            'funcionario' => 'Funcionário • FATEC',
            'prestador' => 'Prestador de Serviço',
            'visitante' => 'Visitante',
            default => $placaIdentificada
                ? 'Veículo sem condutor vinculado'
                : 'Placa não identificada automaticamente pelo OCR',
        };

        return [
            'id' => (int) ($item['id'] ?? 0),
            'photo' => (string) ($item['foto'] ?? ''),
            'plate' => $placaExibicao,
            'plateIdentified' => $placaIdentificada,
            'title' => (string) ($item['condutor'] ?? 'Condutor não identificado'),
            'subtitle' => $subtitle,
            'condutorTipo' => (string) ($condutorTipo ?? ''),
            'status' => $visualStatus,
            'statusLabel' => $statusLabel,
            'time' => (string) ($item['horario'] ?? ''),
            'dateTime' => (string) ($item['data_hora'] ?? ''),
            'corrected' => false,
            'photosCount' => ! empty($item['foto']) ? 1 : 0,
        ];
    }

    /**
     * Filtra os itens de acordo com a busca e o chip selecionado.
     *
     * @return array<int, array<string, mixed>>
     */
    public function filteredCaptures(): array
    {
        $search = mb_strtolower(trim($this->search));
        $filter = $this->selectedFilter;

        return array_values(array_filter(
            $this->todayCaptures,
            static function (array $item) use ($search, $filter): bool {
                $matchesFilter = match ($filter) {
                    'docentes' => $item['condutorTipo'] === 'professor',
                    'funcionarios' => $item['condutorTipo'] === 'funcionario',
                    'prestadores' => $item['condutorTipo'] === 'prestador',
                    'visitantes' => $item['condutorTipo'] === 'visitante',
                    'sem_placa' => ! $item['plateIdentified'],
                    default => true,
                };

                if (! $matchesFilter) {
                    return false;
                }

                if ($search === '') {
                    return true;
                }

                $haystack = mb_strtolower(
                    $item['plate'].' '.str_replace('-', '', $item['plate']).' '.$item['title'].' '.$item['subtitle']
                );

                return str_contains($haystack, $search);
            }
        ));
    }

    public function render(): View
    {
        return view('native.history', [
            'filteredCaptures' => $this->filteredCaptures(),
        ]);
    }
}
