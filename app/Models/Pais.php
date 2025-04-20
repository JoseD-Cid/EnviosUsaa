<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';
    protected $primaryKey = 'CodPais';
    public $timestamps = false;

    protected $fillable = ['CodPais', 'Nombre', 'Estatus', 'IsDelete'];

    public function estados()
    {
        return $this->hasMany(Estado::class, 'CodPais', 'CodPais');
    }
}

