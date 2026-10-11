@use('App\Icons\Ios')
@use('App\Icons\Android')
<scroll-view fill class="safe-area bg-[#FAF6F7]">
    <column ref="login-screen" fill center class="w-full px-6 py-8 justify-center gap-6">
        {{-- Tag Superior: Centro Paula Souza --}}
        <row class="items-center gap-2 px-4 py-1.5 rounded-full bg-[#FCECEE] self-center">
            <column class="w-2 h-2 rounded-full bg-[#8B0024]"></column>
            <text class="text-[11px] font-bold tracking-wider text-[#8B0024] uppercase">
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
                        <text class="text-2xl font-bold text-gray-900 tracking-tight">
                            Sentinela
                        </text>
                        <row class="px-2 py-0.5 rounded-md bg-[#FCECEE]">
                            <text class="text-xs font-bold text-[#8B0024]">
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
                @if ($errorMessage)
                    <row class="w-full p-3 rounded-xl bg-red-50 border border-red-200 items-center gap-2">
                        <native:icon name="error" :size="18" class="text-red-600" />
                        <text class="flex-1 text-xs font-semibold text-red-700">
                            {{ $errorMessage }}
                        </text>
                    </row>
                @endif

                {{-- Campo de Usuário --}}
                <column class="w-full gap-1.5">
                    <text class="text-xs font-bold text-gray-700">
                        Código ou Usuário
                    </text>
                    <row class="w-full h-14 items-center gap-3 px-4 rounded-2xl border-2 border-[#8B0024] bg-white">
                        <native:icon name="person" :size="20" class="text-[#8B0024]" />
                        <native:bare-text-input class="flex-1 text-sm font-semibold text-gray-800 uppercase" native:model="codigo_operador"
                            placeholder="Codigo de Acesso" keyboard="default" autocapitalize="characters" />
                    </row>
                </column>

                {{-- Campo de Senha --}}
                <column class="w-full gap-1.5">
                    <text class="text-xs font-bold text-gray-700">
                        Senha
                    </text>
                    <row class="w-full h-14 items-center gap-3 px-4 rounded-2xl border-2 border-[#8B0024] bg-white">
                        <native:icon name="lock" :size="20" class="text-[#8B0024]" />

                        <native:bare-text-input class="flex-1 text-sm font-semibold text-gray-800" native:model="senha"
                            placeholder="Digite sua senha" :secure="!$showPassword" />

                        <column @tap="togglePassword">
                            <native:icon :android="$showPassword ? 'visibility_off' : 'visibility'" :size="20"
                                class="text-gray-400" />
                        </column>
                    </row>
                </column>
            </column>

            {{-- Botão Acessar Terminal --}}
            <row class="w-full h-14 items-center justify-center gap-2.5 rounded-2xl bg-[#8B0024] shadow-lg"
                @tap="{{ $isLoading ? '' : 'login' }}">
                @if ($isLoading)
                    <native:activity-indicator size="18" color="#ffffff" />
                    <text class="text-base font-bold text-white tracking-wide">
                        Autenticando...
                    </text>
                @else
                    <text class="text-base font-bold text-white tracking-wide">
                        Acessar Terminal
                    </text>
                @endif
            </row>
        </column>

        {{-- Rodapé --}}
        <text class="text-xs text-gray-400 font-medium text-center">
            Sentinela FATEC • Centro Paula Souza
        </text>
    </column>
</scroll-view>
