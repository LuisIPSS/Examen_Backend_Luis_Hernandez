<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="Ventas",
 *     title="Ventas",
 *     description="Modelo completo de ventas"
 * )
 */
class VentasShemas
{
    /** @OA\Property(property="id", type="integer", example=1) */
    public int $id;
    /** @OA\Property(property="cliente_id", type="integer", example=1) */
    public int $cliente_id;
    /** @OA\Property(property="fecha", type="string", format="date", example="2026-01-01") */
    public string $fecha;
    /** @OA\Property(property="total", type="integer", example=10000) */
    public int $total;
    /** @OA\Property(property="created_at", type="string", format="date-time") */
    public string $created_at;
    /** @OA\Property(property="updated_at", type="string", format="date-time") */
    public string $updated_at;
}

/**
 * @OA\Schema(
 *     schema="VentasInput",
 *     title="Ventas Input",
 *     required={"cliente_id", "fecha", "total"}
 * )
 */
class VentasInput
{
    /** @OA\Property(property="cliente_id", type="integer", example=1) */
    public int $cliente_id;
    /** @OA\Property(property="fecha", type="string", format="date", example="2026-01-01") */
    public string $fecha;
    /** @OA\Property(property="total", type="integer", example=10000) */
    public int $total;
}
