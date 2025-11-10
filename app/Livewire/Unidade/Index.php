<?php

namespace App\Livewire\Unidade;

// Imports
use App\Models\Unidade;
use App\Models\Bandeira;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection;

class Index extends Component
{
    use WithPagination;

    // --- Propriedades do Formulário de Criação ---
    public $nome_fantasia = '';
    public $razao_social = '';
    public $cnpj = '';
    public $bandeira_id = '';
    public Collection $bandeiras; // <-- DEFINE A VARIÁVEL

    // --- Propriedades do Modal de Edição ---
    public ?Unidade $unidadeParaEditar = null;
    public $nome_fantasia_edicao = '';
    public $razao_social_edicao = '';
    public $cnpj_edicao = '';
    public $bandeira_id_edicao = '';

    // --- Propriedades do Modal de Exclusão ---
    public ?Unidade $unidadeParaDeletar = null;

    // --- CARREGA AS BANDEIRAS ---
    public function mount()
    {
        $this->bandeiras = Bandeira::orderBy('nome')->get();
    }

    // --- Regras de Validação ---
    protected function rules()
    {
        return [
            'nome_fantasia' => 'required|string|max:255',
            'razao_social' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18|unique:unidades,cnpj',
            'bandeira_id' => 'required|exists:bandeiras,id',
        ];
    }

    // --- Método de Criação ---
    public function save()
    {
        $this->validate(); 
        Unidade::create([
            'nome_fantasia' => $this->nome_fantasia,
            'razao_social' => $this->razao_social,
            'cnpj' => $this->cnpj,
            'bandeira_id' => $this->bandeira_id,
        ]);
        $this->reset('nome_fantasia', 'razao_social', 'cnpj', 'bandeira_id');
    }

    // --- MÉTODOS DE EDIÇÃO ---

    public function abrirModalEdicao(Unidade $unidade)
    {
        $this->unidadeParaEditar = $unidade;
        $this->nome_fantasia_edicao = $unidade->nome_fantasia;
        $this->razao_social_edicao = $unidade->razao_social;
        $this->cnpj_edicao = $unidade->cnpj;
        $this->bandeira_id_edicao = $unidade->bandeira_id;
    }

    public function fecharModalEdicao()
    {
        $this->reset('unidadeParaEditar', 'nome_fantasia_edicao', 'razao_social_edicao', 'cnpj_edicao', 'bandeira_id_edicao');
    }

    public function update()
    {
        $this->validate([
            'nome_fantasia_edicao' => 'required|string|max:255',
            'razao_social_edicao' => 'required|string|max:255',
            'cnpj_edicao' => [
                'required', 'string', 'max:18',
                Rule::unique('unidades', 'cnpj')->ignore($this->unidadeParaEditar->id)
            ],
            'bandeira_id_edicao' => 'required|exists:bandeiras,id',
        ]);

        $this->unidadeParaEditar->update([
            'nome_fantasia' => $this->nome_fantasia_edicao,
            'razao_social' => $this->razao_social_edicao,
            'cnpj' => $this->cnpj_edicao,
            'bandeira_id' => $this->bandeira_id_edicao,
        ]);

        $this->fecharModalEdicao();
    }

    // --- MÉTODOS DE EXCLUSÃO ---

    public function abrirModalDelecao(Unidade $unidade)
    {
        $this->unidadeParaDeletar = $unidade;
    }

    public function fecharModalDelecao()
    {
        $this->reset('unidadeParaDeletar');
    }

    public function delete()
    {
        $this->unidadeParaDeletar->delete();
        $this->fecharModalDelecao();
    }

    // --- Método Render ---
    #[Layout('layouts.app')] 
    public function render(): View
    {
        $unidades = Unidade::with('bandeira')
            ->orderBy('nome_fantasia')
            ->paginate(10);

        $header = Blade::render(
            '<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __("Unidades") }}</h2>'
        );

        return view('livewire.unidade.index', [
            'unidades' => $unidades,
        ])->with('header', $header);
    }
}