<column class="w-full bg-white border-t border-gray-200/80 shadow-lg">
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

        {{-- Tab 2: Capturar Placa (Botão Elevado de Destaque no Centro) --}}
        <column class="flex-1 items-center justify-center -mt-6" @tap="goToCapture">
            <column class="w-14 h-14 rounded-2xl {{ $active === 'capture' ? 'bg-[#8B0024] shadow-lg shadow-[#8B0024]/30 border-2 border-white' : 'bg-gray-700' }} items-center justify-center shadow-md">
                <native:icon name="camera" :size="26" class="text-white" />
            </column>
            <text class="text-[11px] {{ $active === 'capture' ? 'text-[#8B0024] font-bold' : 'text-gray-600 font-medium' }} mt-1">
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