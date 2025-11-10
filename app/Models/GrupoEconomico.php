<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; // 1. ADICIONE ESTE 'use'

class GrupoEconomico extends Model implements Auditable // 2. ADICIONE 'implements Auditable'
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable; // 3. ADICIONE ESTE 'use'

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nome'];

    /**
     * Define o relacionamento: Um Grupo Econômico tem muitas Bandeiras.
     */
    public function bandeiras()
    {
        return $this->hasMany(Bandeira::class);
    }
}