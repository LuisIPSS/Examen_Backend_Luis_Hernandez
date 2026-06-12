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
        'precio_oferta',
        'detalles',
        'sku',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'integer',
            'precio_oferta' => 'integer',
        ];
    }

    public function camisetaTallas()
    {
        return $this->hasMany(Camiseta_tallas::class, 'camiseta_id');
    }

    public function tallas()
    {
        return $this->belongsToMany(Tallas::class, 'camiseta_tallas', 'camiseta_id', 'talla_id')
            ->withPivot('stock')
            ->withTimestamps();
    }
}
