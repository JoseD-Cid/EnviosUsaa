<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $fillable = [
        'envio_id',
        'descripcion',
        'peso',
        'valor_declarado',
    ];

    public function envio()
    {
        return $this->belongsTo(Envio::class);
    }
}
