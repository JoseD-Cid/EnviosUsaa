<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingHistory extends Model
{
    protected $table = 'tracking_history';
    protected $fillable = ['envio_id', 'estado', 'ubicacion', 'descripcion'];


    public function envio()
    {
        return $this->belongsTo(Envio::class);
    }
}
