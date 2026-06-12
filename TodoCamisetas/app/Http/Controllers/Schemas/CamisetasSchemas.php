<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="Camisetas",
 *     title="Camisetas",
 *     description="Modelo completo de camisetas"
 * )
 */
class CamisetasSchemas
{
    /** @OA\Property(property="id", type="integer", example=1) */
    public int $id;
    /** @OA\Property(property="titulo", type="string", example="Camiseta de la selección de Chile") */
    public string $titulo;
    /** @OA\Property(property="club", type="string", example="Club de la selección de Chile") */
    public string $club;
    /** @OA\Property(property="pais", type="string", example="Chile") */
    public string $pais;
    /** @OA\Property(property="tipo", type="string", example="Selección") */
    public string $tipo;
    /** @OA\Property(property="color", type="string", example="Rojo") */
    public string $color;
    /** @OA\Property(property="precio", type="integer", example=10000) */
    public int $precio;
    /** @OA\Property(property="precio_oferta", type="integer", nullable=true, example=8000) */
    public ?int $precio_oferta;
    /** @OA\Property(property="detalles", type="string", nullable=true, example="Camiseta oficial") */
    public ?string $detalles;
    /** @OA\Property(property="sku", type="string", example="1234567890") */
    public string $sku;
    /** @OA\Property(property="created_at", type="string", format="date-time") */
    public string $created_at;
    /** @OA\Property(property="updated_at", type="string", format="date-time") */
    public string $updated_at;
}

/**
 * @OA\Schema(
 *     schema="CamisetasInput",
 *     title="Camisetas Input",
 *     required={"titulo", "club", "pais", "tipo", "color", "precio", "sku"}
 * )
 */
class CamisetasInput
{
    /** @OA\Property(property="titulo", type="string", example="Camiseta de la selección de Chile") */
    public string $titulo;
    /** @OA\Property(property="club", type="string", example="Club de la selección de Chile") */
    public string $club;
    /** @OA\Property(property="pais", type="string", example="Chile") */
    public string $pais;
    /** @OA\Property(property="tipo", type="string", example="Selección") */
    public string $tipo;
    /** @OA\Property(property="color", type="string", example="Rojo") */
    public string $color;
    /** @OA\Property(property="precio", type="integer", example=10000) */
    public int $precio;
    /** @OA\Property(property="precio_oferta", type="integer", nullable=true, example=8000) */
    public ?int $precio_oferta;
    /** @OA\Property(property="detalles", type="string", nullable=true, example="Camiseta oficial") */
    public ?string $detalles;
    /** @OA\Property(property="sku", type="string", example="1234567890") */
    public string $sku;
}
