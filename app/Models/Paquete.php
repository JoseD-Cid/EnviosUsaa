<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $primaryKey = 'PaqueteId';
    
    protected $fillable = [
        'NombrePaquete',
        'dimension',
        'precio',
    ];
    
    // Actualizamos a relación muchos a muchos
    public function envios()
    {
        return $this->belongsToMany(Envio::class, 'envio_paquete', 'paquete_id', 'envio_id')
                    ->withPivot('descripcion','precio')
                    ->withTimestamps();
    }
}
