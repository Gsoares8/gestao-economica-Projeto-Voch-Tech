<div> <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-medium mb-4">Adicionar Nova Unidade</h3>

                    <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                        <div class="md:col-span-1">
                            <x-input-label for="nome_fantasia" value="Nome Fantasia" />
                            <x-text-input wire:model="nome_fantasia" id="nome_fantasia" type="text" class="mt-1 block w-full" />
                            @error('nome_fantasia') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-1">
                            <x-input-label for="razao_social" value="Razão Social" />
                            <x-text-input wire:model="razao_social" id="razao_social" type="text" class="mt-1 block w-full" />
                            @error('razao_social') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-1">
                            <x-input-label for="cnpj" value="CNPJ" />
                            <x-text-input wire:model="cnpj" id="cnpj" type="text" class="mt-1 block w-full" />
                            @error('cnpj') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-1">
                            <x-input-label for="bandeira_id" value="Bandeira" />
                            <select wire:model="bandeira_id" id="bandeira_id" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Selecione uma Bandeira</option>
                                @foreach($bandeiras as $bandeira)
                                    <option value="{{ $bandeira->id }}">{{ $bandeira->nome }}</option>
                                @endforeach
                            </select>
                            @error('bandeira_id') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-4 mt-4">
                            <x-primary-button type="submit">Salvar Unidade</x-primary-button>
                        </div>
                    </form>

                    <h3 class="text-lg font-medium mt-8 mb-4">Unidades Existentes</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nome Fantasia</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">CNPJ</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Bandeira</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse ($unidades as $unidade)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $unidade->nome_fantasia }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $unidade->cnpj }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $unidade->bandeira->nome ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="abrirModalEdicao({{ $unidade->id }})" class="text-indigo-400 hover:text-indigo-600">Editar</button>
                                            <button wire:click="abrirModalDelecao({{ $unidade->id }})" class="text-red-400 hover:text-red-600 ml-4">Excluir</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">
                                            Nenhuma unidade encontrada.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                        </table>
                    </div>
                    <div class="mt-6">{{ $unidades->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($unidadeParaEditar)
        <x-modal name="edit-unidade" :show="true" focusable>
            <form wire:submit="update" class="p-6 dark:bg-gray-800">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Editar Unidade
                </h2>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="nome_fantasia_edicao" value="Nome Fantasia" />
                        <x-text-input wire:model="nome_fantasia_edicao" id="nome_fantasia_edicao" type="text" class="mt-1 block w-full" />
                        @error('nome_fantasia_edicao') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="razao_social_edicao" value="Razão Social" />
                        <x-text-input wire:model="razao_social_edicao" id="razao_social_edicao" type="text" class="mt-1 block w-full" />
                        @error('razao_social_edicao') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="cnpj_edicao" value="CNPJ" />
                        <x-text-input wire:model="cnpj_edicao" id="cnpj_edicao" type="text" class="mt-1 block w-full" />
                        @error('cnpj_edicao') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="bandeira_id_edicao" value="Bandeira" />
                        <select wire:model="bandeira_id_edicao" id="bandeira_id_edicao" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            @foreach($bandeiras as $bandeira)
                                <option value="{{ $bandeira->id }}">{{ $bandeira->nome }}</option>
                            @endforeach
                        </select>
                        @error('bandeira_id_edicao') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" wire:click="fecharModalEdicao">Cancelar</x-secondary-button>
                    <x-primary-button type="submit" class="ms-3">Salvar</x-primary-button>
                </div>
            </form>
        </x-modal>
    @endif

    @if($unidadeParaDeletar)
        <x-modal name="delete-unidade" :show="true" focusable>
            <div class="p-6 dark:bg-gray-800">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Confirmar Exclusão</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Você tem certeza que deseja excluir a unidade "{{ $unidadeParaDeletar->nome_fantasia }}"?
                </p>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" wire:click="fecharModalDelecao">Cancelar</x-secondary-button>
                    <x-danger-button type="button" class="ms-3" wire:click="delete">Excluir</x-danger-button>
                </div>
            </div>
        </x-modal>
    @endif

</div>