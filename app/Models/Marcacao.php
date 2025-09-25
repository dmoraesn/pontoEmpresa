<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Marcacao extends Model
{
    use HasFactory;

    public $timestamps = false; // ✅ não cria/atualiza created_at e updated_at

    protected $table = 'marcacoes';

    protected $fillable = [
        'usuario_id',
        'data_hora',
        'tipo',
        'origem',
    ];

    protected $casts = [
        'data_hora' => 'datetime',
    ];

    /**
     * Relacionamento com o usuário.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Formata a data/hora no padrão brasileiro.
     */
    public function getDataHoraFormatadaAttribute()
    {
        return $this->data_hora
            ? Carbon::parse($this->data_hora)->format('d/m/Y H:i')
            : null;
    }
}
