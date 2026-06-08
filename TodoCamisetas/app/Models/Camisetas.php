<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camisetas extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'club',
        'pais',
        'tipo',
        'color',
        'precio',
        'detalles',
        'sku',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'integer',
        ];
    }
}
