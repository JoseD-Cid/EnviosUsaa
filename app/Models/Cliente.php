<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;


class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'Dni';

    // Si el Dni no es un entero autoincrementable, debes indicar que no es incremental
    public $incrementing = false;

    // Si el tipo de dato de la clave primaria no es un entero, debes especificarlo
    protected $keyType = 'string';

    protected $fillable = [
        'Dni',
        'Nombres',
        'Apellidos',
        'PrimerTelefono',
        'SegundoTelefono',
        'Estatus',
        'IsDelete',
        'CodMunicipio',
        'Direccion',
        'IsDelete'
    ];

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'CodMunicipio');
    }

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('IsDelete', 0);
        });
    }
}