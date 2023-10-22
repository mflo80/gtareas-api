<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Historial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'historial';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_tarea',
        'fecha_hora_modificacion'
    ];

    protected $dates = [
        'fecha_hora_modificacion'
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
