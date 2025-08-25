<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminNotice;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminNoticeApiController extends Controller
{
    /**
     * Get all active admin notices
     */
    public function index(Request $request): JsonResponse
    {
        $notices = AdminNotice::visible()
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get([
                'id',
                'title',
                'content',
                'type',
                'priority',
                'is_dismissible',
                'created_at'
            ]);

        return response()->json([
            'success' => true,
            'data' => $notices
        ]);
    }

    /**
     * Get admin notices for dashboard display
     */
    public function forDashboard(Request $request): JsonResponse
    {
        $notices = AdminNotice::forDashboard()
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get([
                'id',
                'title',
                'content',
                'type',
                'priority',
                'is_dismissible',
                'created_at'
            ]);

        return response()->json([
            'success' => true,
            'data' => $notices
        ]);
    }
}