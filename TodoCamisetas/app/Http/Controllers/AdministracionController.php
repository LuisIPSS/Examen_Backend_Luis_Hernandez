<?php

namespace App\Http\Controllers;

use App\Models\Camisetas;
use App\Models\Clientes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdministracionController extends Controller
{
    /**
     * @OA\Post(
     *     path="/clientes/calcularpreciofinal",
     *     operationId="calcularPrecioFinal",
     *     tags={"Administracion"},
     *     summary="Calcular precio final",
     *     description="Calcula el precio final de una camiseta según oferta y categoría preferencial del cliente.",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"camiseta_id", "cliente_id"},
     *             @OA\Property(property="camiseta_id", type="integer", example=1),
     *             @OA\Property(property="cliente_id", type="integer", example=1)
     *         )),
     *     @OA\Response(response=200, description="Precio calculado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="precio_final", type="integer", example=8500)
     *             )
     *         )),
     *     @OA\Response(response=422, description="Errores de validación",
     *         ref="#/components/responses/ValidationErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function calcularPrecioFinal(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'camiseta_id' => 'required|exists:camisetas,id',
                'cliente_id' => 'required|exists:clientes,id',
            ]);

            $camiseta = Camisetas::find($validated['camiseta_id']);
            $cliente = Clientes::find($validated['cliente_id']);

            $precioBase = (! is_null($camiseta->precio_oferta) && $camiseta->precio_oferta > 0)
                ? $camiseta->precio_oferta
                : $camiseta->precio;

            $precioFinal = $precioBase;
            $esClientePreferencia = strtolower(trim($cliente->categoria)) === 'preferencial';

            if ($esClientePreferencia && $cliente->procentaje_oferta > 0) {
                $precioFinal = (int) round(
                    $precioBase - ($precioBase * $cliente->procentaje_oferta / 100)
                );
            }

            return $this->successResponse(['precio_final' => $precioFinal]);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/clientes/{id}/camisetas",
     *     operationId="getCamisetasPorCliente",
     *     tags={"Administracion"},
     *     summary="Listar camisetas por cliente",
     *     description="Obtiene las camisetas compradas por un cliente en sus ventas.",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Camisetas del cliente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Camisetas"))
     *         )),
     *     @OA\Response(response=404, description="Cliente no encontrado",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function camisetasPorCliente(Clientes $cliente): JsonResponse
    {
        try {
            $camisetas = Camisetas::query()
                ->whereHas('camisetaTallas.ventaDetalles.venta', function ($query) use ($cliente) {
                    $query->where('cliente_id', $cliente->id);
                })
                ->distinct()
                ->get();

            return $this->successResponse($camisetas);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
