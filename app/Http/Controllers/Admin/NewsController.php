<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,editor');
    }

    /**
     * Display a listing of news.
     */
    public function index()
    {
        $news = News::with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created news article in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt ?: Str::limit(strip_tags($request->content), 200),
            'category_id' => $request->category_id,
            'author_id' => auth()->id(),
            'is_published' => $request->boolean('is_published'),
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->boolean('is_published') ? now() : null,
        ];

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('news', 'public');
            $data['featured_image'] = $imagePath;
        }

        News::create($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully.');
    }

    /**
     * Display the specified news article.
     */
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified news article in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'excerpt' => $request->excerpt ?: Str::limit(strip_tags($request->content), 200),
            'category_id' => $request->category_id,
            'is_published' => $request->boolean('is_published'),
            'is_featured' => $request->boolean('is_featured'),
        ];

        // Update published_at when publishing for the first time
        if ($request->boolean('is_published') && !$news->is_published) {
            $data['published_at'] = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('news', 'public');
            $data['featured_image'] = $imagePath;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified news article from storage.
     */
    public function destroy(News $news)
    {
        // Delete featured image if exists
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }

    /**
     * Toggle news article published status.
     */
    public function togglePublished(News $news)
    {
        $news->is_published = !$news->is_published;
        if ($news->is_published && !$news->published_at) {
            $news->published_at = now();
        }
        $news->save();

        $status = $news->is_published ? 'published' : 'unpublished';
        return redirect()->route('admin.news.index')
            ->with('success', "News article {$status} successfully.");
    }

    /**
     * Toggle news article featured status.
     */
    public function toggleFeatured(News $news)
    {
        $news->is_featured = !$news->is_featured;
        $news->save();

        $status = $news->is_featured ? 'featured' : 'unfeatured';
        return redirect()->route('admin.news.index')
            ->with('success', "News article {$status} successfully.");
    }
}