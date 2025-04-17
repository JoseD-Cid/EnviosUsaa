<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pais extends Model
{
    use HasFactory;

    protected $primaryKey = 'CodPais';
    public $timestamps = false; // Si no usas created_at y updated_at

    protected $fillable = ['Nombre', 'Estatus', 'IsDelete'];
    protected $table = 'paises';

    public function estados(): HasMany
    {
        return $this->hasMany(Estado::class, 'CodPais');
    }
}
