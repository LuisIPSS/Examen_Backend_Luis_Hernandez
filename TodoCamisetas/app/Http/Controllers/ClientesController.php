<?php

namespace App\Http\Controllers;

use App\Models\Camisetas;
use App\Models\Clientes;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class ClientesController extends Controller
{
    /**
     * @OA\Get(
     *     path="/clientes",
     *     operationId="getClientes",
     *     tags={"Clientes"},
     *     summary="Listar clientes",
     *     description="Obtiene clientes activos.",
     *     @OA\Response(response=200, description="Clientes encontrados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Clientes"))
     *         )),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            return $this->successResponse(Clientes::all());
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/clientes",
     *     operationId="createCliente",
     *     tags={"Clientes"},
     *     summary="Registrar nuevo cliente",
     *     description="Crea un nuevo cliente.",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ClientesInput")),
     *     @OA\Response(response=201, description="Cliente creado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Clientes")
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
                'nombre_comercial' => 'required|string|max:255',
                'rut' => 'required|string|max:255|unique:clientes,rut',
                'direccion' => 'required|string|max:255',
                'categoria' => 'required|string|max:255',
                'contacto' => 'required|string|max:255',
                'procentaje_oferta' => 'required|integer|min:0',
            ]);

            $cliente = Clientes::create($validated);

            return $this->successResponse($cliente, 201);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23000') {
                return $this->errorResponse(
                    'El RUT ya está registrado.',
                    422,
                    ['rut' => ['El RUT ya está registrado.']]
                );
            }

            return $this->errorResponse($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/clientes/{id}",
     *     operationId="getCliente",
     *     tags={"Clientes"},
     *     summary="Obtener cliente por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Cliente encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Clientes")
     *         )),
     *     @OA\Response(response=404, description="Cliente no encontrado",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function show(Clientes $cliente): JsonResponse
    {
        try {
            return $this->successResponse($cliente);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/clientes/{id}",
     *     operationId="updateCliente",
     *     tags={"Clientes"},
     *     summary="Actualizar cliente",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ClientesInput")),
     *     @OA\Response(response=200, description="Cliente actualizado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/Clientes")
     *         )),
     *     @OA\Response(response=404, description="Cliente no encontrado",
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
    public function update(Request $request, Clientes $cliente): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre_comercial' => 'required|string|max:255',
                'rut' => 'required|string|max:255|unique:clientes,rut,' . $cliente->id,
                'direccion' => 'required|string|max:255',
                'categoria' => 'required|string|max:255',
                'contacto' => 'required|string|max:255',
                'procentaje_oferta' => 'required|integer|min:0',
            ]);

            $cliente->update($validated);

            return $this->successResponse($cliente);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23000') {
                return $this->errorResponse(
                    'El RUT ya está registrado.',
                    422,
                    ['rut' => ['El RUT ya está registrado.']]
                );
            }

            return $this->errorResponse($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/clientes/{id}",
     *     operationId="deleteCliente",
     *     tags={"Clientes"},
     *     summary="Eliminar cliente",
     *     description="Elimina el cliente si no tiene camisetas o ventas asociadas.",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Cliente eliminado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="message", type="string", example="Cliente eliminado correctamente")
     *             )
     *         )),
     *     @OA\Response(response=409, description="Cliente con datos asociados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="No se puede eliminar el cliente porque tiene ventas o camisetas asociadas.")
     *         )),
     *     @OA\Response(response=404, description="Cliente no encontrado",
     *         ref="#/components/responses/ErrorResponse"
     *     ),
     *     @OA\Response(response=500, description="Error interno del servidor",
     *         ref="#/components/responses/ErrorResponse"
     *     )
     * )
     */
    public function destroy(Clientes $cliente): JsonResponse
    {
        try {
            if ($this->verificarClientesConCamisetas($cliente)) {
                return $this->errorResponse(
                    'No se puede eliminar el cliente porque tiene ventas o camisetas asociadas.',
                    409
                );
            }

            $cliente->delete();

            return $this->successResponse(['message' => 'Cliente eliminado correctamente']);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->getMessage(), 422, $e->errors());
        } catch (QueryException $e) {
            if ((string) $e->getCode() === '23000') {
                return $this->errorResponse(
                    'No se puede eliminar el cliente porque tiene ventas o camisetas asociadas.',
                    409
                );
            }

            return $this->errorResponse($e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    private function verificarClientesConCamisetas(Clientes $cliente): bool
    {
        if ($cliente->ventas()->exists()) {
            return true;
        }

        if (Schema::hasColumn('camisetas', 'cliente_id')) {
            return Camisetas::where('cliente_id', $cliente->id)->exists();
        }

        if (! Schema::hasTable('ventas') || ! Schema::hasTable('ventas_detalles')) {
            return false;
        }

        return DB::table('ventas')
            ->join('ventas_detalles', 'ventas.id', '=', 'ventas_detalles.venta_id')
            ->where('ventas.cliente_id', $cliente->id)
            ->exists();
    }
}
