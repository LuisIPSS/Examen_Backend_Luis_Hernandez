<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'fecha',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'total' => 'integer',
        ];
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    public function detalles()
    {
        return $this->hasMany(Ventas_detalles::class, 'venta_id');
    }
}
