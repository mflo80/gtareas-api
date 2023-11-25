<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tareas';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'texto',
        'fecha_hora_creacion',
        'fecha_hora_inicio',
        'fecha_hora_fin',
        'categoria',
        'estado'
    ];

    protected $dates = [
        'fecha_hora_creacion',
        'fecha_hora_inicio',
        'fecha_hora_fin'
    ];
}
