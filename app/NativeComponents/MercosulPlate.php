<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class MercosulPlate extends NativeComponent
{
    public string $plate = 'BRA-2819';

    public int $badge = 0;

    public string $size = 'sm';

    public function render(): View
    {
        return view('native.mercosul-plate');
    }
}
