<?php

namespace App\Livewire\Bandeira; // <-- O namespace correto

// Imports
use App\Models\Bandeira;
use App\Models\GrupoEconomico;
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

    public $nome = '';
    public $grupo_economico_id = '';
    public Collection $grupos; 
    public ?Bandeira $bandeiraParaEditar = null;
    public $nomeEdicao = '';
    public $grupoEdicao_id = '';
    public ?Bandeira $bandeiraParaDeletar = null;

    public function mount()
    {
        $this->grupos = GrupoEconomico::orderBy('nome')->get();
    }

    protected function rules()
    {
        return [
            'nome' => 'required|string|min:3|max:255',
            'grupo_economico_id' => 'required|exists:grupo_economicos,id',
        ];
    }

    public function save()
    {
        $this->validate();
        Bandeira::create([
            'nome' => $this->nome,
            'grupo_economico_id' => $this->grupo_economico_id,
        ]);
        $this->reset('nome', 'grupo_economico_id');
    }

    public function abrirModalEdicao(Bandeira $bandeira)
    {
        $this->bandeiraParaEditar = $bandeira;
        $this->nomeEdicao = $bandeira->nome;
        $this->grupoEdicao_id = $bandeira->grupo_economico_id;
    }

    public function fecharModalEdicao()
    {
        $this->reset('bandeiraParaEditar', 'nomeEdicao', 'grupoEdicao_id');
    }

    public function update()
    {
        $this->validate([
            'nomeEdicao' => 'required|string|min:3|max:255',
            'grupoEdicao_id' => 'required|exists:grupo_economicos,id',
        ]);

        $this->bandeiraParaEditar->update([
            'nome' => $this->nomeEdicao,
            'grupo_economico_id' => $this->grupoEdicao_id,
        ]);

        $this->fecharModalEdicao();
    }

    public function abrirModalDelecao(Bandeira $bandeira)
    {
        $this->bandeiraParaDeletar = $bandeira;
    }

    public function fecharModalDelecao()
    {
        $this->reset('bandeiraParaDeletar');
    }

    public function delete()
    {
        $this->bandeiraParaDeletar->delete();
        $this->fecharModalDelecao();
    }

    #[Layout('layouts.app')] 
    public function render(): View
    {
        $bandeiras = Bandeira::with('grupoEconomico')
            ->orderBy('nome')
            ->paginate(10);

        $header = Blade::render(
            '<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __("Bandeiras") }}</h2>'
        );

        return view('livewire.bandeira.index', [
            'bandeiras' => $bandeiras,
        ])->with('header', $header);
    }
}