<?php

namespace App\Exports;

use App\Models\Colaborador;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue; // <-- 1. ESTA LINHA É ESSENCIAL

// 2. 'implements ShouldQueue' É ESSENCIAL
class RelatorioColaboradorExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue
{
    protected $grupoId;
    protected $bandeiraId;
    protected $unidadeId;

    // Recebe os filtros
    public function __construct($grupoId, $bandeiraId, $unidadeId)
    {
        $this->grupoId = $grupoId;
        $this->bandeiraId = $bandeiraId;
        $this->unidadeId = $unidadeId;
    }

    // Define os Títulos (Cabeçalho)
    public function headings(): array
    {
        return [
            'ID Colaborador',
            'Nome',
            'Email',
            'CPF',
            'Unidade',
            'Bandeira',
            'Grupo Econômico',
        ];
    }

    // Mapeia cada linha (para pegar os nomes dos relacionamentos)
    public function map($colaborador): array
    {
        return [
            $colaborador->id,
            $colaborador->nome,
            $colaborador->email,
            $colaborador->cpf,
            $colaborador->unidade->nome_fantasia ?? 'N/A',
            $colaborador->unidade->bandeira->nome ?? 'N/A',
            $colaborador->unidade->bandeira->grupoEconomico->nome ?? 'N/A',
        ];
    }

    // Busca os dados no banco (a mesma query da página de relatório)
    public function query()
    {
        $query = Colaborador::with('unidade.bandeira.grupoEconomico');

        $query->when($this->unidadeId, function ($q) {
            return $q->where('unidade_id', $this->unidadeId);
        });

        $query->when(!$this->unidadeId && $this->bandeiraId, function ($q) {
            return $q->whereHas('unidade', function ($subQ) {
                $subQ->where('bandeira_id', $this->bandeiraId);
            });
        });

        $query->when(!$this->unidadeId && !$this->bandeiraId && $this->grupoId, function ($q) {
            return $q->whereHas('unidade.bandeira', function ($subQ) {
                $subQ->where('grupo_economico_id', $this->grupoId);
            });
        });

        return $query->orderBy('nome');
    }
}