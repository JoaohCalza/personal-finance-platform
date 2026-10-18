<div class="flex max-w-lg flex-col gap-6">
    <flux:input name="nome" :label="__('Nome')" :value="old('nome', $carteira->nome ?? '')" maxlength="255" required autofocus />

    <div class="flex gap-2">
        <flux:button variant="primary" type="submit">{{ $botao }}</flux:button>
        <flux:button variant="ghost" :href="route('carteiras.index')" wire:navigate>{{ __('Cancelar') }}</flux:button>
    </div>
</div>
