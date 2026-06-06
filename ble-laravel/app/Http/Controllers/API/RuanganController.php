<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\JsonResponse;

class RuanganController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Ruangan::all());
    }

    public function show(string $idRuangan): JsonResponse
    {
        $ruangan = Ruangan::findOrFail($idRuangan);
        return response()->json($ruangan);
    }
}