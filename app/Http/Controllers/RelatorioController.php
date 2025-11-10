<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RelatorioColaboradorExport; // <-- Ele só importa a classe
use Maatwebsite\Excel\Facades\Excel;

class RelatorioController extends Controller
{
    /**
     * Dispara a exportação do relatório de colaboradores para a fila.
     */
    public function exportarColaboradores(Request $request)
    {
        $grupoId = $request->get('grupo_id');
        $bandeiraId = $request->get('bandeira_id');
        $unidadeId = $request->get('unidade_id');
        $user = $request->user();

        $fileName = 'relatorios/relatorio_' . $user->id . '_' . now()->format('Y-m-d_His') . '.xlsx';

        (new RelatorioColaboradorExport($grupoId, $bandeiraId, $unidadeId))
            ->queue($fileName, 'public');

        return back()->with('status', 'Seu relatório está sendo gerado! Ele estará disponível em breve.');

    }
}