<x-layouts::app :title="__('Editar categoria')">
    <div class="flex flex-col gap-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Editar categoria') }}</flux:heading>
            <flux:subheading>{{ $categoria->nome }}</flux:subheading>
        </div>

        <form method="POST" action="{{ route('categorias.update', $categoria) }}">
            @csrf
            @method('PUT')
            @include('categorias.form', ['botao' => __('Atualizar')])
        </form>
    </div>
</x-layouts::app>
