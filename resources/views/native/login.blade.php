<column
    ref="login-screen"
    fill
    center
    class="safe-area bg-[#FAF6F7] px-6 py-8 justify-center gap-6"
>
    {{-- Tag Superior: Centro Paula Souza --}}
    <row class="items-center gap-2 px-4 py-1.5 rounded-full bg-[#FCECEE] self-center">
        <column class="w-2 h-2 rounded-full bg-[#8B0024]"></column>
        <text class="text-[11px] font-black tracking-wider text-[#8B0024] uppercase">
            Centro Paula Souza • Governo de SP
        </text>
    </row>

    {{-- Cartão Principal de Login --}}
    <column class="w-full bg-white rounded-3xl p-6 shadow-xl border border-gray-100 gap-5">
        {{-- Faixa Vinho Decorativa no Topo do Card --}}
        <column class="w-full h-1 bg-[#8B0024] rounded-full"></column>

        {{-- Identidade do Aplicativo: Ícone, Título e Badge FATEC --}}
        <row class="w-full items-center gap-3">
            <column class="w-14 h-14 rounded-2xl bg-[#8B0024] items-center justify-center shadow-md">
                <native:icon name="shield" :size="28" class="text-white" />
            </column>

            <column class="flex-1 justify-center">
                <row class="items-center gap-2">
                    <text class="text-2xl font-black text-gray-900 tracking-tight">
                        Sentinela
                    </text>
                    <row class="px-2 py-0.5 rounded-md bg-[#FCECEE]">
                        <text class="text-xs font-black text-[#8B0024]">
                            FATEC
                        </text>
                    </row>
                </row>
                <text class="text-xs text-gray-500 font-medium mt-0.5">
                    Controle de Acesso e Portaria
                </text>
            </column>
        </row>

        {{-- Formulário de Acesso --}}
        <column class="w-full gap-4 pt-1">
            {{-- Campo de Usuário --}}
            <column class="w-full gap-1.5">
                <text class="text-xs font-bold text-gray-800">
                    Usuário
                </text>
                <row class="w-full items-center gap-3 px-4 py-3.5 rounded-2xl border border-gray-200 bg-[#F9FAFB]">
                    <native:icon name="person" :size="20" class="text-gray-400" />
                    <text class="flex-1 text-sm font-semibold text-gray-800">
                        {{ $username }}
                    </text>
                </row>
            </column>

            {{-- Campo de Senha com Foco Ativo e Cursor --}}
            <column class="w-full gap-1.5">
                <text class="text-xs font-bold text-gray-800">
                    Senha
                </text>
                <row class="w-full items-center gap-3 px-4 py-3.5 rounded-2xl border-2 border-[#8B0024] bg-white">
                    <native:icon name="lock" :size="20" class="text-[#8B0024]" />
                    <row class="flex-1 items-center gap-0.5">
                        <text class="text-base font-black text-gray-900 tracking-widest">
                            {{ $showPassword ? '123456' : '••••••' }}
                        </text>
                        <column class="w-[2px] h-4 bg-gray-900"></column>
                    </row>
                    <column @tap="togglePassword">
                        <native:icon name="eye" :size="20" class="text-gray-400" />
                    </column>
                </row>
            </column>
        </column>

        {{-- Botão Acessar Terminal --}}
        <row
            class="w-full items-center justify-center gap-2.5 py-4 rounded-2xl bg-[#8B0024] shadow-lg shadow-[#8B0024]/25 active:opacity-90"
            @tap="login"
        >
            <native:icon name="arrow-right" :size="20" class="text-white" />
            <text class="text-base font-black text-white tracking-wide">
                Acessar Terminal
            </text>
        </row>
    </column>

    {{-- Rodapé --}}
    <text class="text-xs text-gray-400 font-medium text-center">
        Sentinela FATEC • Centro Paula Souza
    </text>
</column>