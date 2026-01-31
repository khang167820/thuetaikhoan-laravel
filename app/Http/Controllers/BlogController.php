<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display blog listing page
     */
    public function index(Request $request)
    {
        $query = DB::table('blog_posts')
            ->where('status', 'published')
            ->orderBy('created_at', 'desc');
        
        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        // Search
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                  ->orWhere('content', 'LIKE', "%$search%");
            });
        }
        
        $posts = $query->paginate(12);
        
        // Get categories for filter
        $categories = DB::table('blog_posts')
            ->where('status', 'published')
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
        
        return view('blog.index', compact('posts', 'categories'));
    }
    
    /**
     * Display single blog post
     */
    public function show($slug)
    {
        $post = DB::table('blog_posts')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();
        
        if (!$post) {
            abort(404);
        }
        
        // Increment views
        DB::table('blog_posts')
            ->where('id', $post->id)
            ->increment('views');
        
        // Get related posts
        $relatedPosts = DB::table('blog_posts')
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(4)
            ->get();
        
        return view('blog.show', compact('post', 'relatedPosts'));
    }
    
    /**
     * Display posts by category
     */
    public function category($category)
    {
        $posts = DB::table('blog_posts')
            ->where('category', $category)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        
        $categories = DB::table('blog_posts')
            ->where('status', 'published')
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
        
        return view('blog.index', compact('posts', 'categories', 'category'));
    }
}
