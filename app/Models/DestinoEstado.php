<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $primaryKey = 'CodEstado';
    public $incrementing = false;
    protected $fillable = ['CodEstado', 'NomEstado', 'pais_id'];

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'pais_id', 'CodPais');
    }

    public function envios()
    {
        return $this->hasMany(Envio::class, 'destino_estado_id', 'CodEstado');
    }
}