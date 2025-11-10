<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; // 1. ADICIONE ESTE 'use'

class Colaborador extends Model implements Auditable // 2. ADICIONE 'implements Auditable'
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
        'email',
        'cpf',
        'unidade_id'
    ];

    // Define o nome correto da tabela (para evitar o erro de 'colaboradors')
    protected $table = 'colaboradores';

    /**
     * Define o relacionamento: Este Colaborador pertence a uma Unidade.
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }
}
