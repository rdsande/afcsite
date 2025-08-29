<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExclusiveStory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExclusiveStoriesApiController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Get all active exclusive stories for authenticated users
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            
            $stories = ExclusiveStory::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            $formattedStories = $stories->getCollection()->map(function ($story) {
                return $this->formatStoryForApi($story);
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'stories' => $formattedStories,
                    'pagination' => [
                        'current_page' => $stories->currentPage(),
                        'last_page' => $stories->lastPage(),
                        'per_page' => $stories->perPage(),
                        'total' => $stories->total(),
                        'has_more_pages' => $stories->hasMorePages()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch exclusive stories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get featured exclusive stories for home screen
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function featured(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 4);
            
            $stories = ExclusiveStory::where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            $formattedStories = $stories->map(function ($story) {
                return $this->formatStoryForApi($story);
            });

            return response()->json([
                'success' => true,
                'data' => $formattedStories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch featured exclusive stories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get exclusive stories by type (photos or videos)
     *
     * @param string $type
     * @param Request $request
     * @return JsonResponse
     */
    public function byType(string $type, Request $request): JsonResponse
    {
        try {
            if (!in_array($type, ['photos', 'videos'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid story type. Must be either "photos" or "videos"'
                ], 400);
            }

            $perPage = $request->get('per_page', 10);
            $page = $request->get('page', 1);
            
            $stories = ExclusiveStory::where('is_active', true)
                ->where('type', $type)
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            $formattedStories = $stories->getCollection()->map(function ($story) {
                return $this->formatStoryForApi($story);
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'stories' => $formattedStories,
                    'pagination' => [
                        'current_page' => $stories->currentPage(),
                        'last_page' => $stories->lastPage(),
                        'per_page' => $stories->perPage(),
                        'total' => $stories->total(),
                        'has_more_pages' => $stories->hasMorePages()
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch exclusive stories by type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a single exclusive story with its media
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $story = ExclusiveStory::where('is_active', true)
                ->findOrFail($id);

            // Get related stories (excluding current story)
            $relatedStories = ExclusiveStory::where('is_active', true)
                ->where('id', '!=', $id)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get()
                ->map(function ($story) {
                    return $this->formatStoryForApi($story, false); // Don't include full media details for related stories
                });

            $formattedStory = $this->formatStoryForApi($story, true);
            $formattedStory['related_stories'] = $relatedStories;

            return response()->json([
                'success' => true,
                'data' => $formattedStory
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Exclusive story not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Format story data for API response
     *
     * @param ExclusiveStory $story
     * @param bool $includeFullMedia
     * @return array
     */
    private function formatStoryForApi(ExclusiveStory $story, bool $includeFullMedia = true): array
    {
        $baseUrl = config('app.url');
        
        $formattedStory = [
            'id' => $story->id,
            'title' => $story->title,
            'description' => $story->description,
            'type' => $story->type,
            'status' => $story->is_active ? 'active' : 'inactive',
            'is_featured' => $story->is_featured,
            'video_link' => $story->video_link,
            'created_at' => $story->created_at->toIso8601String(),
            'updated_at' => $story->updated_at->toIso8601String(),
            'media_count' => $story->media_paths ? count($story->media_paths) : 0,
        ];

        // Add thumbnail
        if ($story->thumbnail) {
            $formattedStory['thumbnail'] = [
                'url' => $baseUrl . '/storage/' . $story->thumbnail,
                'type' => $this->getMediaType($story->thumbnail)
            ];
        } elseif ($story->thumbnail_path) {
            $formattedStory['thumbnail'] = [
                'url' => $baseUrl . '/storage/' . $story->thumbnail_path,
                'type' => $this->getMediaType($story->thumbnail_path)
            ];
        } elseif ($story->media_paths && count($story->media_paths) > 0) {
            // Use first media as thumbnail if no specific thumbnail
            $firstMedia = $story->media_paths[0];
            $formattedStory['thumbnail'] = [
                'url' => $baseUrl . '/storage/' . $firstMedia,
                'type' => $this->getMediaType($firstMedia)
            ];
        } else {
            $formattedStory['thumbnail'] = null;
        }

        // Include full media details if requested
        if ($includeFullMedia && $story->media_paths) {
            $formattedStory['media'] = collect($story->media_paths)->map(function ($mediaPath, $index) use ($baseUrl) {
                return [
                    'id' => $index + 1, // Generate a simple ID for Flutter compatibility
                    'file_path' => $mediaPath,
                    'file_type' => $this->getMediaType($mediaPath),
                    'file_size' => null, // Not available in current structure
                    'url' => $baseUrl . '/storage/' . $mediaPath,
                    'created_at' => now()->toIso8601String() // Use current timestamp as fallback
                ];
            })->toArray();
        }

        return $formattedStory;
    }

    /**
     * Get media type from file path.
     */
    private function getMediaType(string $filePath): string
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $videoExtensions = ['mp4', 'mov', 'avi', 'mkv', 'webm'];
        
        if (in_array($extension, $imageExtensions)) {
            return 'image/' . ($extension === 'jpg' ? 'jpeg' : $extension);
        } elseif (in_array($extension, $videoExtensions)) {
            return 'video/' . $extension;
        }
        
        return 'application/octet-stream';
    }
}