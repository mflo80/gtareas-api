<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsuarioComentaTarea extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;

    protected $table = 'usuario_comenta_tarea';

    protected $fillable = [
        'id_usuario',
        'id_tarea',
        'comentario',
        'fecha_hora_creacion'
    ];

    protected $dates = [
        'fecha_hora_creacion'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'id_tarea');
    }
}
