<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ferias extends Model
{
    protected $table = 'ferias';

    protected $fillable = ['usuario_id', 'data_inicio', 'data_fim', 'observacao'];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}