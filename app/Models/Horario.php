<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    // Nome da tabela
    protected $table = 'horarios';

    // Habilita os timestamps (já que criamos no SQL)
    public $timestamps = true;

    // Atributos que podem ser preenchidos em massa
    protected $fillable = [
        'usuario_id',
        'carga_horas',
        'hora_entrada_prevista',
        'hora_saida_prevista',
        'intervalo_minimo_minutos',
        'vigente_desde',
    ];

    // Casts para tipos corretos
    protected $casts = [
        'vigente_desde' => 'date',
        'hora_entrada_prevista' => 'datetime:H:i',
        'hora_saida_prevista'   => 'datetime:H:i',
    ];

    // Relacionamento
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
