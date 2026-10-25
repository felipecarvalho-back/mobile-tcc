@php
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

    $hasValidPhoto = ! empty($photo) && str_starts_with($photo, 'http');
@endphp

<column class="w-full bg-white rounded-2xl border border-gray-200/90 p-4 shadow-sm gap-3">
    {{-- Linha Superior: Placa Gráfica + Informações + Miniatura da Foto --}}
    <row class="w-full items-start gap-3">
        <native:mercosul-plate :plate="$plate" :badge="$photosCount" />

        <column class="flex-1 justify-center gap-0.5">
            <row class="w-full items-center justify-between gap-2">
                <text class="text-base font-black text-gray-900 tracking-wider">
                    {{ $plate }}
                </text>

                @if ($plateIdentified)
                    <row class="items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-50">
                        <native:icon name="checkmark" :size="10" class="text-emerald-600" />
                        <text class="text-[10px] font-bold text-emerald-700">
                            Placa OK
                        </text>
                    </row>
                @else
                    <row class="items-center gap-1 px-2 py-0.5 rounded-md bg-red-50">
                        <native:icon name="error" :size="10" class="text-red-600" />
                        <text class="text-[10px] font-bold text-red-700">
                            Não identificada
                        </text>
                    </row>
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

        @if ($hasValidPhoto)
            <column class="w-14 h-14 rounded-xl overflow-hidden border border-gray-200 bg-gray-100" @tap="togglePhoto">
                <native:image :src="$photo" :fit="2" class="w-14 h-14" alt="Foto do veículo {{ $plate }}" />
            </column>
        @endif
    </row>

    {{-- Foto Expandida ao Tocar --}}
    @if ($hasValidPhoto && $showPhoto)
        <column class="w-full rounded-xl overflow-hidden border border-gray-200 bg-gray-900" @tap="togglePhoto">
            <native:image :src="$photo" :fit="1" class="w-full h-48" alt="Foto ampliada {{ $plate }}" />
        </column>
    @endif

    {{-- Linha Inferior: Status + Botão de Foto + Horário Exato --}}
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

            @if ($hasValidPhoto)
                <row class="items-center gap-1 px-2.5 py-1 rounded-full bg-gray-100" @tap="togglePhoto">
                    <native:icon name="camera" :size="12" class="text-gray-600" />
                    <text class="text-[11px] font-bold text-gray-700">
                        {{ $showPhoto ? 'Ocultar foto' : 'Ver foto' }}
                    </text>
                </row>
            @endif
        </row>

        @if ($time)
            <row class="items-center gap-1">
                <native:icon name="schedule" :size="13" class="text-gray-400" />
                <text class="text-xs font-bold text-gray-500">
                    {{ $time }}
                </text>
            </row>
        @endif
    </row>
</column>