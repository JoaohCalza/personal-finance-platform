<x-layouts::app :title="__('Categorias')">
    <div class="flex flex-col gap-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Categorias') }}</flux:heading>
                <flux:subheading>{{ __('Organize suas receitas e despesas.') }}</flux:subheading>
            </div>

            <flux:button variant="primary" icon="plus" :href="route('categorias.create')" wire:navigate>
                {{ __('Nova categoria') }}
            </flux:button>
        </div>

        @include('partials.flash')

        @if ($categorias->isEmpty())
            <div class="rounded-xl border border-dashed border-zinc-300 p-10 text-center dark:border-zinc-700">
                <flux:text>{{ __('Nenhuma categoria cadastrada.') }}</flux:text>
            </div>
        @else
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>{{ __('Nome') }}</flux:table.column>
                    <flux:table.column>{{ __('Tipo') }}</flux:table.column>
                    <flux:table.column align="end">{{ __('Ações') }}</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($categorias as $categoria)
                        <flux:table.row :key="$categoria->id">
                            <flux:table.cell variant="strong">{{ $categoria->nome }}</flux:table.cell>
                            <flux:table.cell>
                                <flux:badge size="sm" :color="$categoria->tipo === 'receita' ? 'green' : 'red'">
                                    {{ ucfirst($categoria->tipo) }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell align="end">
                                <div class="flex justify-end gap-1">
                                    <flux:button size="sm" variant="ghost" icon="eye" :href="route('categorias.show', $categoria)" wire:navigate :aria-label="__('Ver')" />
                                    <flux:button size="sm" variant="ghost" icon="pencil-square" :href="route('categorias.edit', $categoria)" wire:navigate :aria-label="__('Editar')" />
                                    <form method="POST" action="{{ route('categorias.destroy', $categoria) }}" onsubmit="return confirm('{{ __('Excluir esta categoria?') }}')">
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
