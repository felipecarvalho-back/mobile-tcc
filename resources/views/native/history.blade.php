<column fill class="w-full h-full bg-[#FAF8F8]">
    {{-- Topo: Título, Botão de Atualizar e Barra de Pesquisa --}}
    <column class="w-full safe-area px-5 pt-10 pb-2 gap-3.5 bg-white/70 border-b border-gray-100">
        <native:offline-banner :is-offline="$isOffline" />

        {{-- Linha de Título e Botão de Atualizar --}}
        <row class="w-full items-center justify-between">
            <text class="text-2xl font-black text-gray-900 tracking-tight">
                Histórico de Capturas
            </text>

            <row
                class="items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-gray-200 shadow-sm"
                @tap="{{ $isLoading ? '' : 'loadHistory' }}"
            >
                <native:icon name="refresh" :size="16" class="text-[#8B0024]" />
                <text class="text-xs font-bold text-[#8B0024]">
                    Atualizar
                </text>
            </row>
        </row>

        {{-- Barra de Busca --}}
        <row class="w-full items-center gap-2.5 px-4 py-3 rounded-2xl bg-white border border-gray-200/90 shadow-sm">
            <native:icon name="magnifyingglass" :size="18" class="text-gray-400" />
            <native:bare-text-input
                native:model="search"
                placeholder="Buscar placa ou condutor..."
                class="flex-1 text-sm text-gray-800 bg-transparent font-medium"
            />
        </row>

        {{-- Chips Horizontais de Filtro Rápido --}}
        <scroll-view horizontal class="w-full py-1">
            <row class="items-center gap-2">
                {{-- Chip Hoje (Todos) --}}
                <row
                    class="items-center gap-1.5 px-4 py-2 rounded-full {{ $selectedFilter === 'hoje' ? 'bg-[#8B0024]' : 'bg-white border border-gray-200' }} shadow-sm"
                    @tap="setFilter('hoje')"
                >
                    <native:icon name="checkmark" :size="12" class="{{ $selectedFilter === 'hoje' ? 'text-white' : 'text-gray-600' }}" />
                    <text class="text-xs font-bold {{ $selectedFilter === 'hoje' ? 'text-white' : 'text-gray-700' }}">
                        Hoje ({{ $total }})
                    </text>
                </row>

                {{-- Chip Docentes --}}
                <row
                    class="items-center px-4 py-2 rounded-full {{ $selectedFilter === 'docentes' ? 'bg-[#8B0024]' : 'bg-white border border-gray-200' }} shadow-sm"
                    @tap="setFilter('docentes')"
                >
                    <text class="text-xs font-bold {{ $selectedFilter === 'docentes' ? 'text-white' : 'text-gray-700' }}">
                        Docentes
                    </text>
                </row>

                {{-- Chip Funcionários --}}
                <row
                    class="items-center px-4 py-2 rounded-full {{ $selectedFilter === 'funcionarios' ? 'bg-[#8B0024]' : 'bg-white border border-gray-200' }} shadow-sm"
                    @tap="setFilter('funcionarios')"
                >
                    <text class="text-xs font-bold {{ $selectedFilter === 'funcionarios' ? 'text-white' : 'text-gray-700' }}">
                        Funcionários
                    </text>
                </row>

                {{-- Chip Prestadores --}}
                <row
                    class="items-center px-4 py-2 rounded-full {{ $selectedFilter === 'prestadores' ? 'bg-[#8B0024]' : 'bg-white border border-gray-200' }} shadow-sm"
                    @tap="setFilter('prestadores')"
                >
                    <text class="text-xs font-bold {{ $selectedFilter === 'prestadores' ? 'text-white' : 'text-gray-700' }}">
                        Prestadores
                    </text>
                </row>

                {{-- Chip Visitantes --}}
                <row
                    class="items-center px-4 py-2 rounded-full {{ $selectedFilter === 'visitantes' ? 'bg-[#8B0024]' : 'bg-white border border-gray-200' }} shadow-sm"
                    @tap="setFilter('visitantes')"
                >
                    <text class="text-xs font-bold {{ $selectedFilter === 'visitantes' ? 'text-white' : 'text-gray-700' }}">
                        Visitantes
                    </text>
                </row>

                {{-- Chip Sem Placa --}}
                <row
                    class="items-center px-4 py-2 rounded-full {{ $selectedFilter === 'sem_placa' ? 'bg-[#8B0024]' : 'bg-white border border-gray-200' }} shadow-sm"
                    @tap="setFilter('sem_placa')"
                >
                    <text class="text-xs font-bold {{ $selectedFilter === 'sem_placa' ? 'text-white' : 'text-gray-700' }}">
                        Sem Placa
                    </text>
                </row>
            </row>
        </scroll-view>
    </column>

    {{-- Lista de Capturas com Scroll --}}
    <scroll-view class="flex-1 w-full px-4 py-3 gap-4">
        <column class="w-full gap-3 pb-6">
            <row class="w-full items-center justify-between px-1">
                <text class="text-xs font-black tracking-wider text-gray-800 uppercase">
                    Hoje • {{ $dataReferencia }}
                </text>
                <text class="text-xs font-semibold text-gray-400">
                    {{ count($filteredCaptures) }} {{ count($filteredCaptures) === 1 ? 'captura' : 'capturas' }}
                </text>
            </row>

            @if ($errorMessage)
                <column class="w-full bg-red-50 border border-red-200 rounded-2xl p-4 gap-3 items-center">
                    <text class="text-xs font-bold text-red-700 text-center">
                        {{ $errorMessage }}
                    </text>
                    <row class="px-4 py-2 rounded-xl bg-[#8B0024]" @tap="loadHistory">
                        <text class="text-xs font-bold text-white">Tentar novamente</text>
                    </row>
                </column>
            @endif

            @if ($isLoading && empty($todayCaptures))
                <column class="w-full py-12 items-center justify-center gap-3">
                    <native:activity-indicator size="24" color="#8B0024" />
                    <text class="text-sm font-semibold text-gray-500">
                        Carregando capturas de hoje...
                    </text>
                </column>
            @elseif (empty($filteredCaptures))
                <column class="w-full bg-white rounded-2xl border border-gray-200/80 p-8 items-center justify-center gap-2">
                    <native:icon name="camera" :size="28" class="text-gray-300" />
                    <text class="text-sm font-bold text-gray-700 text-center">
                        Nenhuma captura encontrada hoje
                    </text>
                    <text class="text-xs text-gray-400 text-center">
                        As fotos tiradas pela câmera aparecerão aqui automaticamente.
                    </text>
                </column>
            @else
                @foreach ($filteredCaptures as $item)
                    <native:vehicle-card
                        :plate="$item['plate']"
                        :plateIdentified="$item['plateIdentified']"
                        :photo="$item['photo']"
                        :title="$item['title']"
                        :subtitle="$item['subtitle']"
                        :status="$item['status']"
                        :statusLabel="$item['statusLabel']"
                        :time="$item['time']"
                        :corrected="$item['corrected']"
                        :photosCount="$item['photosCount']"
                        key="history-today-{{ $item['id'] }}"
                    />
                @endforeach
            @endif
        </column>
    </scroll-view>

    {{-- Barra de Navegação Inferior --}}
    <native:app-bottom-bar active="history" />
</column>
