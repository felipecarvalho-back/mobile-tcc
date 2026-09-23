@if ($size === 'lg')
    <column class="w-[280px] h-[132px] bg-white rounded-xl border-4 border-black/80 overflow-hidden shadow-2xl items-center justify-between">
        {{-- Faixa Azul Superior Mercosul --}}
        <row class="w-full bg-[#003399] px-4 py-2 items-center justify-between">
            <text class="text-xs font-black text-white tracking-widest">BRASIL</text>
            <text class="text-xs font-black text-white">BR</text>
        </row>

        {{-- Caracteres da Placa --}}
        <column class="w-full flex-1 items-center justify-center py-2">
            <text class="text-3xl font-black text-black tracking-widest text-center">
                {{ $plate }}
            </text>
        </column>
    </column>
@else
    <stack class="relative">
        <column class="w-[96px] h-[58px] bg-[#1E2024] rounded-xl items-center justify-center p-1.5 shadow-sm">
            <column class="w-[82px] h-[44px] bg-white rounded border border-gray-400 overflow-hidden items-center justify-between">
                {{-- Faixa Azul Superior Mercosul --}}
                <row class="w-full bg-[#003399] px-1 py-[2px] items-center justify-between">
                    <text class="text-[7px] font-black text-white tracking-widest">BRASIL</text>
                    <text class="text-[6px] font-black text-white">BR</text>
                </row>

                {{-- Caracteres da Placa --}}
                <column class="w-full flex-1 items-center justify-center py-0.5">
                    <text class="text-xs font-black text-black tracking-wider text-center">
                        {{ $plate }}
                    </text>
                </column>
            </column>
        </column>

        @if ($badge > 0)
            <row class="absolute bottom-1 right-1 bg-black/80 rounded px-1.5 py-0.5 items-center gap-0.5">
                <native:icon name="camera" :size="8" class="text-white" />
                <text class="text-[9px] font-bold text-white">{{ $badge }}</text>
            </row>
        @endif
    </stack>
@endif