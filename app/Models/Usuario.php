<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    public $timestamps = false;

    protected $fillable = [
        'nome', 'email', 'cpf', 'cargo', 'ativo'
    ];

    public function marcacoes()
    {
        return $this->hasMany(\App\Models\Marcacao::class, 'usuario_id');
    }

    public function marcacoesHoje()
    {
        return $this->hasMany(\App\Models\Marcacao::class, 'usuario_id')
                    ->whereDate('data_hora', Carbon::today());
    }

    public function abonos()
    {
        return $this->hasMany(\App\Models\Abono::class, 'usuario_id');
    }

    public function horarios()
    {
        return $this->hasMany(\App\Models\Horario::class, 'usuario_id');
    }

    public function ferias()
    {
        return $this->hasMany(\App\Models\Ferias::class, 'usuario_id');
    }
}