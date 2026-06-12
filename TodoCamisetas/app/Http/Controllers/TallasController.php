<?php

namespace App\Http\Controllers;

use App\Models\Tallas;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TallasController extends Controller
{
    /**
     * @OA\Get(
     *     path="/tallas",
     *     operationId="getTallas",
     *     tags={"Tallas"},
     *     summary="Listar tallas",
     *     description="Obtiene tallas activas.",
     *     @OA\Response(response=200, description="Tallas encontradas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Tallas"))
     *         )),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return $this->successResponse(Tallas::all());
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
     *     path="/tallas",
     *     operationId="createTalla",
     *     tags={"Tallas"},
     *     summary="Registrar nueva talla",
     *     description="Crea una nueva talla.",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TallasInput")),
     *     @OA\Response(response=201, description="Talla creada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Tallas")
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
                'talla' => 'required|string|max:255|unique:tallas,talla',
            ]);
            $talla = Tallas::create($validated);

            return $this->successResponse($talla, 201);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23000') {
                return $this->errorResponse(
                    'La talla ya está registrada.',
                    422,
                    ['talla' => ['La talla ya está registrada.']]
                );
            }

            return $this->errorResponse($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/tallas/{id}",
     *     operationId="getTalla",
     *     tags={"Tallas"},
     *     summary="Obtener talla por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Talla encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Tallas")
     *         )),
     *     @OA\Response(response=404, description="Talla no encontrada",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function show(Tallas $talla): JsonResponse
    {
        try {
            return $this->successResponse($talla);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tallas $tallas)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/tallas/{id}",
     *     operationId="updateTalla",
     *     tags={"Tallas"},
     *     summary="Actualizar talla",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TallasInput")),
     *     @OA\Response(response=200, description="Talla actualizada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Tallas")
     *         )),
     *     @OA\Response(response=404, description="Talla no encontrada",
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
    public function update(Request $request, Tallas $talla): JsonResponse
    {
        try {
            $validated = $request->validate([
                'talla' => 'required|string|max:255|unique:tallas,talla,' . $talla->id,
            ]);
            $talla->update($validated);

            return $this->successResponse($talla);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23000') {
                return $this->errorResponse(
                    'La talla ya está registrada.',
                    422,
                    ['talla' => ['La talla ya está registrada.']]
                );
            }

            return $this->errorResponse($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/tallas/{id}",
     *     operationId="deleteTalla",
     *     tags={"Tallas"},
     *     summary="Eliminar talla",
     *     description="Elimina la talla de la base de datos.",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Talla eliminada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="message", type="string", example="Talla eliminada correctamente")
     *             )
     *         )),
     *     @OA\Response(response=404, description="Talla no encontrada",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=409, description="No se puede eliminar la talla porque tiene registros asociados",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function destroy(Tallas $talla): JsonResponse
    {
        try {
            $talla->delete();

            return $this->successResponse(['message' => 'Talla eliminada correctamente']);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23000') {
                return $this->errorResponse(
                    'No se puede eliminar la talla porque tiene stock o ventas asociadas.',
                    409
                );
            }

            return $this->errorResponse($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
