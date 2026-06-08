<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Camisetas;
class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        try {
            return $this->successResponse(Clientes::all());
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre_comercial' => 'required|string|max:255',
                'rut' => 'required|string|max:255',
                'direccion' => 'required|string|max:255',
                'categoria' => 'required|string|max:255',
                'contacto' => 'required|string|max:255',
                'procentaje_oferta' => 'required|integer|min:0',
            ]);
            $cliente = Clientes::create($validated);
            return $this->successResponse($cliente, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Clientes $cliente) : JsonResponse
    {
        try {
            return $this->successResponse($cliente);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clientes $cliente) : JsonResponse
    {
        try {
            $validated = $request->validate([
                'nombre_comercial' => 'required|string|max:255',
                'rut' => 'required|string|max:255',
                'direccion' => 'required|string|max:255',
                'categoria' => 'required|string|max:255',
                'contacto' => 'required|string|max:255',
                'procentaje_oferta' => 'required|integer|min:0',
            ]);
            $cliente->update($validated);
            return $this->successResponse($cliente);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clientes $cliente) : JsonResponse
    {
        try {
            $cliente->delete();
            return $this->successResponse(['message' => 'Cliente eliminado correctamente']);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function calcularpreciofinal(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'camiseta_id' => 'required|exists:camisetas,id',
                'cliente_id' => 'required|exists:clientes,id',
            ]);
            $camiseta = Camisetas::find($validated['camiseta_id']);
            $cliente = Clientes::find($validated['cliente_id']);

            if ($cliente->procentaje_oferta > 0) {
                $precioFinal = $camiseta->precio - ($camiseta->precio * $cliente->procentaje_oferta / 100);
                return $this->successResponse(['precio_final' => $precioFinal]);
            } else {
                return $this->successResponse(['precio_final' => $camiseta->precio]);
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

}
