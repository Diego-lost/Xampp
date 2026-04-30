<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudCita extends Model
{
    protected $table = 'solicitudes_citas';

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'especialidad',
        'fecha',
        'hora',
        'motivo',
        'motivo_cancelacion',
        'estado',
        'origen',
    ];
}

