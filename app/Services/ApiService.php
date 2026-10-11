<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ApiService
{
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
        return User::whereNotNull('access_token')->first();
    }

    /**
     * Retorna o token de acesso armazenado.
     */
    public static function getToken(): ?string
    {
        return self::user()?->access_token;
    }

    /**
     * Cria e retorna uma instância do PendingRequest pré-configurada com headers e token.
     */
    public static function client(): PendingRequest
    {
        $token = self::getToken();

        return Http::baseUrl(self::baseUrl())
            ->timeout(20)
            ->acceptJson()
            ->when($token, fn (PendingRequest $request) => $request->withToken($token));
    }
}
