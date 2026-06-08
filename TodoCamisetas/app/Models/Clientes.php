<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_comercial',
        'rut',
        'direccion',
        'categoria',
        'contacto',
        'procentaje_oferta',
    ];

    protected function casts(): array
    {
        return [
            'procentaje_oferta' => 'integer',
        ];
    }
}
