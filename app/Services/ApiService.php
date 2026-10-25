<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Facades\Network;
use Throwable;

class ApiService
{
    /**
     * Verifica se o dispositivo possui conexão ativa com a internet.
     */
    public static function isOnline(): bool
    {
        try {
            $status = Network::status();

            if (is_object($status) && isset($status->connected)) {
                return (bool) $status->connected;
            }

            if (is_array($status) && isset($status['connected'])) {
                return (bool) $status['connected'];
            }

            return true;
        } catch (Throwable) {
            return true;
        }
    }

    /**
     * Retorna a URL base da API.
     */
    public static function baseUrl(): string
    {
        return config('services.api.url', 'https://web-tcc.onrender.com/api');
    }

    /**
     * Retorna o usuário logado localmente (se houver).
     */
    public static function user(): ?User
    {
        try {
            return User::whereNotNull('access_token')->first();
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Retorna o token de acesso armazenado.
     */
    public static function getToken(): ?string
    {
        return self::user()?->access_token;
    }

    /**
     * Verifica localmente se existe um token JWT e se ele ainda não expirou (claim 'exp').
     */
    public static function hasValidLocalToken(): bool
    {
        $token = self::getToken();

        if (blank($token)) {
            return false;
        }

        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        $payloadBase64 = strtr($parts[1], '-_', '+/');
        $padding = strlen($payloadBase64) % 4;
        if ($padding > 0) {
            $payloadBase64 .= str_repeat('=', 4 - $padding);
        }

        $decoded = base64_decode($payloadBase64, true);
        if ($decoded === false) {
            return false;
        }

        $payload = json_decode($decoded, true);
        if (! is_array($payload)) {
            return false;
        }

        // Verifica expiração com margem de segurança de 15 segundos
        if (isset($payload['exp']) && (int) $payload['exp'] <= (time() + 15)) {
            return false;
        }

        return true;
    }

    /**
     * Limpa a sessão local armazenada no SQLite.
     */
    public static function clearSession(): void
    {
        try {
            User::query()->delete();
        } catch (Throwable) {
            // Ignora caso a tabela ainda não exista
        }
    }

    /**
     * Valida a sessão atual consultando primeiramente a expiração local do JWT
     * e em seguida confirmando na API se o token e o operador continuam válidos.
     *
     * @return array{valid: bool, offline?: bool, status: int, message?: string, data?: array<string, mixed>}
     */
    public static function verifySession(): array
    {
        if (! self::hasValidLocalToken()) {
            self::clearSession();

            return [
                'valid' => false,
                'offline' => false,
                'status' => 401,
                'message' => 'Sua sessão expirou. Faça login novamente.',
            ];
        }

        if (! self::isOnline()) {
            return [
                'valid' => false,
                'offline' => true,
                'status' => 0,
                'message' => 'Sem conexão com a internet. Conecte-se para validar sua sessão.',
            ];
        }

        try {
            $response = self::client()
                ->timeout(120)
                ->get('/historico');

            if ($response->successful()) {
                return [
                    'valid' => true,
                    'offline' => false,
                    'status' => $response->status(),
                    'data' => $response->json() ?? [],
                ];
            }

            if (in_array($response->status(), [401, 403], true)) {
                self::clearSession();

                return [
                    'valid' => false,
                    'offline' => false,
                    'status' => $response->status(),
                    'message' => $response->json('message') ?? 'Sua sessão expirou ou o usuário está inativo.',
                ];
            }

            return [
                'valid' => false,
                'offline' => false,
                'status' => $response->status(),
                'message' => 'Não foi possível validar sua sessão no servidor.',
            ];
        } catch (Throwable) {
            return [
                'valid' => false,
                'offline' => true,
                'status' => 0,
                'message' => 'Sem conexão com o servidor. Verifique sua internet e tente novamente.',
            ];
        }
    }

    /**
     * Cria e retorna uma instância do PendingRequest pré-configurada com headers e token.
     */
    public static function client(): PendingRequest
    {
        set_time_limit(120);

        $token = self::getToken();

        return Http::baseUrl(self::baseUrl())
            ->timeout(120)
            ->acceptJson()
            ->when($token, fn (PendingRequest $request) => $request->withToken($token));
    }
}
