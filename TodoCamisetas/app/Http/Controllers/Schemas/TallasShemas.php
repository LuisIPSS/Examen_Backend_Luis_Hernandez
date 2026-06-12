<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="Tallas",
 *     title="Tallas",
 *     description="Catálogo de tallas"
 * )
 */
class TallasShemas
{
    /** @OA\Property(property="id", type="integer", example=1) */
    public int $id;
    /** @OA\Property(property="talla", type="string", example="XL") */
    public string $talla;
    /** @OA\Property(property="created_at", type="string", format="date-time") */
    public string $created_at;
    /** @OA\Property(property="updated_at", type="string", format="date-time") */
    public string $updated_at;
}

/**
 * @OA\Schema(
 *     schema="TallasInput",
 *     title="Tallas Input",
 *     required={"talla"}
 * )
 */
class TallasInput
{
    /** @OA\Property(property="talla", type="string", example="XL") */
    public string $talla;
}
