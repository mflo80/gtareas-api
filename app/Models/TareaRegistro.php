<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TareaRegistro extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tareas_registro';

    public $timestamps = false;

    protected $fillable = [
        'evento',
        'id_tarea',
        'old_titulo',
        'old_texto',
        'old_fecha_hora_creacion',
        'old_fecha_hora_inicio',
        'old_fecha_hora_fin',
        'old_categoria',
        'old_estado',
        'old_id_usuario',
        'new_titulo',
        'new_texto',
        'new_fecha_hora_creacion',
        'new_fecha_hora_inicio',
        'new_fecha_hora_fin',
        'new_categoria',
        'new_estado',
        'new_id_usuario',
        'fecha_hora_modificacion',
        'id_usuario_modificacion'
    ];

    protected $dates = [
        'fecha_hora_modificacion'
    ];
}
