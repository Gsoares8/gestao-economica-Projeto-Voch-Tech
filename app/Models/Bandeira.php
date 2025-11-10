<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; // 1. ADICIONE ESTE 'use'

class Bandeira extends Model implements Auditable // 2. ADICIONE 'implements Auditable'
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; // 3. ADICIONE ESTE 'use'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'grupo_economico_id'
    ];

    /**
     * Define o relacionamento: Esta Bandeira pertence a um Grupo Econômico.
     */
    public function grupoEconomico()
    {
        return $this->belongsTo(GrupoEconomico::class);
    }

    /**
     * Define o relacionamento: Esta Bandeira pode ter muitas Unidades.
     */
    public function unidades()
    {
        return $this->hasMany(Unidade::class);
    }
}