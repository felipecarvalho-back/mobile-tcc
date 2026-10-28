<?php

namespace App\NativeComponents;

use App\Services\ApiService;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Native\Mobile\AsyncTask;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;
use Native\Mobile\Events\Camera\PhotoTaken;
use Native\Mobile\Facades\Camera;
use Native\Mobile\Facades\Dialog;
use Native\Mobile\Facades\Network;
use Throwable;

class AppBottomBar extends NativeComponent
{
    public string $active = 'history'; // 'history' | 'profile'

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

    /**
     * Abre a camera nativa. O callback e estatico para sobreviver caso o
     * sistema mate o processo do app enquanto a camera esta aberta.
     */
    public function takePhoto(): void
    {
        if (! ApiService::isOnline()) {
            Dialog::alert(
                'Sem Conexão com a Internet',
                'O Sentinela precisa de conexão com a internet para funcionar e enviar fotos. Conecte-se ao Wi-Fi ou dados móveis.'
            );

            return;
        }

        Camera::getPhoto()
            ->photoTaken(static fn (PhotoTaken $event) => self::handlePhotoTaken($event->path))
            ->permissionDenied(static fn () => Dialog::alert(
                'Permissão Necessária',
                'O Sentinela precisa de permissão de acesso à câmera para fotografar placas.'
            ));
    }

    /**
     * Salva a foto localmente e envia para a API (/api/enviar) em segundo plano com o token do usuario.
     */
    public static function handlePhotoTaken(string $sourcePath): void
    {
        $targetPath = self::storePlatePhoto($sourcePath);

        if (! ApiService::hasValidLocalToken()) {
            ApiService::clearSession();

            Dialog::alert(
                'Sessão Expirada',
                'Sua sessão expirou. Acesse o perfil e faça login novamente para enviar fotos.'
            );

            return;
        }

        try {
            $network = Network::status();
            if ($network && isset($network->connected) && ! $network->connected) {
                Dialog::alert(
                    'Sem Conexão',
                    'A foto foi salva no dispositivo, mas não há conexão com a internet para enviá-la agora.'
                );

                return;
            }
        } catch (Throwable) {
            // Prossegue caso o plugin de rede falhe ao consultar status
        }

        Dialog::toast('Foto capturada! Enviando placa para análise...');

        $baseUrl = ApiService::baseUrl();
        $token = (string) ApiService::getToken();

        AsyncTask::dispatch(static fn (): array => ApiService::sendPhoto($targetPath, $token, $baseUrl))
            ->timeout(130)
            ->finished(static function (array $result): void {
                if (! empty($result['success'])) {
                    $data = $result['data'] ?? [];
                    $mensagem = $data['mensagem'] ?? 'Imagem enviada com sucesso!';
                    $placa = $data['placa'] ?? 'Não identificada';

                    Dialog::alert(
                        'Foto Enviada',
                        "{$mensagem}\nPlaca: {$placa}"
                    );

                    return;
                }

                if (in_array($result['status'] ?? 0, [401, 403], true)) {
                    ApiService::clearSession();

                    $msg = $result['data']['message'] ?? 'Sua sessão expirou. Acesse o perfil e faça login novamente.';
                    Dialog::alert('Sessão Expirada', (string) $msg);

                    return;
                }

                $errorMessage = $result['data']['erro']
                    ?? $result['data']['message']
                    ?? $result['error']
                    ?? 'Não foi possível processar a imagem no servidor.';

                Dialog::alert('Erro no Envio', (string) $errorMessage);
            })
            ->failed(static function (Throwable $e): void {
                Dialog::alert(
                    'Erro de Conexão',
                    'Não foi possível enviar a foto para o servidor. Verifique sua conexão e tente novamente.'
                );
            });
    }

    /**
     * Copia a foto do cache temporario para o armazenamento privado do app.
     */
    public static function storePlatePhoto(string $sourcePath): string
    {
        $platesDir = storage_path('app/private/plates');

        if (! File::isDirectory($platesDir)) {
            File::makeDirectory($platesDir, 0755, true);
            File::put($platesDir.DIRECTORY_SEPARATOR.'.nomedia', '');
        }

        $filename = 'placa_'.now()->format('Ymd_His').'_'.bin2hex(random_bytes(3)).'.jpg';
        $targetPath = $platesDir.DIRECTORY_SEPARATOR.$filename;

        File::copy($sourcePath, $targetPath);

        return $targetPath;
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

    public function render(): View
    {
        return view('native.app-bottom-bar');
    }
}
