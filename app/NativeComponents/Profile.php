<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class Profile extends NativeComponent
{
    public string $operatorName = 'Operador Guarita';

    public string $role = 'Operador de Portaria';

    public string $terminalId = 'GDA - 104';

    public string $station = 'Terminal da Guarita • Posto Principal';

    public string $institution = 'FATEC • Centro Paula Souza';

    public function logout(): void
    {
        $this->navigate('/login');
    }

    public function render(): View
    {
        return view('native.profile');
    }
}
