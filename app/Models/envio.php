<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $fillable = [
        'cliente_dni',
        'fecha_envio',
        'tracking_number',
        'destino_pais_id',
        'destino_estado_id',
        'ciudad_destino',
        'direccion_destino',
        'estatus_envio',
    ];

    // Relación con paquetes
    public function paquetes()
    {
        return $this->hasMany(Paquete::class);
    }

    // Relación con país (CORREGIDO)
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'destino_pais_id', 'CodPais');
    }

    // Relación con estado (CORREGIDO)
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'destino_estado_id', 'CodEstado');
    }

    // Relación con cliente (AGREGAR)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_dni', 'dni');
    }
}