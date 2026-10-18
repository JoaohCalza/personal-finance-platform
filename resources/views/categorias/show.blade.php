<x-layouts::app :title="$categoria->nome">
    <div class="flex max-w-lg flex-col gap-6">
        <flux:heading size="xl" level="1">{{ $categoria->nome }}</flux:heading>

        <flux:card class="flex flex-col gap-4">
            <div>
                <flux:text>{{ __('Nome') }}</flux:text>
                <flux:heading>{{ $categoria->nome }}</flux:heading>
            </div>
            <div>
                <flux:text>{{ __('Tipo') }}</flux:text>
                <flux:badge size="sm" :color="$categoria->tipo === 'receita' ? 'green' : 'red'">{{ ucfirst($categoria->tipo) }}</flux:badge>
            </div>
        </flux:card>

        <div class="flex gap-2">
            <flux:button variant="primary" icon="pencil-square" :href="route('categorias.edit', $categoria)" wire:navigate>{{ __('Editar') }}</flux:button>
            <flux:button variant="ghost" :href="route('categorias.index')" wire:navigate>{{ __('Voltar') }}</flux:button>
        </div>
    </div>
</x-layouts::app>
