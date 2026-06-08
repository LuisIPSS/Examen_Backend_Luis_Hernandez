<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camisetas;
use Illuminate\Http\JsonResponse;

class CamisetasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return $this->successResponse(Camisetas::all());
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
            ]);

            $camiseta = Camisetas::create($validated);

            return $this->successResponse($camiseta, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Camisetas $camiseta): JsonResponse
    {
        try {
            return $this->successResponse($camiseta);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Camisetas $camisetas)
    {

    }

    /**
     * Update the specified resource in storage.
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
            ]);

            $camiseta->update($validated);

            return $this->successResponse(['message' => 'Camiseta actualizada correctamente']);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Camisetas $camiseta): JsonResponse
    {
        try {
            $camiseta->delete();

            return $this->successResponse($camiseta);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

}
