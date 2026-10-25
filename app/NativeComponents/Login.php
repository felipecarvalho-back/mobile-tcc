<?php

namespace App\NativeComponents;

use App\Models\User;
use App\NativeComponents\Concerns\MonitorsNetwork;
use App\Services\ApiService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class Login extends NativeComponent
{
    use MonitorsNetwork;

    public string $codigo_operador = '';

    public string $senha = '';

    public bool $showPassword = false;

    public string $errorMessage = '';

    public bool $isLoading = false;

    public bool $isCheckingSession = false;

    public function mount(): void
    {
        $this->ensureDatabaseReady();
        $this->syncNetworkState();
        $this->checkExistingSession();
    }

    public function onResume(): void
    {
        $this->syncNetworkState();
    }

    public function onNetworkRestored(): void
    {
        $this->errorMessage = '';
        $this->checkExistingSession();
    }

    public function checkExistingSession(): void
    {
        if (! User::whereNotNull('access_token')->exists()) {
            return;
        }

        if (! ApiService::hasValidLocalToken()) {
            ApiService::clearSession();
            $this->errorMessage = 'Sua sessão expirou. Faça login novamente.';

            return;
        }

        if ($this->isOffline) {
            $this->errorMessage = 'Sem conexão com a internet. Conecte-se para validar sua sessão.';

            return;
        }

        $this->isCheckingSession = true;
        $this->errorMessage = '';

        $this->async(static fn (): array => ApiService::verifySession())
            ->finished(function (array $result): void {
                $this->isCheckingSession = false;

                if (! empty($result['valid'])) {
                    $this->replace('/perfil')->transition(Transition::Fade);

                    return;
                }

                if (! empty($result['offline'])) {
                    $this->isOffline = true;
                }

                $this->errorMessage = $result['message'] ?? 'Sua sessão expirou. Faça login novamente.';
            })
            ->failed(function (\Throwable $e): void {
                $this->isCheckingSession = false;
                Log::warning('Falha ao validar sessão na abertura do app:', ['error' => $e->getMessage()]);
                $this->syncNetworkState();
                $this->errorMessage = 'Não foi possível conectar ao servidor para validar sua sessão.';
            });
    }

    private function ensureDatabaseReady(): void
    {
        try {
            if (! Schema::hasTable('users')) {
                Artisan::call('migrate', ['--force' => true]);
            }
        } catch (\Throwable $e) {
            Log::error('Erro ao verificar/recriar banco de dados:', ['error' => $e->getMessage()]);
        }
    }

    public function togglePassword(): void
    {
        $this->showPassword = ! $this->showPassword;
    }

    public function updatedCodigoOperador(): void
    {
        $this->codigo_operador = strtoupper($this->codigo_operador);
    }

    public function login(): void
    {
        $this->errorMessage = '';

        $this->codigo_operador = strtoupper(trim($this->codigo_operador));

        if (blank($this->codigo_operador) || blank($this->senha)) {
            $this->errorMessage = 'Informe o código do operador e a senha.';

            return;
        }

        $this->syncNetworkState();
        if ($this->isOffline) {
            $this->errorMessage = 'Sem conexão com a internet. Verifique o Wi-Fi ou dados móveis.';

            return;
        }

        $this->isLoading = true;

        $codigo = $this->codigo_operador;
        $senha = $this->senha;
        $baseUrl = ApiService::baseUrl();

        $this->async(static function () use ($baseUrl, $codigo, $senha): array {
            $response = Http::baseUrl($baseUrl)
                ->timeout(20)
                ->acceptJson()
                ->post('/login', [
                    'codigo_operador' => $codigo,
                    'senha' => $senha,
                ]);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $response->json(),
            ];
        })->finished(function (array $result): void {
            $this->isLoading = false;

            if ($result['success']) {
                $payload = $result['data'] ?? [];
                $usuario = $payload['usuario'] ?? [];

                $this->ensureDatabaseReady();

                User::truncate();

                User::create([
                    'id' => $usuario['id'] ?? null,
                    'name' => $usuario['nome'] ?? 'Operador',
                    'email' => $usuario['email'] ?? '',
                    'password' => bcrypt('sentinela-mobile-session'),
                    'codigo_operador' => $usuario['codigo_operador'] ?? $this->codigo_operador,
                    'perfil' => $usuario['perfil'] ?? 'operador',
                    'ativo' => $usuario['ativo'] ?? true,
                    'access_token' => $payload['access_token'] ?? null,
                    'token_type' => $payload['token_type'] ?? 'bearer',
                ]);

                $this->replace('/perfil')->transition(Transition::Fade);

                return;
            }

            $this->errorMessage = $result['data']['message'] ?? 'Falha na autenticação. Verifique os dados informados.';
        })->failed(function (\Throwable $e): void {
            $this->isLoading = false;
            Log::error('Erro ao conectar na API de login:', [
                'error' => $e->getMessage(),
            ]);
            $this->errorMessage = 'Não foi possível conectar ao servidor. Verifique sua conexão.';
        });
    }

    public function render(): View
    {
        return view('native.login');
    }
}
