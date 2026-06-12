<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="TodoCamisetas API",
 *     description="API REST para la plataforma de camisetas TodoCamisetas. Permite gestionar camisetas, clientes, tallas y ventas."
 * )
 * @OA\Response(
 *     response="ErrorResponse",
 *     description="Error de la operación",
 *     @OA\JsonContent(
 *         type="object",
 *         required={"success","message"},
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Ha ocurrido un error inesperado.")
 *     )
 * )
 * @OA\Response(
 *     response="ValidationErrorResponse",
 *     description="Error de validación",
 *     @OA\JsonContent(
 *         type="object",
 *         required={"success","message","errors"},
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Los datos proporcionados no son válidos."),
 *         @OA\Property(property="errors", type="object", example={"campo": {"El valor del campo es inválido."}})
 *     )
 * )
 * @OA\Server(
 *     url="http://localhost/api",
 *     description="Servidor de desarrollo local"
 * )
 * @OA\Tag(name="Health", description="Endpoint para verificar el estado de la API")
 * @OA\Tag(name="Camisetas", description="Gestión de camisetas.")
 * @OA\Tag(name="Clientes", description="Gestión de clientes.")
 * @OA\Tag(name="Tallas", description="Gestión de tallas.")
 * @OA\Tag(name="Camiseta-Tallas", description="Gestión de camisetas-tallas.")
 * @OA\Tag(name="Ventas", description="Gestión de ventas.")
 * @OA\Tag(name="Ventas-Detalles", description="Gestión de ventas-detalles.")
 * @OA\Tag(name="Administracion", description="Operaciones administrativas y consultas transversales.")
 */
abstract class Controller
{
    use ApiResponse;
}
