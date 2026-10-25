@if ($isOffline)
    <row class="w-full px-4 py-3 bg-red-600 items-center gap-3 shadow-md">
        <column class="w-8 h-8 rounded-full bg-white/20 items-center justify-center">
            <native:icon name="wifi_off" :size="18" class="text-white" />
        </column>
        <column class="flex-1 gap-0.5">
            <text class="text-xs font-black text-white uppercase tracking-wider">
                Sem conexão com a internet
            </text>
            <text class="text-[11px] font-medium text-white/90">
                O Sentinela precisa de internet para funcionar. Verifique o Wi-Fi ou dados móveis.
            </text>
        </column>
    </row>
@endif
