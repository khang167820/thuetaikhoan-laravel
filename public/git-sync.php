<?php
// Simple debug script - shows blog post info
// No exec() needed - works on shared hosting

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\BlogPost;

echo "<h1>Blog Posts Debug</h1>";

try {
    $count = BlogPost::count();
    echo "<p>Total posts: <strong>{$count}</strong></p>";
    
    $published = BlogPost::where('status', 'published')->count();
    echo "<p>Published posts: <strong>{$published}</strong></p>";
    
    echo "<h2>First 10 posts:</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Slug</th><th>Created At</th><th>Updated At</th></tr>";
    
    $posts = BlogPost::where('status', 'published')->take(10)->get();
    foreach ($posts as $post) {
        $pubAt = $post->published_at ?? 'NULL';
        $updAt = $post->updated_at ?? 'NULL';
        echo "<tr><td>{$post->id}</td><td>{$post->slug}</td><td>{$pubAt}</td><td>{$updAt}</td></tr>";
    }
    echo "</table>";
    
    echo "<h3 style='color:green'>✅ BlogPost model works!</h3>";
    echo "<p>Try sitemap: <a href='/sitemap-posts.xml'>/sitemap-posts.xml</a></p>";
    
} catch (\Exception $e) {
    echo "<h3 style='color:red'>Error: " . $e->getMessage() . "</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
