<?php

namespace App\Livewire\Colaborador;

// Imports
use App\Models\Colaborador;
use App\Models\Unidade; // NECESSÁRIO para o dropdown
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Collection; // NECESSÁRIO para o dropdown

class Index extends Component
{
    use WithPagination;

    // --- Propriedades do Formulário de Criação ---
    public $nome = '';
    public $email = '';
    public $cpf = '';
    public $unidade_id = ''; // Para o dropdown
    public Collection $unidades; // Guarda a lista de unidades

    // --- Propriedades do Modal de Edição ---
    public ?Colaborador $colaboradorParaEditar = null;
    public $nome_edicao = '';
    public $email_edicao = '';
    public $cpf_edicao = '';
    public $unidade_id_edicao = '';

    // --- Propriedades do Modal de Exclusão ---
    public ?Colaborador $colaboradorParaDeletar = null;
    
    // 'mount' é executado uma vez quando o componente carrega
    public function mount()
    {
        // Carrega todas as unidades para usar no dropdown
        $this->unidades = Unidade::orderBy('nome_fantasia')->get();
    }

    // --- Regras de Validação ---
    protected function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:colaboradores,email',
            'cpf' => 'required|string|max:14|unique:colaboradores,cpf', // Adicionar validação de formato CPF depois
            'unidade_id' => 'required|exists:unidades,id',
        ];
    }

    // --- Método de Criação ---
    public function save()
    {
        $this->validate(); 
        Colaborador::create([
            'nome' => $this->nome,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'unidade_id' => $this->unidade_id,
        ]);
        $this->reset('nome', 'email', 'cpf', 'unidade_id');
    }

    // --- MÉTODOS DE EDIÇÃO ---

    public function abrirModalEdicao(Colaborador $colaborador)
    {
        $this->colaboradorParaEditar = $colaborador;
        $this->nome_edicao = $colaborador->nome;
        $this->email_edicao = $colaborador->email;
        $this->cpf_edicao = $colaborador->cpf;
        $this->unidade_id_edicao = $colaborador->unidade_id;
    }

    public function fecharModalEdicao()
    {
        $this->reset('colaboradorParaEditar', 'nome_edicao', 'email_edicao', 'cpf_edicao', 'unidade_id_edicao');
    }

    public function update()
    {
        $colaboradorId = $this->colaboradorParaEditar->id;
        
        $this->validate([
            'nome_edicao' => 'required|string|max:255',
            'email_edicao' => [
                'required', 'email', 'max:255',
                Rule::unique('colaboradores', 'email')->ignore($colaboradorId)
            ],
            'cpf_edicao' => [
                'required', 'string', 'max:14',
                Rule::unique('colaboradores', 'cpf')->ignore($colaboradorId)
            ],
            'unidade_id_edicao' => 'required|exists:unidades,id',
        ]);

        $this->colaboradorParaEditar->update([
            'nome' => $this->nome_edicao,
            'email' => $this->email_edicao,
            'cpf' => $this->cpf_edicao,
            'unidade_id' => $this->unidade_id_edicao,
        ]);

        $this->fecharModalEdicao();
    }

    // --- MÉTODOS DE EXCLUSÃO ---

    public function abrirModalDelecao(Colaborador $colaborador)
    {
        $this->colaboradorParaDeletar = $colaborador;
    }

    public function fecharModalDelecao()
    {
        $this->reset('colaboradorParaDeletar');
    }

    public function delete()
    {
        $this->colaboradorParaDeletar->delete();
        $this->fecharModalDelecao();
    }

    // --- Método Render ---
    #[Layout('layouts.app')] 
    public function render(): View
    {
        $colaboradores = Colaborador::with('unidade')
            ->orderBy('nome')
            ->paginate(10);

        $header = Blade::render(
            '<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __("Colaboradores") }}</h2>'
        );

        return view('livewire.colaborador.index', [
            'colaboradores' => $colaboradores,
        ])->with('header', $header);
    }
}