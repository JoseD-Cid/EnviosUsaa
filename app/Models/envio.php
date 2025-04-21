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

    public function paquetes()
    {
        return $this->hasMany(Paquete::class);
    }

    public function cliente()
{
    return $this->belongsTo(Cliente::class, 'cliente_dni', 'Dni');
}

public function destino_pais()
{
    return $this->belongsTo(Pais::class, 'destino_pais_id', 'CodPais');
}
public function destino_estado()
{
    return $this->belongsTo(Estado::class, 'destino_estado_id', 'CodEstado');
}


}

