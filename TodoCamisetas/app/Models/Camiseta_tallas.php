<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camiseta_tallas extends Model
{
    use HasFactory;

    protected $fillable = [
        'camiseta_id',
        'talla_id',
        'stock'
    ];

    public function talla()
    {
        return $this->belongsTo(Tallas::class, 'talla_id');
    }

    public function camiseta()
    {
        return $this->belongsTo(Camisetas::class, 'camiseta_id');
    }

    public function ventaDetalles()
    {
        return $this->hasMany(Ventas_detalles::class, 'camiseta_talla_id');
    }

    // Backward-compatible aliases.
    public function tallas()
    {
        return $this->talla();
    }

    public function camisetas()
    {
        return $this->camiseta();
    }
}
