<?php

namespace App\NativeComponents;

use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;
use Native\Mobile\Events\Camera\PhotoTaken;
use Native\Mobile\Facades\Camera;
use Native\Mobile\Facades\Dialog;

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
        Camera::getPhoto()
            ->photoTaken(static fn (PhotoTaken $event) => self::storePlatePhoto($event->path))
            ->permissionDenied(static fn () => Dialog::alert(
                'Permissão Necessária',
                'O Sentinela precisa de permissão de acesso à câmera para fotografar placas.'
            ));
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
