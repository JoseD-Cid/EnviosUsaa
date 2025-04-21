<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Envio;

class Paquete extends Model
{
public function envio()
{
    return $this->belongsTo(Envio::class);
}
}