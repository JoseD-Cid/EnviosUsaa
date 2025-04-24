<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Envio extends Model
{
    protected $fillable = [
        'cliente_dni',
        'destino_pais_id',
        'destino_estado_id',
        'ciudad_destino',
        'direccion_destino',
        'fecha_envio',
        'estatus_envio',
        'tracking_number',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_dni', 'Dni');
    }

    public function clienteDestino(): BelongsTo
    {
        return $this->belongsTo(ClientesDestino::class, 'cliente_destino_dni', 'Dni');
    }

    public function destino_pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'destino_pais_id', 'CodPais');
    }

    public function destino_estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'destino_estado_id', 'CodEstado');
    }

    public function paquetes(): BelongsToMany
    {
        return $this->belongsToMany(Paquete::class, 'envio_paquete', 'envio_id', 'paquete_id')
            ->withPivot('descripcion', 'precio')
            ->withTimestamps();
    }

    public function trackingHistory(): HasMany
    {
        return $this->hasMany(TrackingHistory::class, 'envio_id');
    }
}