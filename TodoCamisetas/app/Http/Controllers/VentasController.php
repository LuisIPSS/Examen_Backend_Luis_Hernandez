<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VentasController extends Controller
{
    /**
     * @OA\Get(
     *     path="/ventas",
     *     operationId="getVentas",
     *     tags={"Ventas"},
     *     summary="Listar ventas",
     *     description="Obtiene ventas activas.",
     *     @OA\Response(response=200, description="Ventas encontradas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Ventas"))
     *         )),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return $this->successResponse(Ventas::all());
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
     *     path="/ventas",
     *     operationId="createVenta",
     *     tags={"Ventas"},
     *     summary="Registrar nueva venta",
     *     description="Crea una nueva venta.",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VentasInput")),
     *     @OA\Response(response=201, description="Venta creada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Ventas")
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
                'cliente_id' => 'required|exists:clientes,id',
                'total' => 'required|numeric',
                'fecha' => 'required|date',
            ]);
            $venta = Ventas::create($validated);

            return $this->successResponse($venta, 201);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/ventas/{id}",
     *     operationId="getVenta",
     *     tags={"Ventas"},
     *     summary="Obtener venta por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Venta encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Ventas")
     *         )),
     *     @OA\Response(response=404, description="Venta no encontrada",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function show(Ventas $venta): JsonResponse
    {
        try {
            return $this->successResponse($venta);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ventas $ventas)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/ventas/{id}",
     *     operationId="updateVenta",
     *     tags={"Ventas"},
     *     summary="Actualizar venta",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VentasInput")),
     *     @OA\Response(response=200, description="Venta actualizada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Ventas")
     *         )),
     *     @OA\Response(response=404, description="Venta no encontrada",
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
    public function update(Request $request, Ventas $venta): JsonResponse
    {
        try {
            $validated = $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'total' => 'required|numeric',
                'fecha' => 'required|date',
            ]);
            $venta->update($validated);

            return $this->successResponse($venta);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/ventas/{id}",
     *     operationId="deleteVenta",
     *     tags={"Ventas"},
     *     summary="Eliminar venta",
     *     description="Elimina la venta de la base de datos.",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Venta eliminada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="message", type="string", example="Venta eliminada correctamente")
     *             )
     *         )),
     *     @OA\Response(response=404, description="Venta no encontrada",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function destroy(Ventas $venta): JsonResponse
    {
        try {
            $venta->delete();

            return $this->successResponse(['message' => 'Venta eliminada correctamente']);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
