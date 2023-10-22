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
        'Nombre',
        'FechaHora_Creacion',
        'FechaHora_Expiracion',
        'Estado'];

    protected $dates = [
        'FechaHora_Creacion',
        'FechaHora_Expiracion'
    ];
}
