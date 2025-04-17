<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    protected $primaryKey = 'CodMunicipio';
    public $timestamps = false;

    protected $fillable = ['NomMunicipio', 'Estatus', 'IsDelete', 'CodEstado'];

    protected $table = 'municipios';

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'CodEstado');
    }

    public function clientes(): HasMany
    {
        return $this->hasMany(Cliente::class, 'CodMunicipio');
    }
}
