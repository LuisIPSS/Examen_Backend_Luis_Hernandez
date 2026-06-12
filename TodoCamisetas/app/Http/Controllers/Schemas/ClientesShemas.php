<?php

namespace App\Http\Controllers\Schemas;

/**
 * @OA\Schema(
 *     schema="Clientes",
 *     title="Clientes",
 *     description="Modelo completo de clientes"
 * )
 */
class ClientesShemas
{
    /** @OA\Property(property="id", type="integer", example=1) */
    public int $id;
    /** @OA\Property(property="nombre_comercial", type="string", example="Deportes Sur") */
    public string $nombre_comercial;
    /** @OA\Property(property="rut", type="string", example="76123456-7") */
    public string $rut;
    /** @OA\Property(property="direccion", type="string", example="Av. Providencia 1234") */
    public string $direccion;
    /** @OA\Property(property="categoria", type="string", example="preferencial") */
    public string $categoria;
    /** @OA\Property(property="contacto", type="string", example="+56912345678") */
    public string $contacto;
    /** @OA\Property(property="procentaje_oferta", type="integer", example=10) */
    public int $procentaje_oferta;
    /** @OA\Property(property="created_at", type="string", format="date-time") */
    public string $created_at;
    /** @OA\Property(property="updated_at", type="string", format="date-time") */
    public string $updated_at;
}

/**
 * @OA\Schema(
 *     schema="ClientesInput",
 *     title="Clientes Input",
 *     required={"nombre_comercial", "rut", "direccion", "categoria", "contacto", "procentaje_oferta"}
 * )
 */
class ClientesInput
{
    /** @OA\Property(property="nombre_comercial", type="string", example="Deportes Sur") */
    public string $nombre_comercial;
    /** @OA\Property(property="rut", type="string", example="76123456-7") */
    public string $rut;
    /** @OA\Property(property="direccion", type="string", example="Av. Providencia 1234") */
    public string $direccion;
    /** @OA\Property(property="categoria", type="string", example="preferencial") */
    public string $categoria;
    /** @OA\Property(property="contacto", type="string", example="+56912345678") */
    public string $contacto;
    /** @OA\Property(property="procentaje_oferta", type="integer", example=10) */
    public int $procentaje_oferta;
}
