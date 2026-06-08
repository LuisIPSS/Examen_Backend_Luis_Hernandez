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

    public function camisetas()
    {
        return $this->belongsTo(Camisetas::class, 'camiseta_id');
    }


}
