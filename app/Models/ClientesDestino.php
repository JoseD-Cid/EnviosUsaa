<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientesDestino extends Model
{
    protected $table = 'clientes_destino';

    protected $primaryKey = 'Dni';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Dni',
        'Nombres',
        'Apellidos',
        'Telefono',
        'Email',
        'CodPais',
        'CodEstado',
        'Ciudad',
        'Direccion',
        'Estatus',
        'IsDelete',
    ];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'CodPais', 'CodPais');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'CodEstado', 'CodEstado');
    }
}
