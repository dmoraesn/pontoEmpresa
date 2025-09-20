<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Afastamento extends Model
{
    use HasFactory;

    protected $table = 'afastamentos';

    /**
     * Campos permitidos para atribuição em massa.
     */
    protected $fillable = [
        'usuario_id',
        'tipo',
        'data_inicio',
        'data_fim',
        'observacao',
    ];

    /**
     * Relacionamento: um afastamento pertence a um usuário.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
