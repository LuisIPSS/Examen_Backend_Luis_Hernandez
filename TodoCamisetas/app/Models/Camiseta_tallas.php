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

    public function tallas()
    {
        return $this->belongsTo(Tallas::class, 'talla_id');
    }

    public function camisetas()
    {
        return $this->belongsTo(Camisetas::class, 'camiseta_id');
    }

}
