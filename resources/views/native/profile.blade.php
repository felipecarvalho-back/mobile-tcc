<column fill class="w-full h-full bg-[#FAF8F8]">
    {{-- Header com Perfil do Operador --}}
    <column class="w-full bg-[#8B0024] rounded-b-3xl px-5 pt-12 pb-6 gap-4 shadow-md">
        <row class="w-full items-center justify-between">
            <text class="text-xl font-black text-white">
                Perfil do Operador
            </text>
            <row class="px-3 py-1.5 rounded-full bg-white/20">
                <text class="text-xs font-black text-white">
                    {{ $terminalId }}
                </text>
            </row>
        </row>

        <row class="w-full items-center gap-4 pt-1">
            <column class="w-16 h-16 rounded-2xl bg-white/15 border border-white/25 items-center justify-center">
                <native:icon name="person" :size="32" class="text-white" />
            </column>

            <column class="flex-1 justify-center">
                <text class="text-xl font-bold text-white">
                    {{ $operatorName }}
                </text>
                <text class="text-xs text-white/80 mt-0.5">
                    {{ $role }}
                </text>
                <text class="text-xs text-white/60 mt-0.5 font-medium">
                    {{ $station }}
                </text>
            </column>
        </row>
    </column>

    {{-- Opções e Informações Operacionais --}}
    <scroll-view class="flex-1 w-full px-5 py-5 gap-4">
        {{-- Card de Informações da Unidade --}}
        <column class="w-full bg-white rounded-2xl border border-gray-200/90 p-4 shadow-sm gap-2">
            <text class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                Unidade & Terminal
            </text>

            <row class="w-full items-center justify-between pt-1">
                <text class="text-sm font-semibold text-gray-700">Instituição</text>
                <text class="text-sm font-bold text-[#8B0024]">{{ $institution }}</text>
            </row>

            <row class="w-full items-center justify-between pt-1">
                <text class="text-sm font-semibold text-gray-700">Terminal Ativo</text>
                <text class="text-sm font-bold text-gray-900">{{ $terminalId }}</text>
            </row>

            <row class="w-full items-center justify-between pt-1">
                <text class="text-sm font-semibold text-gray-700">Cancela Primária</text>
                <text class="text-sm font-bold text-emerald-600">Cancela 01 (Operacional)</text>
            </row>
        </column>

        {{-- Card de Configurações Rápidas --}}
        <column class="w-full bg-white rounded-2xl border border-gray-200/90 p-4 shadow-sm gap-3">
            <text class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                Preferências de Captura
            </text>

            <row class="w-full items-center justify-between py-1">
                <row class="items-center gap-2.5">
                    <native:icon name="bolt" :size="18" class="text-amber-600" />
                    <text class="text-sm font-semibold text-gray-800">Flash Automático</text>
                </row>
                <text class="text-xs font-bold text-emerald-600">Ativado</text>
            </row>

            <row class="w-full items-center justify-between py-1">
                <row class="items-center gap-2.5">
                    <native:icon name="shield" :size="18" class="text-[#8B0024]" />
                    <text class="text-sm font-semibold text-gray-800">Sensibilidade OCR</text>
                </row>
                <text class="text-xs font-bold text-gray-700">Alta (70%+)</text>
            </row>
        </column>

        {{-- Botão de Encerrar Turno / Logout --}}
        <row
            class="w-full items-center justify-center gap-2 py-4 rounded-2xl bg-red-50 border border-red-200 active:bg-red-100"
            @tap="logout"
        >
            <native:icon name="arrow-right" :size="18" class="text-red-700" />
            <text class="text-sm font-bold text-red-700">
                Encerrar Turno e Sair
            </text>
        </row>
    </scroll-view>

    {{-- Barra de Navegação Inferior --}}
    <native:app-bottom-bar active="profile" />
</column>