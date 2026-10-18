<x-layouts::app :title="$carteira->nome">
    <div class="flex max-w-lg flex-col gap-6">
        <flux:heading size="xl" level="1">{{ $carteira->nome }}</flux:heading>

        <flux:card class="flex flex-col gap-4">
            <div>
                <flux:text>{{ __('Nome') }}</flux:text>
                <flux:heading>{{ $carteira->nome }}</flux:heading>
            </div>
            <div>
                <flux:text>{{ __('Criada em') }}</flux:text>
                <flux:heading>{{ $carteira->created_at?->format('d/m/Y H:i') }}</flux:heading>
            </div>
            <div>
                <flux:text>{{ __('Atualizada em') }}</flux:text>
                <flux:heading>{{ $carteira->updated_at?->format('d/m/Y H:i') }}</flux:heading>
            </div>
        </flux:card>

        <div class="flex gap-2">
            <flux:button variant="primary" icon="pencil-square" :href="route('carteiras.edit', $carteira)" wire:navigate>{{ __('Editar') }}</flux:button>
            <flux:button variant="ghost" :href="route('carteiras.index')" wire:navigate>{{ __('Voltar') }}</flux:button>
        </div>
    </div>
</x-layouts::app>
