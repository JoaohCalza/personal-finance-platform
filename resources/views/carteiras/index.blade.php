<x-layouts::app :title="__('Carteiras')">
    <div class="flex flex-col gap-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Carteiras') }}</flux:heading>
                <flux:subheading>{{ __('Agrupe seus ativos em carteiras.') }}</flux:subheading>
            </div>

            <flux:button variant="primary" icon="plus" :href="route('carteiras.create')" wire:navigate>
                {{ __('Nova carteira') }}
            </flux:button>
        </div>

        @include('partials.flash')

        @if ($carteiras->isEmpty())
            <div class="rounded-xl border border-dashed border-zinc-300 p-10 text-center dark:border-zinc-700">
                <flux:text>{{ __('Nenhuma carteira cadastrada.') }}</flux:text>
            </div>
        @else
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>{{ __('Nome') }}</flux:table.column>
                    <flux:table.column>{{ __('Criada em') }}</flux:table.column>
                    <flux:table.column align="end">{{ __('Ações') }}</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($carteiras as $carteira)
                        <flux:table.row :key="$carteira->id">
                            <flux:table.cell variant="strong">{{ $carteira->nome }}</flux:table.cell>
                            <flux:table.cell>{{ $carteira->created_at?->format('d/m/Y') }}</flux:table.cell>
                            <flux:table.cell align="end">
                                <div class="flex justify-end gap-1">
                                    <flux:button size="sm" variant="ghost" icon="eye" :href="route('carteiras.show', $carteira)" wire:navigate :aria-label="__('Ver')" />
                                    <flux:button size="sm" variant="ghost" icon="pencil-square" :href="route('carteiras.edit', $carteira)" wire:navigate :aria-label="__('Editar')" />
                                    <form method="POST" action="{{ route('carteiras.destroy', $carteira) }}" onsubmit="return confirm('{{ __('Excluir esta carteira?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button size="sm" variant="ghost" icon="trash" type="submit" class="text-red-500!" :aria-label="__('Excluir')" />
                                    </form>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        @endif
    </div>
</x-layouts::app>
