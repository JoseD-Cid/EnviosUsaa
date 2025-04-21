<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $primaryKey = 'CodPais';
    public $incrementing = false;
    protected $fillable = ['CodPais', 'Nombre'];

    public function estados()
    {
        return $this->hasMany(Estado::class, 'pais_id', 'CodPais');
    }

    public function envios()
    {
        return $this->hasMany(Envio::class, 'destino_pais_id', 'CodPais');
    }
}