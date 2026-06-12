<?php

namespace App\Http\Controllers;

use App\Models\Camiseta_tallas;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CamisetaTallasController extends Controller
{
    /**
     * @OA\Get(
     *     path="/camiseta-tallas",
     *     operationId="getCamisetaTallas",
     *     tags={"Camiseta-Tallas"},
     *     summary="Listar camiseta tallas",
     *     description="Obtiene camiseta tallas activas.",
     *     @OA\Response(response=200, description="Camiseta tallas encontradas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/CamisetaTalla"))
     *         ))
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return $this->successResponse(Camiseta_tallas::all());
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
     *     path="/camiseta-tallas",
     *     operationId="createCamisetaTalla",
     *     tags={"Camiseta-Tallas"},
     *     summary="Registrar nueva camiseta talla",
     *     description="Crea una camiseta talla.",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CamisetaTallaInput")),
     *     @OA\Response(response=201, description="Camiseta talla creada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CamisetaTalla")
     *         )),
     *     @OA\Response(response=422, description="Errores de validación")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'camiseta_id' => [
                    'required',
                    'exists:camisetas,id',
                    Rule::unique('camiseta_tallas', 'camiseta_id')->where(function ($query) use ($request) {
                        return $query->where('talla_id', $request->input('talla_id'));
                    }),
                ],
                'talla_id' => 'required|exists:tallas,id',
                'stock' => 'required|integer|min:0',
            ]);
            $camiseta_talla = Camiseta_tallas::create($validated);

            return $this->successResponse($camiseta_talla, 201);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23000') {
                return $this->errorResponse(
                    'La combinación de camiseta y talla ya está registrada.',
                    422,
                    ['camiseta_id' => ['La combinación de camiseta y talla ya está registrada.']]
                );
            }

            return $this->errorResponse($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/camiseta-tallas/{id}",
     *     operationId="getCamisetaTalla",
     *     tags={"Camiseta-Tallas"},
     *     summary="Obtener camiseta talla por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Camiseta talla encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CamisetaTalla")
     *         )),
     *     @OA\Response(response=404, description="Camiseta talla no encontrada")
     * )
     */
    public function show(Camiseta_tallas $camiseta_talla): JsonResponse
    {
        try {
            return $this->successResponse($camiseta_talla);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(camiseta_tallas $camiseta_tallas)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/camiseta-tallas/{id}",
     *     operationId="updateCamisetaTalla",
     *     tags={"Camiseta-Tallas"},
     *     summary="Actualizar camiseta talla",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CamisetaTallaInput")),
     *     @OA\Response(response=200, description="Camiseta talla actualizada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/CamisetaTalla")
     *         )),
     *     @OA\Response(response=404, description="Camiseta talla no encontrada"),
     *     @OA\Response(response=422, description="Errores de validación")
     * )
     */
    public function update(Request $request, Camiseta_tallas $camiseta_talla): JsonResponse
    {
        try {
            $validated = $request->validate([
                'camiseta_id' => [
                    'required',
                    'exists:camisetas,id',
                    Rule::unique('camiseta_tallas', 'camiseta_id')
                        ->where(function ($query) use ($request) {
                            return $query->where('talla_id', $request->input('talla_id'));
                        })
                        ->ignore($camiseta_talla->id),
                ],
                'talla_id' => 'required|exists:tallas,id',
                'stock' => 'required|integer|min:0',
            ]);
            $camiseta_talla->update($validated);

            return $this->successResponse($camiseta_talla);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23000') {
                return $this->errorResponse(
                    'La combinación de camiseta y talla ya está registrada.',
                    422,
                    ['camiseta_id' => ['La combinación de camiseta y talla ya está registrada.']]
                );
            }

            return $this->errorResponse($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/camiseta-tallas/{id}",
     *     operationId="deleteCamisetaTalla",
     *     tags={"Camiseta-Tallas"},
     *     summary="Eliminar camiseta talla",
     *     description="Elimina la relación camiseta-talla de la base de datos.",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Camiseta talla eliminada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="message", type="string", example="Camiseta talla eliminada correctamente")
     *             )
     *         )),
     *     @OA\Response(response=404, description="Camiseta talla no encontrada"),
     *     @OA\Response(response=409, description="No se puede eliminar la relación porque tiene registros asociados")
     * )
     */
    public function destroy(Camiseta_tallas $camiseta_talla): JsonResponse
    {
        try {
            $camiseta_talla->delete();

            return $this->successResponse(['message' => 'Camiseta talla eliminada correctamente']);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23000') {
                return $this->errorResponse(
                    'No se puede eliminar la relación camiseta-talla porque tiene ventas asociadas.',
                    409
                );
            }

            return $this->errorResponse($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
