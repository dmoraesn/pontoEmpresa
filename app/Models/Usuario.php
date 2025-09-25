<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'cargo',
        'ativo',
        'tipo_usuario', // 👈 precisa estar aqui
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
