<?php

namespace App\NativeComponents\Concerns;

use App\Services\ApiService;
use Native\Mobile\Attributes\Poll;

trait MonitorsNetwork
{
    public bool $isOffline = false;

    /**
     * Atualiza o estado de conexão e dispara `onNetworkRestored()` quando a internet volta.
     */
    public function syncNetworkState(): void
    {
        $wasOffline = $this->isOffline;
        $this->isOffline = ! ApiService::isOnline();

        if ($wasOffline && ! $this->isOffline && method_exists($this, 'onNetworkRestored')) {
            $this->onNetworkRestored();
        }
    }

    /**
     * Verifica periodicamente (a cada 3s) se o aparelho continua conectado à internet.
     */
    #[Poll(3000)]
    public function pollNetworkStatus(): void
    {
        $this->syncNetworkState();
    }
}
