<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExclusiveStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExclusiveStoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stories = ExclusiveStory::ordered()->paginate(10);
        return view('admin.exclusive-stories.index', compact('stories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.exclusive-stories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:photos,video',
            'description' => 'nullable|string',
            'media_files' => 'required_without:video_link|array|min:1',
            'media_files.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:20480', // 20MB max
            'video_link' => 'required_without:media_files|nullable|url',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:5120', // 5MB max for thumbnail
            'order_position' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $mediaPaths = [];
        $thumbnailPath = null;

        // Handle file uploads
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('exclusive-stories', $filename, 'public');
                $mediaPaths[] = $path;
            }
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailFilename = 'thumb_' . time() . '_' . Str::random(10) . '.' . $thumbnailFile->getClientOriginalExtension();
            $thumbnailPath = $thumbnailFile->storeAs('exclusive-stories/thumbnails', $thumbnailFilename, 'public');
        }

        ExclusiveStory::create([
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'media_paths' => $mediaPaths,
            'video_link' => $request->video_link,
            'thumbnail' => $thumbnailPath,
            'thumbnail_path' => $thumbnailPath,
            'order_position' => $request->order_position ?? 0,
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured')
        ]);

        return redirect()->route('admin.exclusive-stories.index')
                        ->with('success', 'Exclusive story created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExclusiveStory $exclusiveStory)
    {
        return view('admin.exclusive-stories.show', compact('exclusiveStory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExclusiveStory $exclusiveStory)
    {
        return view('admin.exclusive-stories.edit', compact('exclusiveStory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExclusiveStory $exclusiveStory)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:photos,video',
            'description' => 'nullable|string',
            'media_files' => 'nullable|array',
            'media_files.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:20480',
            'video_link' => 'nullable|url',
            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:5120', // 5MB max for thumbnail
            'order_position' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $mediaPaths = $exclusiveStory->media_paths ?? [];
        $thumbnailPath = $exclusiveStory->thumbnail;

        // Handle new file uploads
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('exclusive-stories', $filename, 'public');
                $mediaPaths[] = $path;
            }
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($thumbnailPath) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailFilename = 'thumb_' . time() . '_' . Str::random(10) . '.' . $thumbnailFile->getClientOriginalExtension();
            $thumbnailPath = $thumbnailFile->storeAs('exclusive-stories/thumbnails', $thumbnailFilename, 'public');
        }

        $exclusiveStory->update([
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'media_paths' => $mediaPaths,
            'video_link' => $request->video_link,
            'thumbnail' => $thumbnailPath,
            'thumbnail_path' => $thumbnailPath,
            'order_position' => $request->order_position ?? 0,
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured')
        ]);

        return redirect()->route('admin.exclusive-stories.index')
                        ->with('success', 'Exclusive story updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExclusiveStory $exclusiveStory)
    {
        // Delete associated files
        if ($exclusiveStory->media_paths) {
            foreach ($exclusiveStory->media_paths as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        if ($exclusiveStory->thumbnail) {
            Storage::disk('public')->delete($exclusiveStory->thumbnail);
        }

        if ($exclusiveStory->thumbnail_path) {
            Storage::disk('public')->delete($exclusiveStory->thumbnail_path);
        }

        $exclusiveStory->delete();

        return redirect()->route('admin.exclusive-stories.index')
                        ->with('success', 'Exclusive story deleted successfully!');
    }

    /**
     * Remove a specific media file from story
     */
    public function removeMedia(Request $request, ExclusiveStory $exclusiveStory)
    {
        $mediaIndex = $request->input('media_index');
        $mediaPaths = $exclusiveStory->media_paths;

        if (isset($mediaPaths[$mediaIndex])) {
            Storage::disk('public')->delete($mediaPaths[$mediaIndex]);
            unset($mediaPaths[$mediaIndex]);
            $mediaPaths = array_values($mediaPaths); // Re-index array

            $exclusiveStory->update(['media_paths' => $mediaPaths]);
        }

        return response()->json(['success' => true]);
    }
}
