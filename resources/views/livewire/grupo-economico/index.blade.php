<div> <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-medium mb-4">Adicionar Novo Grupo</h3>
                    <form wire:submit="save" class="flex items-center space-x-4">
                        <div class="flex-1">
                            <x-text-input wire:model="nome" id="nome" name="nome" type="text" class="mt-1 block w-full" placeholder="Nome do novo grupo" />
                            @error('nome') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                        <x-primary-button type="submit">Salvar</x-primary-button>
                    </form>

                    <h3 class="text-lg font-medium mt-8 mb-4">Grupos Existentes</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Criado Em</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse ($grupos as $grupo)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $grupo->nome }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $grupo->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="abrirModalEdicao({{ $grupo->id }})" class="text-indigo-400 hover:text-indigo-600">Editar</button>
                                            <button wire:click="abrirModalDelecao({{ $grupo->id }})" class="text-red-400 hover:text-red-600 ml-4">Excluir</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center">
                                            Nenhum grupo econômico encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $grupos->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($grupoParaEditar)
        <x-modal name="edit-grupo" :show="true" focusable>
            <form wire:submit="update" class="p-6 dark:bg-gray-800">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Editar Grupo Econômico
                </h2>
                <div class="mt-4">
                    <x-input-label for="nomeEdicao" value="Nome" />
                    <x-text-input wire:model="nomeEdicao" id="nomeEdicao" type="text" class="mt-1 block w-full" />
                    @error('nomeEdicao') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" wire:click="fecharModalEdicao">
                        Cancelar
                    </x-secondary-button>
                    <x-primary-button type="submit" class="ms-3">
                        Salvar
                    </x-primary-button>
                </div>
            </form>
        </x-modal>
    @endif

    @if($grupoParaDeletar)
        <x-modal name="delete-grupo" :show="true" focusable>
            <div class="p-6 dark:bg-gray-800">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Confirmar Exclusão
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Você tem certeza que deseja excluir o grupo "{{ $grupoParaDeletar->nome }}"?
                </p>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" wire:click="fecharModalDelecao">
                        Cancelar
                    </x-secondary-button>
                    <x-danger-button type="button" class="ms-3" wire:click="delete">
                        Excluir
                    </x-danger-button>
                </div>
            </div>
        </x-modal>
    @endif

</div>