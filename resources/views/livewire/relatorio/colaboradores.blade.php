<div> <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-900 dark:border-green-600 dark:text-green-300" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Filtros do Relatório</h3>
                        <a 
                            href="{{ route('relatorios.exportar', [
                                'grupo_id' => $filtro_grupo_id,
                                'bandeira_id' => $filtro_bandeira_id,
                                'unidade_id' => $filtro_unidade_id
                            ]) }}"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Exportar para Excel
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <x-input-label for="filtro_grupo_id" value="Grupo Econômico" />
                            <select wire:model.live="filtro_grupo_id" id="filtro_grupo_id" class="mt-1 block w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                <option value="">Todos os Grupos</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="filtro_bandeira_id" value="Bandeira" />
                            <select wire:model.live="filtro_bandeira_id" id="filtro_bandeira_id" class="mt-1 block w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                <option value="">Todas as Bandeiras</option>
                                @foreach($bandeiras as $bandeira)
                                    <option value="{{ $bandeira->id }}">{{ $bandeira->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="filtro_unidade_id" value="Unidade" />
                            <select wire:model.live="filtro_unidade_id" id="filtro_unidade_id" class="mt-1 block w-full dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm border-gray-300 dark:border-gray-700">
                                <option value="">Todas as Unidades</
                                <option>
                                @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}">{{ $unidade->nome_fantasia }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h3 class="text-lg font-medium mt-8 mb-4">Resultados</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Colaborador</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email/CPF</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Unidade</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Bandeira</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Grupo</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse ($colaboradores as $colaborador)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $colaborador->nome }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>{{ $colaborador->email }}</div>
                                            <div class="text-sm text-gray-500">{{ $colaborador->cpf }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $colaborador->unidade->nome_fantasia ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowP">{{ $colaborador->unidade->bandeira->nome ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $colaborador->unidade->bandeira->grupoEconomico->nome ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center">
                                            Nenhum colaborador encontrado para os filtros selecionados.
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
</div> ```