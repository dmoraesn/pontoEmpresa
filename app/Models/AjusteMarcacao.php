<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AjusteMarcacao extends Model
{
    protected $table = 'ajustes_marcacao';
    public $timestamps = false;

    protected $fillable = [
        'marcacao_id',
        'usuario_id',
        'data_hora_anterior',
        'data_hora_novo',
        'motivo',
        'feito_por'
    ];

    /**
     * Get the marcacao that owns the AjusteMarcacao.
     */
    public function marcacao(): BelongsTo
    {
        return $this->belongsTo(Marcacao::class);
    }

    /**
     * Get the usuario that owns the AjusteMarcacao.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
}