<?php

namespace App\NativeComponents;

use App\Models\User;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class Profile extends NativeComponent
{
    public string $operatorName = 'Operador Guarita';

    public string $role = 'Operador de Portaria';

    public string $terminalId = 'GDA - 104';

    public string $station = 'Terminal da Guarita • Posto Principal';

    public string $institution = 'FATEC • Centro Paula Souza';

    public function mount(): void
    {
        $user = User::whereNotNull('access_token')->first();

        if ($user) {
            $this->operatorName = $user->name;
            $this->terminalId = $user->codigo_operador ?? $this->terminalId;
            $this->role = $user->perfil ? ucfirst($user->perfil) : $this->role;
        }
    }

    public function logout(): void
    {
        User::truncate();
        $this->replace('/login')->transition(Transition::Fade);
    }

    public function render(): View
    {
        return view('native.profile');
    }
}
