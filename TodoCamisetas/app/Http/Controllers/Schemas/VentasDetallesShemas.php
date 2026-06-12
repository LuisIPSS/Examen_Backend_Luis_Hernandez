<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="VentasDetalles",
 *     title="Ventas Detalles",
 *     description="Modelo completo de detalle de venta"
 * )
 */
class VentasDetallesShemas
{
    /** @OA\Property(property="id", type="integer", example=1) */
    public int $id;
    /** @OA\Property(property="venta_id", type="integer", example=1) */
    public int $venta_id;
    /** @OA\Property(property="camiseta_talla_id", type="integer", example=1) */
    public int $camiseta_talla_id;
    /** @OA\Property(property="cantidad", type="integer", example=1) */
    public int $cantidad;
    /** @OA\Property(property="precio_unitario", type="integer", example=10000) */
    public int $precio_unitario;
    /** @OA\Property(property="precio_total", type="integer", example=10000) */
    public int $precio_total;
    /** @OA\Property(property="created_at", type="string", format="date-time") */
    public string $created_at;
    /** @OA\Property(property="updated_at", type="string", format="date-time") */
    public string $updated_at;
}

/**
 * @OA\Schema(
 *     schema="VentasDetallesInput",
 *     title="Ventas Detalles Input",
 *     required={"venta_id", "camiseta_talla_id", "cantidad", "precio_unitario", "precio_total"}
 * )
 */
class VentasDetallesInput
{
    /** @OA\Property(property="venta_id", type="integer", example=1) */
    public int $venta_id;
    /** @OA\Property(property="camiseta_talla_id", type="integer", example=1) */
    public int $camiseta_talla_id;
    /** @OA\Property(property="cantidad", type="integer", minimum=1, example=1) */
    public int $cantidad;
    /** @OA\Property(property="precio_unitario", type="integer", example=10000) */
    public int $precio_unitario;
    /** @OA\Property(property="precio_total", type="integer", example=10000) */
    public int $precio_total;
}
