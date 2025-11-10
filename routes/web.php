<?php
use App\Http\Controllers\RelatorioController;
use App\Livewire\Relatorio\Colaboradores as RelatorioColaboradores;
use App\Livewire\Colaborador\Index as ColaboradorIndex;
use App\Livewire\Bandeira\Index as BandeiraIndex;
use App\Livewire\Unidade\Index as UnidadeIndex;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\GrupoEconomico\Index as GrupoEconomicoIndex; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
 // <--- Adicione esta rota
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/relatorios', RelatorioColaboradores::class)->name('relatorios.index');
    Route::get('/colaboradores', ColaboradorIndex::class)->name('colaboradores.index');
    Route::get('/unidades', UnidadeIndex::class)->name('unidades.index');
    Route::get('/bandeiras', BandeiraIndex::class)->name('bandeiras.index');
    Route::get('/grupos-economicos', GrupoEconomicoIndex::class)->name('grupos-economicos.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/relatorios/exportar', [RelatorioController::class, 'exportarColaboradores'])->name('relatorios.exportar');
});

require __DIR__.'/auth.php';
