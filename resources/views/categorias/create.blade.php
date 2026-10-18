<x-layouts::app :title="__('Criar categoria')">
    <div class="flex flex-col gap-6">
        <flux:heading size="xl" level="1">{{ __('Criar categoria') }}</flux:heading>

        <form method="POST" action="{{ route('categorias.store') }}">
            @csrf
            @include('categorias.form', ['botao' => __('Salvar')])
        </form>
    </div>
</x-layouts::app>
