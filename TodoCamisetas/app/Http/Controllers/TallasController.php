<?php

namespace App\Http\Controllers;

use App\Models\Tallas;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TallasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        try {
            return $this->successResponse(Tallas::all());
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
                'talla' => 'required|string|max:255',
            ]);
            $talla = Tallas::create($validated);
            return $this->successResponse($talla, 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tallas $talla) : JsonResponse
    {
        try {
            return $this->successResponse($talla);
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tallas $talla) : JsonResponse
    {
        try {
            $validated = $request->validate([
                'talla' => 'required|string|max:255',
            ]);
            $talla->update($validated);
            return $this->successResponse($talla);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tallas $talla) : JsonResponse
    {
        try {
            $talla->delete();
            return $this->successResponse(['message' => 'Talla eliminada correctamente']);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
