<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class OfflineBanner extends NativeComponent
{
    public bool $isOffline = false;

    public function render(): View
    {
        return view('native.offline-banner');
    }
}
