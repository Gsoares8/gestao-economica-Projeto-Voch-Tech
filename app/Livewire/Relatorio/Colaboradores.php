<?php

namespace App\Livewire\Relatorio;

// Imports
use App\Models\Colaborador;
use App\Models\GrupoEconomico;
use App\Models\Bandeira;
use App\Models\Unidade;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Collection;

class Colaboradores extends Component
{
    use WithPagination;

    // --- Listas para os Dropdowns ---
    public Collection $grupos; // <-- Define $grupos
    public Collection $bandeiras;
    public Collection $unidades;

    // --- Valores Selecionados nos Filtros ---
    public $filtro_grupo_id = '';
    public $filtro_bandeira_id = '';
    public $filtro_unidade_id = '';

    // 'mount' é executado uma vez quando o componente carrega
    public function mount()
    {
        // Carrega os Grupos para o primeiro dropdown
        $this->grupos = GrupoEconomico::orderBy('nome')->get();
        // As outras listas começam vazias
        $this->bandeiras = new Collection();
        $this->unidades = new Collection();
    }

    // --- Filtros em Cascata ---
    
    // Quando o usuário muda o GRUPO
    public function updatedFiltroGrupoId($value)
    {
        // Carrega as bandeiras daquele grupo
        $this->bandeiras = Bandeira::where('grupo_economico_id', $value)->orderBy('nome')->get();
        // Limpa as listas e seleções de Unidade e Colaborador
        $this->unidades = new Collection();
        $this->reset('filtro_bandeira_id', 'filtro_unidade_id');
        $this->resetPage(); // Reseta a paginação
    }

    // Quando o usuário muda a BANDEIRA
    public function updatedFiltroBandeiraId($value)
    {
        // Carrega as unidades daquela bandeira
        $this->unidades = Unidade::where('bandeira_id', $value)->orderBy('nome_fantasia')->get();
        // Limpa a seleção de Unidade
        $this->reset('filtro_unidade_id');
        $this->resetPage(); // Reseta a paginação
    }

    // Quando o usuário muda a UNIDADE
    public function updatedFiltroUnidadeId()
    {
        // Apenas reseta a paginação, a query fará o resto
        $this->resetPage();
    }


    // --- Método Render ---
    #[Layout('layouts.app')]
    public function render(): View
    {
        // Começa a consulta de Colaboradores, já com os relacionamentos
        $query = Colaborador::with('unidade.bandeira.grupoEconomico');

        // Aplica os filtros na consulta
        
        // 1. Filtro de Unidade (o mais fácil)
        $query->when($this->filtro_unidade_id, function ($q) {
            return $q->where('unidade_id', $this->filtro_unidade_id);
        });

        // 2. Filtro de Bandeira (só se Unidade não estiver selecionada)
        $query->when(!$this->filtro_unidade_id && $this->filtro_bandeira_id, function ($q) {
            return $q->whereHas('unidade', function ($subQ) {
                $subQ->where('bandeira_id', $this->filtro_bandeira_id);
            });
        });

        // 3. Filtro de Grupo (só se Bandeira e Unidade não estiverem selecionadas)
        $query->when(!$this->filtro_unidade_id && !$this->filtro_bandeira_id && $this->filtro_grupo_id, function ($q) {
            return $q->whereHas('unidade.bandeira', function ($subQ) {
                $subQ->where('grupo_economico_id', $this->filtro_grupo_id);
            });
        });

        // Executa a consulta com paginação
        $colaboradores = $query->orderBy('nome')->paginate(10);

        // Prepara o cabeçalho
        $header = Blade::render(
            '<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __("Relatório de Colaboradores") }}</h2>'
        );

        return view('livewire.relatorio.colaboradores', [
            'colaboradores' => $colaboradores,
        ])->with('header', $header);
    }
}