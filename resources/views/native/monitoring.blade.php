<column fill class="w-full h-full bg-[#F8F6F7]">
    {{-- Header Vinho da Guarita --}}
    <column class="w-full bg-[#8B0024] rounded-b-3xl px-5 pt-12 pb-5 gap-3.5 shadow-md">
        {{-- Tag Superior: Área da Guarita --}}
        <row class="px-2.5 py-1 rounded-full bg-white/20 self-start">
            <text class="text-[10px] font-black tracking-widest text-white uppercase">
                Área da Guarita
            </text>
        </row>

        {{-- Linha de Identificação do Operador --}}
        <row class="w-full items-center justify-between">
            <row class="items-center gap-3">
                <column class="w-12 h-12 rounded-2xl bg-white/15 border border-white/25 items-center justify-center">
                    <native:icon name="shield" :size="24" class="text-white" />
                </column>

                <column class="justify-center">
                    <text class="text-xl font-bold text-white">
                        {{ $operatorName }}
                    </text>
                    <text class="text-xs text-white/80 mt-0.5">
                        {{ $stationName }}
                    </text>
                </column>
            </row>

            <row class="px-3 py-1.5 rounded-full bg-white/20">
                <text class="text-xs font-black text-white">
                    {{ $terminalId }}
                </text>
            </row>
        </row>

        {{-- Status da Cancela e Horário em Tempo Real --}}
        <row class="w-full items-center justify-between pt-1">
            <row class="items-center gap-2 px-3 py-1.5 rounded-full bg-black/25">
                <column class="w-2 h-2 rounded-full bg-emerald-400"></column>
                <text class="text-xs font-bold text-white">
                    {{ $gateStatus }}
                </text>
            </row>

            <text class="text-sm font-semibold text-white/90">
                {{ $currentTime }}
            </text>
        </row>
    </column>

    {{-- Conteúdo Principal com Rolagem --}}
    <scroll-view class="flex-1 w-full px-4 py-4 gap-4">
        {{-- Cartão de Ação Rápida: Capturar Placa --}}
        <column
            class="w-full bg-gradient-to-r from-[#0F766E] to-[#14B8A6] rounded-3xl p-5 shadow-lg shadow-[#0F766E]/20"
            @tap="goToCapture"
        >
            <row class="w-full items-center gap-4">
                <column class="w-14 h-14 rounded-2xl bg-white/20 items-center justify-center">
                    <native:icon name="camera" :size="28" class="text-white" />
                </column>

                <column class="flex-1">
                    <text class="text-xl font-black text-white">
                        Capturar Placa
                    </text>
                    <text class="text-xs text-white/90 mt-1 font-medium">
                        Leitura por OCR e envio ao terminal
                    </text>
                </column>
            </row>
        </column>

        {{-- 3 Cartões de Métricas Operacionais --}}
        <row class="w-full gap-2.5">
            {{-- Métrica 1: Passagens hoje --}}
            <column class="flex-1 bg-white rounded-2xl border border-gray-200/90 p-3.5 shadow-sm justify-between">
                <text class="text-2xl font-black text-[#8B0024]">
                    {{ $totalPassages }}
                </text>
                <text class="text-xs font-semibold text-gray-600 mt-1 leading-tight">
                    Passagens hoje
                </text>
            </column>

            {{-- Métrica 2: Liberações automáticas --}}
            <column class="flex-1 bg-white rounded-2xl border border-gray-200/90 p-3.5 shadow-sm justify-between">
                <text class="text-2xl font-black text-emerald-600">
                    {{ $autoReleases }}
                </text>
                <text class="text-xs font-semibold text-gray-600 mt-1 leading-tight">
                    Liberações automáticas
                </text>
            </column>

            {{-- Métrica 3: Correções de placa --}}
            <column class="flex-1 bg-white rounded-2xl border border-gray-200/90 p-3.5 shadow-sm justify-between">
                <text class="text-2xl font-black text-amber-600">
                    {{ $plateCorrections }}
                </text>
                <text class="text-xs font-semibold text-gray-600 mt-1 leading-tight">
                    Correções de placa
                </text>
            </column>
        </row>

        {{-- Banner de Saldo no Campus --}}
        <row class="w-full items-center justify-between px-4 py-3.5 bg-[#EDF2FE] rounded-2xl border border-[#DCE6FD]">
            <row class="items-center gap-2.5">
                <native:icon name="car" :size="20" class="text-[#8B0024]" />
                <text class="text-sm font-bold text-gray-700">
                    Saldo no campus agora
                </text>
            </row>

            <row class="items-center gap-1">
                <text class="text-base font-black text-[#8B0024]">
                    {{ $campusBalance }}
                </text>
                <text class="text-sm font-black text-[#8B0024]">
                    veículos
                </text>
            </row>
        </row>

        {{-- Seção: Fila da Cancela 01 --}}
        <column class="w-full gap-3 pt-1 pb-4">
            <row class="w-full items-center justify-between">
                <row class="items-center gap-2">
                    <text class="text-lg font-black text-gray-900">
                        Fila da Cancela 01
                    </text>
                    <row class="items-center gap-1 px-2.5 py-0.5 rounded-full bg-red-100">
                        <column class="w-1.5 h-1.5 rounded-full bg-red-600"></column>
                        <text class="text-[10px] font-black text-red-600 tracking-wider">
                            AO VIVO
                        </text>
                    </row>
                </row>

                <column @tap="goToHistory">
                    <text class="text-xs font-black text-[#8B0024]">
                        Ver tudo
                    </text>
                </column>
            </row>

            {{-- Itens de Veículos na Fila --}}
            @foreach ($queue as $item)
                <native:vehicle-card
                    :plate="$item['plate']"
                    :ocr="$item['ocr']"
                    :title="$item['title']"
                    :subtitle="$item['subtitle']"
                    :status="$item['status']"
                    :statusLabel="$item['statusLabel']"
                    :time="$item['time']"
                    :corrected="$item['corrected']"
                    :photosCount="$item['photosCount']"
                    key="queue-{{ $item['plate'] }}"
                />
            @endforeach
        </column>
    </scroll-view>

    {{-- Barra de Navegação Inferior --}}
    <native:app-bottom-bar active="monitoring" />
</column>