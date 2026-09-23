@php
    $ocrColorClass = match(true) {
        $ocr >= 95 => 'text-emerald-600',
        $ocr >= 85 => 'text-amber-600',
        default => 'text-amber-600',
    };

    $statusBgClass = match($status) {
        'authorized' => 'bg-emerald-50 border-emerald-200',
        'unregistered' => 'bg-red-50 border-red-200',
        default => 'bg-amber-50 border-amber-200',
    };

    $statusTextClass = match($status) {
        'authorized' => 'text-emerald-700',
        'unregistered' => 'text-red-700',
        default => 'text-amber-800',
    };

    $dotColorClass = match($status) {
        'authorized' => 'bg-emerald-500',
        'unregistered' => 'bg-red-500',
        default => 'bg-amber-500',
    };
@endphp

<column class="w-full bg-white rounded-2xl border border-gray-200/90 p-4 shadow-sm gap-3">
    {{-- Linha Superior: Placa Gráfica + Informações --}}
    <row class="w-full items-start gap-3">
        <native:mercosul-plate :plate="$plate" :badge="$photosCount" />

        <column class="flex-1 justify-center gap-0.5">
            <row class="w-full items-center justify-between">
                <text class="text-base font-black text-gray-900 tracking-wider">
                    {{ $plate }}
                </text>
                @if ($ocr > 0)
                    <text class="text-xs font-bold {{ $ocrColorClass }}">
                        OCR {{ $ocr }}%
                    </text>
                @endif
            </row>

            <text class="text-sm font-bold text-gray-900 line-clamp-1">
                {{ $title }}
            </text>

            @if ($subtitle)
                <text class="text-xs text-gray-500 line-clamp-1">
                    {{ $subtitle }}
                </text>
            @endif
        </column>
    </row>

    {{-- Linha Inferior: Status + Horário --}}
    <row class="w-full items-center justify-between pt-1">
        <row class="items-center gap-2">
            <row class="items-center gap-1.5 px-3 py-1 rounded-full border {{ $statusBgClass }}">
                <column class="w-2 h-2 rounded-full {{ $dotColorClass }}"></column>
                <text class="text-xs font-bold {{ $statusTextClass }}">
                    {{ $statusLabel ?: match($status) {
                        'authorized' => 'Autorizado',
                        'unregistered' => 'Não Cadastrado',
                        default => 'Aguardando Liberação',
                    } }}
                </text>
            </row>

            @if ($corrected)
                <row class="items-center gap-1">
                    <native:icon name="pencil" :size="12" class="text-amber-600" />
                    <text class="text-xs font-bold text-amber-600">corrigida</text>
                </row>
            @endif
        </row>

        @if ($time)
            <text class="text-xs font-medium text-gray-400">
                {{ $time }}
            </text>
        @endif
    </row>
</column>