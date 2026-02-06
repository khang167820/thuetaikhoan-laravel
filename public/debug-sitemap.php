<?php
// Debug sitemap posts

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\BlogPost;

echo "<h1>Sitemap Posts Debug</h1>";

try {
    echo "<h2>1. Testing BlogPost model...</h2>";
    
    $count = BlogPost::count();
    echo "Total blog posts: {$count}<br>";
    
    $published = BlogPost::where('is_published', true)->count();
    echo "Published posts: {$published}<br>";
    
    echo "<h2>2. Checking for null updated_at...</h2>";
    
    $nullUpdated = BlogPost::whereNull('updated_at')->count();
    echo "Posts with null updated_at: {$nullUpdated}<br>";
    
    $nullPublished = BlogPost::whereNull('published_at')->count();
    echo "Posts with null published_at: {$nullPublished}<br>";
    
    echo "<h2>3. Getting first 5 posts...</h2>";
    
    $posts = BlogPost::where('is_published', true)->take(5)->get();
    
    foreach ($posts as $post) {
        echo "- ID: {$post->id}, Slug: {$post->slug}, ";
        echo "updated_at: " . ($post->updated_at ?? 'NULL') . ", ";
        echo "published_at: " . ($post->published_at ?? 'NULL') . "<br>";
    }
    
    echo "<h3 style='color:green'>✅ All checks passed!</h3>";
    
} catch (\Exception $e) {
    echo "<h3 style='color:red'>Error: " . $e->getMessage() . "</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
