<stack class="w-full">
    {{-- Camada de Fundo: Barra Branca --}}
    <column class="w-full mt-4 bg-white border-t border-gray-200/80 shadow-lg">
        <row class="w-full items-center justify-around px-6 pt-2 pb-6">
            {{-- Tab 1: Histórico --}}
            <column class="flex-1 items-center justify-center gap-1" @tap="goToHistory">
                <native:icon
                    name="clock"
                    :size="24"
                    class="{{ $active === 'history' ? 'text-[#8B0024]' : 'text-gray-400' }}"
                />
                <text class="text-[11px] {{ $active === 'history' ? 'text-[#8B0024] font-bold' : 'text-gray-500 font-medium' }}">
                    Histórico
                </text>
            </column>

            {{-- Espaço central ocupado pelo botão sobreposto --}}
            <column class="flex-1 items-center justify-center">
                <column class="w-14 h-6"></column>
                <text class="text-[11px] text-[#8B0024] font-bold mt-1">
                    Capturar
                </text>
            </column>

            {{-- Tab 3: Perfil --}}
            <column class="flex-1 items-center justify-center gap-1" @tap="goToProfile">
                <native:icon
                    name="person"
                    :size="24"
                    class="{{ $active === 'profile' ? 'text-[#8B0024]' : 'text-gray-400' }}"
                />
                <text class="text-[11px] {{ $active === 'profile' ? 'text-[#8B0024] font-bold' : 'text-gray-500 font-medium' }}">
                    Perfil
                </text>
            </column>
        </row>
    </column>

    {{-- Camada Superior: Botão Circular Flutuante Sobreposto --}}
    <row class="w-full justify-center">
        <column
            class="w-14 h-14 rounded-full bg-[#8B0024] shadow-xl border-4 border-white items-center justify-center"
            @tap="takePhoto"
        >
            <native:icon name="camera" :size="26" class="text-white" />
        </column>
    </row>
</stack>
