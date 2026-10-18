<x-layouts::app :title="__('Editar carteira')">
    <div class="flex flex-col gap-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Editar carteira') }}</flux:heading>
            <flux:subheading>{{ $carteira->nome }}</flux:subheading>
        </div>

        <form method="POST" action="{{ route('carteiras.update', $carteira) }}">
            @csrf
            @method('PUT')
            @include('carteiras.form', ['botao' => __('Atualizar')])
        </form>
    </div>
</x-layouts::app>
