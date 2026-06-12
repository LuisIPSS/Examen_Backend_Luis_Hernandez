<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class HealthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/health",
     *     operationId="healthCheck",
     *     tags={"Health"},
     *     summary="Verificar estado del servicio",
     *     description="Endpoint de observabilidad. Verifica que la API está disponible.",
     *     @OA\Response(
     *         response=200,
     *         description="Servicio operativo",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"status": "online", "service": "TodoCamisetas API", "version": "1.0.0", "timestamp": "2026-06-10T10:30:00+00:00"}
     *         )
     *     )
     * )
     */
    public function __invoke(): JsonResponse
    {
        return $this->successResponse([
            'status'    => 'online',
            'service'   => 'TodoCamisetas API',
            'version'   => '1.0.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
