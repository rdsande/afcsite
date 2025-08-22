<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NewsApiController extends Controller
{
    /**
     * Get all published news articles
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $news = News::published()
            ->with(['author', 'category'])
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $news->items(),
            'pagination' => [
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage(),
                'per_page' => $news->perPage(),
                'total' => $news->total(),
            ]
        ]);
    }

    /**
     * Get a specific news article
     */
    public function show($newsId): JsonResponse
    {
        $news = News::published()
            ->with(['author', 'category'])
            ->find($newsId);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News article not found'
            ], 404);
        }

        // Increment view count
        $news->increment('views');

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }

    /**
     * Get featured news articles
     */
    public function featured(): JsonResponse
    {
        $featuredNews = News::published()
            ->with(['author', 'category'])
            ->featured()
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $featuredNews
        ]);
    }

    /**
     * Get news by category
     */
    public function byCategory(string $category): JsonResponse
    {
        $news = News::published()
            ->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            })
            ->latest()
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }
}
