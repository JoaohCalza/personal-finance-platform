<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', ['title' => __('Bem-vindo')])
    </head>
    <body class="min-h-screen bg-white text-zinc-800 antialiased dark:bg-zinc-950 dark:text-zinc-100">
        {{-- Cabeçalho --}}
        <header class="sticky top-0 z-30 border-b border-zinc-200/70 bg-white/80 backdrop-blur dark:border-zinc-800 dark:bg-zinc-950/80">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold">
                    <span class="flex size-8 items-center justify-center rounded-lg bg-emerald-600 text-white">
                        <x-app-logo-icon class="size-5 fill-current" />
                    </span>
                    <span>{{ config('app.name') }}</span>
                </a>

                <nav class="flex items-center gap-2 text-sm font-medium">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
                            {{ __('Ir para o painel') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-lg px-4 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800">
                            {{ __('Entrar') }}
                        </a>
                        <a href="{{ route('register') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
                            {{ __('Criar conta') }}
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <main>
            {{-- Hero --}}
            <section class="relative overflow-hidden">
                <div class="pointer-events-none absolute inset-x-0 -top-40 -z-10 flex justify-center blur-3xl" aria-hidden="true">
                    <div class="aspect-[2/1] w-[60rem] bg-gradient-to-tr from-emerald-300 to-teal-500 opacity-25 dark:opacity-15"></div>
                </div>

                <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:py-24">
                    <div class="flex flex-col gap-6">
                        <h1 class="text-4xl font-semibold tracking-tight text-balance sm:text-5xl">
                            {{ __('Seu dinheiro e seus investimentos em um só lugar.') }}
                        </h1>

                        <p class="max-w-xl text-lg text-zinc-600 dark:text-zinc-400">
                            {{ __('Registre receitas e gastos por categoria, acompanhe suas criptomoedas e a renda fixa, e veja o saldo e o resultado da carteira atualizados — no computador ou no celular.') }}
                        </p>

                        <div class="flex flex-wrap gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="rounded-lg bg-emerald-600 px-5 py-3 font-medium text-white shadow-sm hover:bg-emerald-700">
                                    {{ __('Abrir meu painel') }}
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="rounded-lg bg-emerald-600 px-5 py-3 font-medium text-white shadow-sm hover:bg-emerald-700">
                                    {{ __('Começar agora') }}
                                </a>
                                <a href="{{ route('login') }}" class="rounded-lg border border-zinc-300 px-5 py-3 font-medium hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-900">
                                    {{ __('Já tenho conta') }}
                                </a>
                            @endauth
                        </div>
                    </div>

                    {{-- Prévia do painel (dados ilustrativos) --}}
                    <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-xl shadow-emerald-900/5 dark:border-zinc-800 dark:bg-zinc-900" aria-label="{{ __('Exemplo do painel') }}">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-zinc-500">{{ __('Saldo do mês') }}</p>
                            <span class="rounded-md bg-zinc-100 px-2 py-0.5 text-xs text-zinc-500 dark:bg-zinc-800">{{ __('Exemplo') }}</span>
                        </div>
                        <p class="mt-1 text-3xl font-semibold">R$ 3.240,50</p>

                        <div class="mt-5 grid grid-cols-2 gap-3">
                            <div class="rounded-xl bg-emerald-50 p-3 dark:bg-emerald-950/50">
                                <p class="text-xs text-emerald-700 dark:text-emerald-300">{{ __('Receitas') }}</p>
                                <p class="font-semibold text-emerald-700 dark:text-emerald-300">+ R$ 6.800,00</p>
                            </div>
                            <div class="rounded-xl bg-red-50 p-3 dark:bg-red-950/40">
                                <p class="text-xs text-red-600 dark:text-red-300">{{ __('Gastos') }}</p>
                                <p class="font-semibold text-red-600 dark:text-red-300">− R$ 3.559,50</p>
                            </div>
                        </div>

                        <div class="mt-5 flex flex-col gap-2">
                            @foreach ([['Alimentação', 72], ['Moradia', 55], ['Transporte', 30], ['Lazer', 18]] as [$categoria, $percentual])
                                <div class="flex items-center gap-3 text-sm">
                                    <span class="w-24 shrink-0 text-zinc-500">{{ $categoria }}</span>
                                    <div class="h-2 flex-1 rounded-full bg-zinc-100 dark:bg-zinc-800">
                                        <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $percentual }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5 border-t border-zinc-200 pt-4 dark:border-zinc-800">
                            <p class="mb-2 text-sm font-medium">{{ __('Carteira cripto') }}</p>
                            <ul class="flex flex-col gap-2 text-sm">
                                @foreach ([['BTC', 'Bitcoin', '+12,4%', true], ['ETH', 'Ethereum', '+5,1%', true], ['SOL', 'Solana', '−3,2%', false]] as [$simbolo, $nome, $variacao, $positivo])
                                    <li class="flex items-center justify-between">
                                        <span class="flex items-center gap-2">
                                            <span class="flex size-7 items-center justify-center rounded-full bg-zinc-100 text-[10px] font-bold dark:bg-zinc-800">{{ $simbolo }}</span>
                                            {{ $nome }}
                                        </span>
                                        <span @class(['font-medium', 'text-emerald-600 dark:text-emerald-400' => $positivo, 'text-red-500' => ! $positivo])>{{ $variacao }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Funcionalidades --}}
            <section class="border-t border-zinc-200 bg-zinc-50 py-16 dark:border-zinc-800 dark:bg-zinc-900/40 lg:py-24">
                <div class="mx-auto max-w-6xl px-4 sm:px-6">
                    <div class="max-w-2xl">
                        <h2 class="text-3xl font-semibold tracking-tight">{{ __('Tudo o que você precisa para controlar suas finanças') }}</h2>
                        <p class="mt-3 text-zinc-600 dark:text-zinc-400">{{ __('Do gasto do dia a dia ao lucro dos seus investimentos.') }}</p>
                    </div>

                    <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ([
                            ['arrows-right-left', 'Receitas e gastos', 'Registre entradas e saídas com valor, descrição, categoria e data.'],
                            ['tag', 'Categorias', 'Organize tudo em categorias como alimentação, transporte e lazer.'],
                            ['wallet', 'Carteira de cripto', 'Lance compras e vendas e veja preço médio, quantidade e valor investido.'],
                            ['chart-bar', 'Lucro e prejuízo', 'Cotações atualizadas por API mostram o resultado de cada posição.'],
                            ['building-library', 'Renda fixa', 'Cadastre aplicações com tipo, taxa, valor aplicado e vencimento.'],
                            ['bell-alert', 'Alertas de preço', 'Defina um valor-alvo e acompanhe quando o ativo chegar lá.'],
                        ] as [$icone, $titulo, $descricao])
                            <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-800 dark:bg-zinc-900">
                                <span class="flex size-10 items-center justify-center rounded-lg bg-emerald-600/10 text-emerald-600 dark:text-emerald-400">
                                    <flux:icon :name="$icone" class="size-5" />
                                </span>
                                <h3 class="mt-4 font-semibold">{{ __($titulo) }}</h3>
                                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">{{ __($descricao) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Como funciona --}}
            <section class="py-16 lg:py-24">
                <div class="mx-auto grid max-w-6xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:items-center">
                    <div>
                        <h2 class="text-3xl font-semibold tracking-tight">{{ __('Comece em três passos') }}</h2>
                        <ol class="mt-8 flex flex-col gap-6">
                            @foreach ([
                                ['Crie sua conta', 'Cadastro rápido com nome, e-mail e senha.'],
                                ['Monte suas categorias e carteiras', 'Defina como quer organizar seu dinheiro e seus ativos.'],
                                ['Registre e acompanhe', 'Lance suas movimentações e veja o saldo e os resultados na hora.'],
                            ] as $indice => [$titulo, $descricao])
                                <li class="flex gap-4">
                                    <span class="flex size-9 shrink-0 items-center justify-center rounded-full bg-emerald-600 font-semibold text-white">{{ $indice + 1 }}</span>
                                    <div>
                                        <h3 class="font-semibold">{{ __($titulo) }}</h3>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __($descricao) }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="flex items-center gap-6 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 p-8 text-white">
                        <flux:icon name="device-phone-mobile" class="size-14 shrink-0 opacity-90" />
                        <div>
                            <h3 class="text-xl font-semibold">{{ __('Acesse de qualquer lugar') }}</h3>
                            <p class="mt-1 text-emerald-50/90">{{ __('A plataforma funciona no navegador do computador e do celular. Sem instalar nada.') }}</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-zinc-200 py-6 text-center text-sm text-zinc-500 dark:border-zinc-800">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </footer>

        @fluxScripts
    </body>
</html>
