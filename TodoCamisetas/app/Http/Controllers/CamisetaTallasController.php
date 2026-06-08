<?php

namespace App\Http\Controllers;

use App\Models\Camiseta_tallas;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CamisetaTallasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        try {
            return $this->successResponse(Camiseta_tallas::all());
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
                'camiseta_id' => 'required|exists:camisetas,id',
                'talla_id' => 'required|exists:tallas,id',
                'stock' => 'required|integer|min:0',
            ]);
            $camiseta_talla = Camiseta_tallas::create($validated);
            return $this->successResponse($camiseta_talla, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Camiseta_tallas $camiseta_talla) : JsonResponse
    {
        try {
            return $this->successResponse($camiseta_talla);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Camiseta_tallas $camiseta_talla) : JsonResponse
    {
        try {
            $validated = $request->validate([
                'camiseta_id' => 'required|exists:camisetas,id',
                'talla_id' => 'required|exists:tallas,id',
                'stock' => 'required|integer|min:0',
            ]);
            $camiseta_talla->update($validated);
            return $this->successResponse($camiseta_talla);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Camiseta_tallas $camiseta_talla) : JsonResponse
    {
        try {
            $camiseta_talla->delete();
            return $this->successResponse(['message' => 'Camiseta talla eliminada correctamente']);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
