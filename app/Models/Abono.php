<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;

    protected $table = 'abonos';
    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'data',
        'minutos',
        'motivo',
        'tipo',
        'criado_em'
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}