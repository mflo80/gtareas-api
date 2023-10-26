<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsuarioAsignaTarea extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'usuario_asigna_tarea';

    protected $primaryKey = 'id_usuario_asignado';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario_creador',
        'id_usuario_asignado',
        'id_tarea',
        'fecha_hora_asignacion',
        'fecha_hora_expiracion',
        'permiso'
    ];

    protected $dates = [
        'fecha_hora_asignacion',
        'fecha_hora_expiracion'
    ];

    public function usuarioCreador()
    {
        return $this->belongsTo(User::class, 'id_usuario_creador');
    }

    public function usuarioAsignado()
    {
        return $this->belongsTo(User::class, 'id_usuario_asignado');
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'id_tarea');
    }
}
