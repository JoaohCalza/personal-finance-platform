<x-layouts::app :title="__('Usuários')">
    <div class="flex flex-col gap-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Usuários') }}</flux:heading>
            <flux:subheading>{{ __('Pessoas cadastradas na plataforma.') }}</flux:subheading>
        </div>

        <flux:table :paginate="$users">
            <flux:table.columns>
                <flux:table.column>{{ __('Nome') }}</flux:table.column>
                <flux:table.column>{{ __('Email') }}</flux:table.column>
                <flux:table.column>{{ __('Perfil') }}</flux:table.column>
                <flux:table.column>{{ __('Cadastrado em') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($users as $user)
                    <flux:table.row :key="$user->id">
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar size="xs" :name="$user->name" :initials="$user->initials()" />
                                <span class="font-medium text-zinc-800 dark:text-white">{{ $user->name }}</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>{{ $user->email }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" :color="$user->is_admin ? 'indigo' : 'zinc'">
                                {{ $user->is_admin ? __('Admin') : __('Usuário') }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $user->created_at?->format('d/m/Y') }}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</x-layouts::app>
