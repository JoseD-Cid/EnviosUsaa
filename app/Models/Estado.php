<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    protected $primaryKey = 'CodEstado';
    public $timestamps = false;

    protected $fillable = ['CodEstado', 'NomEstado', 'CodPais', 'Estatus', 'IsDelete'];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'CodPais', 'CodPais');
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'EstadoID', 'CodEstado');
    }
     // Relación con los envíos
     public function envios()
     {
         return $this->hasMany(Envio::class, 'destino_estado_id', 'CodEstado');
     }
}


