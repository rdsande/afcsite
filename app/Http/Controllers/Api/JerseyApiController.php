<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jersey;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class JerseyApiController extends Controller
{
    /**
     * Get all active jerseys
     */
    public function index(): JsonResponse
    {
        $jerseys = Jersey::active()
            ->select('id', 'name', 'type', 'template_image', 'description', 'season')
            ->orderBy('type')
            ->get()
            ->map(function ($jersey) {
                return [
                    'id' => $jersey->id,
                    'name' => $jersey->name,
                    'type' => $jersey->type,
                    'description' => $jersey->description,
                    'season' => $jersey->season,
                    'image_url' => $jersey->template_image ? asset('storage/' . $jersey->template_image) : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $jerseys
        ]);
    }

    /**
     * Get jerseys by type
     */
    public function getByType(string $type): JsonResponse
    {
        $jersey = Jersey::active()
            ->byType($type)
            ->select('id', 'name', 'type', 'template_image', 'description', 'season')
            ->first();

        if (!$jersey) {
            return response()->json([
                'success' => false,
                'message' => 'Jersey not found for type: ' . $type
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $jersey->id,
                'name' => $jersey->name,
                'type' => $jersey->type,
                'description' => $jersey->description,
                'season' => $jersey->season,
                'image_url' => $jersey->template_image ? asset('storage/' . $jersey->template_image) : null,
            ]
        ]);
    }

    /**
     * Get jersey types with their active jerseys
     */
    public function getTypes(): JsonResponse
    {
        $types = ['home', 'away', 'third'];
        $jerseyTypes = [];

        foreach ($types as $type) {
            $jersey = Jersey::active()->byType($type)->first();
            $jerseyTypes[] = [
                'type' => $type,
                'name' => $jersey ? $jersey->name : ucfirst($type) . ' Jersey',
                'image_url' => $jersey && $jersey->template_image ? asset('storage/' . $jersey->template_image) : null,
                'available' => $jersey !== null
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $jerseyTypes
        ]);
    }

    /**
     * Get a specific jersey
     */
    public function show(Jersey $jersey): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $jersey->id,
                'name' => $jersey->name,
                'type' => $jersey->type,
                'description' => $jersey->description,
                'season' => $jersey->season,
                'image_url' => $jersey->template_image ? asset('storage/' . $jersey->template_image) : null,
                'is_active' => $jersey->is_active,
                'created_at' => $jersey->created_at,
                'updated_at' => $jersey->updated_at,
            ]
        ]);
    }
}