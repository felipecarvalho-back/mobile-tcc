<?php

namespace App\NativeComponents;

use App\NativeComponents\Concerns\MonitorsNetwork;
use App\Services\ApiService;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Edge\Transition;

class Profile extends NativeComponent
{
    use MonitorsNetwork;

    public string $operatorName = 'Operador Guarita';

    public string $role = 'Operador de Portaria';

    public string $terminalId = 'GDA - 104';

    public string $station = 'Terminal da Guarita • Posto Principal';

    public string $institution = 'FATEC • Centro Paula Souza';

    public function mount(): void
    {
        $this->syncNetworkState();

        if (! ApiService::hasValidLocalToken()) {
            ApiService::clearSession();
            $this->replace('/login')->transition(Transition::Fade);

            return;
        }

        $user = ApiService::user();

        if ($user) {
            $this->operatorName = $user->name;
            $this->terminalId = $user->codigo_operador ?? $this->terminalId;
            $this->role = $user->perfil ? ucfirst($user->perfil) : $this->role;
        }
    }

    public function onResume(): void
    {
        $this->syncNetworkState();

        if (! ApiService::hasValidLocalToken()) {
            ApiService::clearSession();
            $this->replace('/login')->transition(Transition::Fade);
        }
    }

    public function logout(): void
    {
        ApiService::clearSession();
        $this->replace('/login')->transition(Transition::Fade);
    }

    public function render(): View
    {
        return view('native.profile');
    }
}
