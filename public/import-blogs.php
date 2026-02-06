<?php
/**
 * Import Legacy Blog Posts to Laravel Database
 * Run this script from browser: https://thuetaikhoan.net/import-blogs.php
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use Illuminate\Support\Facades\DB;

echo "<h1>Import Legacy Blogs</h1>";

// Try to find blog directory with various paths
$possiblePaths = [
    '/home/u620980434/domains/thuetaikhoan.net/public_html/blog',  // Hostinger absolute
    __DIR__ . '/../blog',                                           // If blog folder is in Laravel root
    __DIR__ . '/../../public_html/blog',                           // Original path
    __DIR__ . '/blog',                                              // If blog is in public folder
    '/home/u620980434/blog',                                        // Alternative
];

$blogDir = null;
echo "<h3>🔍 Finding blog directory...</h3>";
echo "<pre>";
foreach ($possiblePaths as $path) {
    $exists = is_dir($path);
    $count = $exists ? count(glob($path . '/*.php')) : 0;
    echo "Path: $path\n";
    echo "  Exists: " . ($exists ? 'YES' : 'NO') . "\n";
    echo "  PHP files: $count\n\n";
    
    if ($exists && $count > 10 && $blogDir === null) {
        $blogDir = $path;
        echo "  >>> USING THIS PATH <<<\n\n";
    }
}

if (!$blogDir) {
    echo "</pre>";
    echo "<h2 style='color:red'>❌ Could not find blog directory!</h2>";
    echo "<p>Please check the paths above and update the script.</p>";
    exit;
}

echo "Selected: $blogDir\n";
echo "</pre>";

$files = glob($blogDir . '/*.php');

// Exclude special files
$excludeFiles = ['.htaccess', 'post.php', 'testpoint-edl9008-data.php', 'testpoint-edl9008-samsung-data.php'];

$imported = 0;
$skipped = 0;
$errors = [];

foreach ($files as $file) {
    $filename = basename($file);
    
    // Skip excluded files and testpoint data files
    if (in_array($filename, $excludeFiles)) {
        continue;
    }
    
    // Skip small redirect files (under 500 bytes typically are redirects)
    if (filesize($file) < 500) {
        echo "SKIP (small file): $filename\n";
        $skipped++;
        continue;
    }
    
    $content = file_get_contents($file);
    
    // Extract $post array data
    if (!preg_match('/\$post\s*=\s*\[([^\]]+)\]/s', $content, $postMatch)) {
        echo "SKIP (no \$post): $filename\n";
        $skipped++;
        continue;
    }
    
    // Parse post data
    $postData = $postMatch[0];
    
    // Extract title
    preg_match("/'title'\s*=>\s*'([^']+)'/", $postData, $titleMatch);
    $title = $titleMatch[1] ?? basename($filename, '.php');
    
    // Extract category
    preg_match("/'category'\s*=>\s*'([^']+)'/", $postData, $categoryMatch);
    $category = $categoryMatch[1] ?? 'Tin tức';
    
    // Extract date
    preg_match("/'date'\s*=>\s*'([^']+)'/", $postData, $dateMatch);
    $date = $dateMatch[1] ?? '2026-01-01';
    
    // Extract pageDescription
    preg_match('/\$pageDescription\s*=\s*[\'"]([^\'"]+)[\'"]/s', $content, $descMatch);
    $description = $descMatch[1] ?? '';
    
    // Extract article content
    if (preg_match('/<article class="blog-article">(.*?)<\/article>/s', $content, $articleMatch)) {
        $articleContent = trim($articleMatch[1]);
    } else {
        // Try alternative extraction for content section
        if (preg_match('/<section class="blog-post-content">.*?<article[^>]*>(.*?)<\/article>/s', $content, $articleMatch)) {
            $articleContent = trim($articleMatch[1]);
        } else {
            echo "SKIP (no article): $filename\n";
            $skipped++;
            continue;
        }
    }
    
    // Generate slug from filename
    $slug = str_replace('.php', '', $filename);
    
    // Check if already exists
    $exists = DB::table('blog_posts')->where('slug', $slug)->exists();
    if ($exists) {
        echo "EXISTS: $slug\n";
        $skipped++;
        continue;
    }
    
    // Insert into database
    try {
        DB::table('blog_posts')->insert([
            'title' => $title,
            'slug' => $slug,
            'excerpt' => mb_substr(strip_tags($description), 0, 300),
            'content' => $articleContent,
            'category' => $category,
            'author' => 'Admin',
            'status' => 'published',
            'views' => rand(100, 5000),
            'meta_title' => $title,
            'meta_description' => $description,
            'created_at' => $date . ' 08:00:00',
            'updated_at' => now(),
        ]);
        
        echo "IMPORTED: $slug\n";
        $imported++;
        
    } catch (\Exception $e) {
        $errors[] = "$filename: " . $e->getMessage();
        echo "ERROR: $filename - " . $e->getMessage() . "\n";
    }
}

echo "</pre>";

echo "<h2>Summary</h2>";
echo "<p>✅ Imported: <strong>$imported</strong></p>";
echo "<p>⏭️ Skipped: <strong>$skipped</strong></p>";
echo "<p>❌ Errors: <strong>" . count($errors) . "</strong></p>";

if (count($errors) > 0) {
    echo "<h3>Errors:</h3><ul>";
    foreach ($errors as $err) {
        echo "<li>$err</li>";
    }
    echo "</ul>";
}

echo "<p><a href='/sitemap-posts.xml'>View updated sitemap</a></p>";
echo "<p style='color:red'><strong>DELETE THIS FILE AFTER IMPORT!</strong></p>";
