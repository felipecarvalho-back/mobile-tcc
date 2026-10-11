<column class="w-full bg-white border-t border-gray-200/80 shadow-lg pt-1 pb-9">
    <row class="w-full items-end justify-around px-5">
        {{-- Tab 1: Histórico --}}
        <column class="flex-1 items-center justify-center gap-1 pb-1" @tap="goToHistory">
            <native:icon
                name="clock"
                :size="26"
                class="{{ $active === 'history' ? 'text-[#8B0024]' : 'text-gray-400' }}"
            />
            <text class="text-xs {{ $active === 'history' ? 'text-[#8B0024] font-bold' : 'text-gray-500 font-semibold' }}">
                Histórico
            </text>
        </column>

        {{-- Tab 2: Capturar Placa (Botão Circular Elevado em Destaque) --}}
        <column class="flex-1 items-center justify-center -mt-1" @tap="takePhoto">
            <column class="w-16 h-16 rounded-full bg-[#8B0024] shadow-xl border-4 border-white items-center justify-center">
                <native:icon name="camera" :size="30" class="text-white" />
            </column>
            <text class="text-xs text-[#8B0024] font-bold mt-1">
                Capturar
            </text>
        </column>

        {{-- Tab 3: Perfil --}}
        <column class="flex-1 items-center justify-center gap-1 pb-1" @tap="goToProfile">
            <native:icon
                name="person"
                :size="26"
                class="{{ $active === 'profile' ? 'text-[#8B0024]' : 'text-gray-400' }}"
            />
            <text class="text-xs {{ $active === 'profile' ? 'text-[#8B0024] font-bold' : 'text-gray-500 font-semibold' }}">
                Perfil
            </text>
        </column>
    </row>
</column>
