<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="CamisetaTalla",
 *     title="Camiseta Talla",
 *     description="Relación camiseta-talla con stock"
 * )
 */
class CamisetaTallaSchemas
{
    /** @OA\Property(property="id", type="integer", example=1) */
    public int $id;
    /** @OA\Property(property="camiseta_id", type="integer", example=1) */
    public int $camiseta_id;
    /** @OA\Property(property="talla_id", type="integer", example=1) */
    public int $talla_id;
    /** @OA\Property(property="stock", type="integer", example=10) */
    public int $stock;
    /** @OA\Property(property="created_at", type="string", format="date-time") */
    public string $created_at;
    /** @OA\Property(property="updated_at", type="string", format="date-time") */
    public string $updated_at;
}

/**
 * @OA\Schema(
 *     schema="CamisetaTallaInput",
 *     title="Camiseta Talla Input",
 *     required={"camiseta_id", "talla_id", "stock"}
 * )
 */
class CamisetaTallaInput
{
    /** @OA\Property(property="camiseta_id", type="integer", example=1) */
    public int $camiseta_id;
    /** @OA\Property(property="talla_id", type="integer", example=1) */
    public int $talla_id;
    /** @OA\Property(property="stock", type="integer", example=10) */
    public int $stock;
}
