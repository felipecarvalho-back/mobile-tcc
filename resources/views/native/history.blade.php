<column fill class="w-full h-full bg-[#FAF8F8]">
    {{-- Topo: Título, Botão de Filtro e Barra de Pesquisa --}}
    <column class="w-full safe-area px-5 pt-10 pb-2 gap-3.5 bg-white/70 border-b border-gray-100">
        {{-- Linha de Título e Ação de Filtro --}}
        <row class="w-full items-center justify-between">
            <text class="text-2xl font-black text-gray-900 tracking-tight">
                Histórico de Capturas
            </text>

            <stack class="relative" @tap="openFilterSheet">
                <column class="w-10 h-10 rounded-2xl bg-white border border-gray-200 items-center justify-center shadow-sm">
                    <native:icon name="line-3-horizontal-decrease" :size="18" class="text-gray-700" />
                </column>
                <column class="absolute top-2 right-2 w-2 h-2 rounded-full bg-[#8B0024]"></column>
            </stack>
        </row>

        {{-- Barra de Busca --}}
        <row class="w-full items-center gap-2.5 px-4 py-3 rounded-2xl bg-white border border-gray-200/90 shadow-sm">
            <native:icon name="magnifyingglass" :size="18" class="text-gray-400" />
            <native:bare-text-input
                native:model="search"
                placeholder="Ex: BRA, ABC..."
                class="flex-1 text-sm text-gray-800 bg-transparent font-medium"
            />
        </row>

        {{-- Chips Horizontais de Filtro Rápido --}}
        <scroll-view horizontal class="w-full py-1">
            <row class="items-center gap-2">
                {{-- Chip Hoje Ativo --}}
                <row
                    class="items-center gap-1.5 px-4 py-2 rounded-full {{ $selectedFilter === 'hoje' ? 'bg-[#8B0024]' : 'bg-white border border-gray-200' }} shadow-sm"
                    @tap="setFilter('hoje')"
                >
                    <native:icon name="checkmark" :size="12" class="{{ $selectedFilter === 'hoje' ? 'text-white' : 'text-gray-600' }}" />
                    <text class="text-xs font-bold {{ $selectedFilter === 'hoje' ? 'text-white' : 'text-gray-700' }}">
                        Hoje
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
            </row>
        </scroll-view>
    </column>

    {{-- Lista de Capturas com Scroll --}}
    <scroll-view class="flex-1 w-full px-4 py-3 gap-4">
        {{-- Seção: HOJE • 21/09/2026 --}}
        <column class="w-full gap-3">
            <row class="w-full items-center justify-between px-1">
                <text class="text-xs font-black tracking-wider text-gray-800 uppercase">
                    Hoje • 21/09/2026
                </text>
                <text class="text-xs font-semibold text-gray-400">
                    18 capturas
                </text>
            </row>

            @foreach ($todayCaptures as $item)
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
                    key="history-today-{{ $item['plate'] }}"
                />
            @endforeach
        </column>

        {{-- Seção: ONTEM • 20/09/2026 --}}
        <column class="w-full gap-3 pt-2 pb-6">
            <row class="w-full items-center justify-between px-1">
                <text class="text-xs font-black tracking-wider text-gray-800 uppercase">
                    Ontem • 20/09/2026
                </text>
                <text class="text-xs font-semibold text-gray-400">
                    63 capturas
                </text>
            </row>

            @foreach ($yesterdayCaptures as $item)
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
                    key="history-yesterday-{{ $item['plate'] }}"
                />
            @endforeach
        </column>
    </scroll-view>

    {{-- Barra de Navegação Inferior --}}
    <native:app-bottom-bar active="history" />
</column>