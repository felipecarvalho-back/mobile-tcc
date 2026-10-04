<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class Login extends NativeComponent
{
    public string $username = 'operador.guarita';

    public string $password = '••••••';

    public bool $showPassword = false;

    public function togglePassword(): void
    {
        $this->showPassword = ! $this->showPassword;
    }

    public function login(): void
    {
        $this->replace('/capturar')->transition(Transition::Fade);
    }

    public function render(): View
    {
        return view('native.login');
    }
}
