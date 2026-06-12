<?php

namespace App\Http\Controllers;

use App\Models\Camisetas;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CamisetasController extends Controller
{
    /**
     * @OA\Get(
     *     path="/camisetas",
     *     operationId="getCamisetas",
     *     tags={"Camisetas"},
     *     summary="Listar camisetas",
     *     description="Obtiene camisetas activas.",
     *     @OA\Response(response=200, description="Camisetas encontradas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Camisetas"))
     *         ))
     * )
     */
    public function index(): JsonResponse
    {
        try {
            return $this->successResponse(Camisetas::all());
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/camisetas",
     *     operationId="createCamiseta",
     *     tags={"Camisetas"},
     *     summary="Registrar nueva camiseta",
     *     description="Crea una camiseta.",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CamisetasInput")),
     *     @OA\Response(response=201, description="Camiseta creada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Camisetas")
     *         )),
     *     @OA\Response(response=422, description="Datos inválidos o SKU duplicado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The sku field is required."),
     *             @OA\Property(property="errors", type="object")
     *         ))
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'club' => 'required|string|max:255',
                'pais' => 'required|string|max:255',
                'tipo' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'precio' => 'required|integer|min:0',
                'precio_oferta' => 'nullable|integer|min:0|lt:precio',
                'detalles' => 'nullable|string',
                'sku' => 'required|string|max:255|unique:camisetas,sku',
            ]);

            $camiseta = Camisetas::create($validated);

            return $this->successResponse($camiseta, 201);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/camisetas/{id}",
     *     operationId="getCamiseta",
     *     tags={"Camisetas"},
     *     summary="Obtener camiseta por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Camiseta encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Camisetas")
     *         )),
     *     @OA\Response(response=404, description="Camiseta no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Recurso no encontrado")
     *         ))
     * )
     */
    public function show(Camisetas $camiseta): JsonResponse
    {
        try {
            return $this->successResponse($camiseta);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/camisetas/{id}",
     *     operationId="updateCamiseta",
     *     tags={"Camisetas"},
     *     summary="Actualizar camiseta",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CamisetasInput")),
     *     @OA\Response(response=200, description="Camiseta actualizada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="message", type="string", example="Camiseta actualizada correctamente")
     *             )
     *         )),
     *     @OA\Response(response=404, description="Camiseta no encontrada"),
     *     @OA\Response(response=422, description="Datos inválidos o SKU duplicado")
     * )
     */
    public function update(Request $request, Camisetas $camiseta): JsonResponse
    {
        try {
            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'club' => 'required|string|max:255',
                'pais' => 'required|string|max:255',
                'tipo' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'precio' => 'required|integer|min:0',
                'precio_oferta' => 'nullable|integer|min:0|lt:precio',
                'detalles' => 'nullable|string',
                'sku' => 'required|string|max:255|unique:camisetas,sku,' . $camiseta->id,
            ]);

            $camiseta->update($validated);

            return $this->successResponse(['message' => 'Camiseta actualizada correctamente']);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/camisetas/{id}",
     *     operationId="deleteCamiseta",
     *     tags={"Camisetas"},
     *     summary="Eliminar camiseta",
     *     description="Elimina la camiseta de la base de datos.",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Camiseta eliminada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Camisetas")
     *         )),
     *     @OA\Response(response=404, description="Camiseta no encontrada"),
     *     @OA\Response(response=409, description="No se puede eliminar la camiseta porque tiene registros asociados"),
     *     @OA\Response(response=422, description="Errores de validación")
     * )
     */
    public function destroy(Camisetas $camiseta): JsonResponse
    {
        try {
            $camiseta->delete();
            return $this->successResponse($camiseta);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23000') {
                return $this->errorResponse(
                    'No se puede eliminar la camiseta porque tiene stock o ventas asociadas.',
                    409
                );
            }

            return $this->errorResponse($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
