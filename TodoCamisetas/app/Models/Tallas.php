<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Tallas extends Model
{
    use HasFactory;

    protected $fillable = [
        'talla',
    ];

    public function camisetaTallas()
    {
        return $this->hasMany(Camiseta_tallas::class, 'talla_id');
    }

    public function camisetas()
    {
        return $this->belongsToMany(Camisetas::class, 'camiseta_tallas', 'talla_id', 'camiseta_id')
            ->withPivot('stock')
            ->withTimestamps();
    }

}

