<div> <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-medium mb-4">Adicionar Nova Bandeira</h3>

                    <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

                        <div class="md:col-span-1">
                            <x-input-label for="nome" value="Nome da Bandeira" />
                            <x-text-input wire:model="nome" id="nome" type="text" class="mt-1 block w-full" />
                            @error('nome') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-1">
                            <x-input-label for="grupo_economico_id" value="Grupo Econômico" />
                            <select wire:model="grupo_economico_id" id="grupo_economico_id" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Selecione um Grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option>
                                @endforeach
                            </select>
                            @error('grupo_economico_id') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-1">
                            <x-primary-button type="submit">Salvar</x-primary-button>
                        </div>
                    </form>

                    <h3 class="text-lg font-medium mt-8 mb-4">Bandeiras Existentes</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nome da Bandeira</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Grupo Econômico</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse ($bandeiras as $bandeira)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $bandeira->nome }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $bandeira->grupoEconomico->nome ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="abrirModalEdicao({{ $bandeira->id }})" class="text-indigo-400 hover:text-indigo-600">Editar</button>
                                            <button wire:click="abrirModalDelecao({{ $bandeira->id }})" class="text-red-400 hover:text-red-600 ml-4">Excluir</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center">
                                            Nenhuma bandeira encontrada.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $bandeiras->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($bandeiraParaEditar)
        <x-modal name="edit-bandeira" :show="true" focusable>
            <form wire:submit="update" class="p-6 dark:bg-gray-800">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Editar Bandeira
                </h2>

                <div class="mt-4">
                    <x-input-label for="nomeEdicao" value="Nome" />
                    <x-text-input wire:model="nomeEdicao" id="nomeEdicao" type="text" class="mt-1 block w-full" />
                    @error('nomeEdicao') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-input-label for="grupoEdicao_id" value="Grupo Econômico" />
                    <select wire:model="grupoEdicao_id" id="grupoEdicao_id" 
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option>
                        @endforeach
                    </select>
                    @error('grupoEdicao_id') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" wire:click="fecharModalEdicao">Cancelar</x-secondary-button>
                    <x-primary-button type="submit" class="ms-3">Salvar</x-primary-button>
                </div>
            </form>
        </x-modal>
    @endif

    @if($bandeiraParaDeletar)
        <x-modal name="delete-bandeira" :show="true" focusable>
            <div class="p-6 dark:bg-gray-800">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Confirmar Exclusão</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Você tem certeza que deseja excluir a bandeira "{{ $bandeiraParaDeletar->nome }}"?
                </p>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" wire:click="fecharModalDelecao">Cancelar</x-secondary-button>
                    <x-danger-button type="button" class="ms-3" wire:click="delete">Excluir</x-danger-button>
                </div>
            </div>
        </x-modal>
    @endif

</div>