<div> <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <h3 class="text-lg font-medium mb-4">Adicionar Novo Colaborador</h3>
                    
                    <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        
                        <div class="md:col-span-1">
                            <x-input-label for="nome" value="Nome Completo" />
                            <x-text-input wire:model="nome" id="nome" type="text" class="mt-1 block w-full" />
                            @error('nome') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-1">
                            <x-input-label for="email" value="Email" />
                            <x-text-input wire:model="email" id="email" type="email" class="mt-1 block w-full" />
                            @error('email') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-1">
                            <x-input-label for="cpf" value="CPF" />
                            <x-text-input wire:model="cpf" id="cpf" type="text" class="mt-1 block w-full" />
                            @error('cpf') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-1">
                            <x-input-label for="unidade_id" value="Unidade" />
                            <select wire:model="unidade_id" id="unidade_id" 
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Selecione uma Unidade</option>
                                @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}">{{ $unidade->nome_fantasia }}</option>
                                @endforeach
                            </select>
                            @error('unidade_id') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-4 mt-4">
                            <x-primary-button type="submit">Salvar Colaborador</x-primary-button>
                        </div>
                    </form>
                    
                    <h3 class="text-lg font-medium mt-8 mb-4">Colaboradores Existentes</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unidade</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse ($colaboradores as $colaborador)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $colaborador->nome }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $colaborador->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $colaborador->unidade->nome_fantasia ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="abrirModalEdicao({{ $colaborador->id }})" class="text-indigo-400 hover:text-indigo-600">Editar</button>
                                            <button wire:click="abrirModalDelecao({{ $colaborador->id }})" class="text-red-400 hover:text-red-600 ml-4">Excluir</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center">
                                            Nenhum colaborador encontrado.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">{{ $colaboradores->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($colaboradorParaEditar)
        <x-modal name="edit-colaborador" :show="true" focusable>
            <form wire:submit="update" class="p-6 dark:bg-gray-800">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Editar Colaborador
                </h2>
                
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="nome_edicao" value="Nome Completo" />
                        <x-text-input wire:model="nome_edicao" id="nome_edicao" type="text" class="mt-1 block w-full" />
                        @error('nome_edicao') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="email_edicao" value="Email" />
                        <x-text-input wire:model="email_edicao" id="email_edicao" type="email" class="mt-1 block w-full" />
                        @error('email_edicao') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="cpf_edicao" value="CPF" />
                        <x-text-input wire:model="cpf_edicao" id="cpf_edicao" type="text" class="mt-1 block w-full" />
                        @error('cpf_edicao') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="unidade_id_edicao" value="Unidade" />
                        <select wire:model="unidade_id_edicao" id="unidade_id_edicao" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            @foreach($unidades as $unidade)
                                <option value="{{ $unidade->id }}">{{ $unidade->nome_fantasia }}</option>
                            @endforeach
                        </select>
                        @error('unidade_id_edicao') <span class="text-sm text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" wire:click="fecharModalEdicao">Cancelar</x-secondary-button>
                    <x-primary-button type="submit" class="ms-3">Salvar</x-primary-button>
                </div>
            </form>
        </x-modal>
    @endif

    @if($colaboradorParaDeletar)
        <x-modal name="delete-colaborador" :show="true" focusable>
            <div class="p-6 dark:bg-gray-800">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Confirmar Exclusão</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Você tem certeza que deseja excluir o colaborador "{{ $colaboradorParaDeletar->nome }}"?
                </p>
                <div class="mt-6 flex justify-end">
                    <x-secondary-button type="button" wire:click="fecharModalDelecao">Cancelar</x-secondary-button>
                    <x-danger-button type="button" class="ms-3" wire:click="delete">Excluir</x-danger-button>
                </div>
            </div>
        </x-modal>
    @endif

</div>