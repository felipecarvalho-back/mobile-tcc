<column fill class="w-full h-full bg-[#0E0F12] justify-between safe-area px-4 py-4">
    {{-- Barra Superior: Fechar, Título e Flash --}}
    <column class="w-full gap-3">
        <row class="w-full items-center justify-between pt-2">
            <column
                class="w-11 h-11 rounded-full bg-white/10 items-center justify-center active:bg-white/20"
                @tap="close"
            >
                <native:icon name="xmark" :size="20" class="text-white" />
            </column>

            <text class="text-lg font-black text-white">
                Capturar Placa
            </text>

            <column
                class="w-11 h-11 rounded-full {{ $flashOn ? 'bg-amber-500/20 border border-amber-500/40' : 'bg-white/10' }} items-center justify-center active:bg-white/20"
                @tap="toggleFlash"
            >
                <native:icon name="bolt" :size="20" class="{{ $flashOn ? 'text-amber-400' : 'text-white' }}" />
            </column>
        </row>

        {{-- Sub-header: Cancela e Código do Terminal --}}
        <row class="w-full items-center justify-between px-1">
            <row class="items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 border border-white/15">
                <column class="w-2 h-2 rounded-full bg-emerald-400"></column>
                <text class="text-xs font-bold text-white">
                    {{ $gateTitle }}
                </text>
            </row>

            <text class="text-xs font-bold text-gray-400">
                {{ $terminalId }}
            </text>
        </row>
    </column>

    {{-- Visor Central da Câmera com Moldura OCR e Placa Detectada --}}
    <column class="w-full flex-1 items-center justify-center gap-6 my-2">
        {{-- Tag Superior do Visor: Foco Travado --}}
        <row class="items-center gap-2 px-4 py-1.5 rounded-full bg-black/60 border border-white/15">
            <column class="w-2 h-2 rounded-full bg-emerald-400"></column>
            <text class="text-xs font-bold text-white">
                Placa detectada • foco travado
            </text>
        </row>

        {{-- Moldura com Cantos Âmbar ao Redor da Placa Mercosul --}}
        <stack class="relative w-[320px] h-[170px] items-center justify-center">
            {{-- Cantos da Moldura de Alinhamento --}}
            <column class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-amber-500 rounded-tl-xl"></column>
            <column class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-amber-500 rounded-tr-xl"></column>
            <column class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-amber-500 rounded-bl-xl"></column>
            <column class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-amber-500 rounded-br-xl"></column>

            {{-- Placa Mercosul com Destaque Central --}}
            <native:mercosul-plate :plate="$detectedPlate" size="lg" />
        </stack>

        {{-- Instruções de Alinhamento --}}
        <column class="items-center gap-1">
            <text class="text-base font-bold text-white text-center">
                Posicione a placa dentro da moldura
            </text>
            <text class="text-xs text-gray-400 text-center font-medium">
                A leitura é enviada ao terminal da guarita
            </text>
        </column>
    </column>

    {{-- Controles Inferiores da Câmera --}}
    <column class="w-full items-center gap-4 pb-4">
        <row class="w-full items-center justify-around px-4">
            {{-- Miniatura da Última Captura com Contador --}}
            <stack class="relative" @tap="openLastCapture">
                <column class="w-14 h-14 rounded-2xl bg-[#1E2026] border border-gray-700 items-center justify-center p-1.5 shadow-md">
                    <column class="w-full h-8 bg-white rounded-sm border border-gray-400 items-center justify-between overflow-hidden">
                        <row class="w-full bg-[#003399] h-2 px-0.5 items-center justify-between">
                            <text class="text-[5px] font-black text-white">BR</text>
                        </row>
                        <text class="text-[8px] font-black text-black">
                            {{ $lastPlate }}
                        </text>
                    </column>
                </column>

                <row class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-amber-500 items-center justify-center shadow">
                    <text class="text-[10px] font-black text-black">
                        {{ $lastPlateBadge }}
                    </text>
                </row>
            </stack>

            {{-- Botão Central do Obturador (Shutter) --}}
            <column
                class="w-20 h-20 rounded-full border-4 border-white/25 p-1 items-center justify-center active:scale-95"
                @tap="capture"
            >
                <column class="w-full h-full rounded-full bg-[#8B0024] shadow-lg shadow-[#8B0024]/50"></column>
            </column>

            {{-- Botão de Inversão da Câmera --}}
            <column
                class="w-14 h-14 rounded-full bg-white/10 items-center justify-center active:bg-white/20"
                @tap="flipCamera"
            >
                <native:icon name="arrow-clockwise" :size="24" class="text-white" />
            </column>
        </row>

        {{-- Texto de Rodapé --}}
        <text class="text-xs text-gray-400 text-center font-medium">
            Toque para capturar • o envio é automático
        </text>
    </column>
</column>