@php($tipoSelecionado = old('tipo', $categoria->tipo ?? ''))

<div class="flex max-w-lg flex-col gap-6">
    <flux:input name="nome" :label="__('Nome')" :value="old('nome', $categoria->nome ?? '')" maxlength="255" required autofocus />

    <flux:select name="tipo" :label="__('Tipo')" :placeholder="__('Selecione...')" required>
        <flux:select.option value="receita" :selected="$tipoSelecionado === 'receita'">{{ __('Receita') }}</flux:select.option>
        <flux:select.option value="despesa" :selected="$tipoSelecionado === 'despesa'">{{ __('Despesa') }}</flux:select.option>
    </flux:select>

    <div class="flex gap-2">
        <flux:button variant="primary" type="submit">{{ $botao }}</flux:button>
        <flux:button variant="ghost" :href="route('categorias.index')" wire:navigate>{{ __('Cancelar') }}</flux:button>
    </div>
</div>
