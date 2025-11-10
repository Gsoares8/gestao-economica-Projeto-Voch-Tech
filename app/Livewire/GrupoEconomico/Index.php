<?php

namespace App\Livewire\GrupoEconomico;

// Imports
use App\Models\GrupoEconomico;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    public $nome = ''; 
    public ?GrupoEconomico $grupoParaEditar = null;
    public $nomeEdicao = '';
    public ?GrupoEconomico $grupoParaDeletar = null;

    protected function rules()
    {
        return [
            'nome' => 'required|string|min:3|max:255|unique:grupo_economicos,nome',
        ];
    }

    public function save()
    {
        $this->validate();
        GrupoEconomico::create(['nome' => $this->nome]);
        $this->reset('nome'); 
    }

    public function abrirModalEdicao(GrupoEconomico $grupo)
    {
        $this->grupoParaEditar = $grupo;
        $this->nomeEdicao = $grupo->nome;
    }

    public function fecharModalEdicao()
    {
        $this->reset('grupoParaEditar', 'nomeEdicao');
    }

    public function update()
    {
        $this->validate([
            'nomeEdicao' => [
                'required', 'string', 'min:3', 'max:255',
                Rule::unique('grupo_economicos', 'nome')->ignore($this->grupoParaEditar->id)
            ]
        ]);

        $this->grupoParaEditar->update([
            'nome' => $this->nomeEdicao,
        ]);

        $this->fecharModalEdicao();
    }

    public function abrirModalDelecao(GrupoEconomico $grupo)
    {
        $this->grupoParaDeletar = $grupo;
    }

    public function fecharModalDelecao()
    {
        $this->reset('grupoParaDeletar');
    }

    public function delete()
    {
        $this->grupoParaDeletar->delete();
        $this->fecharModalDelecao();
    }

    #[Layout('layouts.app')] 
    public function render(): View
    {
        $grupos = GrupoEconomico::orderBy('nome')->paginate(10);

        $header = Blade::render(
            '<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __("Grupos Econômicos") }}</h2>'
        );

        return view('livewire.grupo-economico.index', [
            'grupos' => $grupos,
        ])->with('header', $header); 
    }
}