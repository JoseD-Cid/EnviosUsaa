<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'Dni';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Dni', 'Nombres', 'Apellidos', 'PrimerTelefono', 'SegundoTelefono',
        'PaisID', 'EstadoID', 'Municipio', 'Direccion', 'IsDelete'
    ];

    // Relación con el Estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'EstadoID', 'CodEstado');
    }

    // Relación con el País (a través del estado)
    public function pais()
    {
        return $this->estado ? $this->estado->pais() : null;
    }
}
