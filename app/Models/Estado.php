<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estado extends Model
{
    use HasFactory;

    protected $primaryKey = 'CodEstado';
    public $timestamps = false;

    protected $fillable = ['NomEstado', 'Estatus', 'IsDelete', 'CodPais'];

    protected $table = 'estados';

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'CodPais');
    }

    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class, 'CodEstado');
    }
}

