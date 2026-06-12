<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas_detalles extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'camiseta_talla_id',
        'cantidad',
        'precio_unitario',
        'precio_total',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'precio_unitario' => 'integer',
            'precio_total' => 'integer',
        ];
    }

    public function venta()
    {
        return $this->belongsTo(Ventas::class, 'venta_id');
    }

    public function camisetaTalla()
    {
        return $this->belongsTo(Camiseta_tallas::class, 'camiseta_talla_id');
    }
}
