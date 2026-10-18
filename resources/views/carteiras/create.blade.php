<x-layouts::app :title="__('Criar carteira')">
    <div class="flex flex-col gap-6">
        <flux:heading size="xl" level="1">{{ __('Criar carteira') }}</flux:heading>

        <form method="POST" action="{{ route('carteiras.store') }}">
            @csrf
            @include('carteiras.form', ['botao' => __('Salvar')])
        </form>
    </div>
</x-layouts::app>
