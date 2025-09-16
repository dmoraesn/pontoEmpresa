<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marcacao extends Model
{
    use HasFactory;

    /**
     * Indica se o modelo deve ser timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * O nome da tabela associada com o model.
     *
     * @var string
     */
    protected $table = 'marcacoes';

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario_id',
        'data_hora',
        'tipo',
        'origem',
    ];

    /**
     * Define o tipo do atributo data_hora como um objeto Carbon.
     *
     * @var array
     */
    protected $casts = [
        'data_hora' => 'datetime',
    ];

    /**
     * Define o relacionamento com o usuário.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }




    
}