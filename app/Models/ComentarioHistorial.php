<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComentarioHistorial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comentarios_historial';

    public $timestamps = false;

    protected $fillable = [
        'evento',
        'id_comentario',
        'old_id_usuario',
        'old_id_tarea',
        'old_comentario',
        'old_fecha_hora_creacion',
        'old_fecha_hora_modificacion',
        'new_id_usuario',
        'new_id_tarea',
        'new_comentario',
        'new_fecha_hora_creacion',
        'new_fecha_hora_modificacion',
        'fecha_hora_modificacion'
    ];

    protected $dates = [
        'fecha_hora_modificacion'
    ];
}
