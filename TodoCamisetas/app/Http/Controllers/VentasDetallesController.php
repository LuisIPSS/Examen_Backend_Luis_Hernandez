<?php

namespace App\Http\Controllers;

use App\Models\Ventas_detalles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VentasDetallesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/ventas-detalles",
     *     operationId="getVentasDetalles",
     *     tags={"Ventas-Detalles"},
     *     summary="Listar ventas detalles",
     *     description="Obtiene ventas detalles activas.",
     *     @OA\Response(response=200, description="Ventas detalles encontradas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/VentasDetalles"))
     *         )),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            return $this->successResponse(Ventas_detalles::all());
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/ventas-detalles",
     *     operationId="createVentaDetalle",
     *     tags={"Ventas-Detalles"},
     *     summary="Registrar nuevo venta detalle",
     *     description="Crea un nuevo venta detalle.",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VentasDetallesInput")),
     *     @OA\Response(response=201, description="Venta detalle creada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/VentasDetalles")
     *         )),
     *     @OA\Response(response=422, description="Errores de validación",
     *         ref="#/components/responses/ValidationErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'venta_id' => 'required|exists:ventas,id',
                'camiseta_talla_id' => 'required|exists:camiseta_tallas,id',
                'cantidad' => 'required|integer|min:1',
                'precio_unitario' => 'required|numeric',
                'precio_total' => 'required|numeric',
            ]);
            $ventas_detalle = Ventas_detalles::create($validated);

            return $this->successResponse($ventas_detalle, 201);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/ventas-detalles/{id}",
     *     operationId="getVentaDetalle",
     *     tags={"Ventas-Detalles"},
     *     summary="Obtener venta detalle por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Venta detalle encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/VentasDetalles")
     *         )),
     *     @OA\Response(response=404, description="Venta detalle no encontrada",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function show(Ventas_detalles $ventas_detalle): JsonResponse
    {
        try {
            return $this->successResponse($ventas_detalle);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ventas_detalles $ventas_detalles)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/ventas-detalles/{id}",
     *     operationId="updateVentaDetalle",
     *     tags={"Ventas-Detalles"},
     *     summary="Actualizar venta detalle",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VentasDetallesInput")),
     *     @OA\Response(response=200, description="Venta detalle actualizada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/VentasDetalles")
     *         )),
     *     @OA\Response(response=404, description="Venta detalle no encontrada",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=422, description="Errores de validación",
     *         ref="#/components/responses/ValidationErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function update(Request $request, Ventas_detalles $ventas_detalle): JsonResponse
    {
        try {
            $validated = $request->validate([
                'venta_id' => 'required|exists:ventas,id',
                'camiseta_talla_id' => 'required|exists:camiseta_tallas,id',
                'cantidad' => 'required|integer|min:0',
                'precio_unitario' => 'required|numeric',
                'precio_total' => 'required|numeric',
            ]);
            $ventas_detalle->update($validated);

            return $this->successResponse($ventas_detalle);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/ventas-detalles/{id}",
     *     operationId="deleteVentaDetalle",
     *     tags={"Ventas-Detalles"},
     *     summary="Eliminar venta detalle",
     *     description="Elimina el detalle de venta de la base de datos.",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Venta detalle eliminada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="message", type="string", example="Venta detalle eliminado correctamente")
     *             )
     *         )),
     *     @OA\Response(response=404, description="Venta detalle no encontrada",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function destroy(Ventas_detalles $ventas_detalle): JsonResponse
    {
        try {
            $ventas_detalle->delete();

            return $this->successResponse(['message' => 'Venta detalle eliminado correctamente']);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
