<?php
// git-sync.php - Force git pull on server
// DELETE THIS FILE AFTER USE!

echo "<h1>Git Sync</h1>";

$output = [];
$returnVar = 0;

// Change to project root
chdir(__DIR__ . '/..');

echo "<h2>Running: git fetch origin</h2>";
exec('git fetch origin 2>&1', $output, $returnVar);
echo "<pre>" . implode("\n", $output) . "</pre>";

$output = [];
echo "<h2>Running: git reset --hard origin/main</h2>";
exec('git reset --hard origin/main 2>&1', $output, $returnVar);
echo "<pre>" . implode("\n", $output) . "</pre>";

$output = [];
echo "<h2>Running: git status</h2>";
exec('git status 2>&1', $output, $returnVar);
echo "<pre>" . implode("\n", $output) . "</pre>";

echo "<h2>Clearing Laravel cache...</h2>";
exec('php artisan config:clear 2>&1', $output);
exec('php artisan cache:clear 2>&1', $output);
exec('php artisan view:clear 2>&1', $output);

echo "<h3 style='color: green;'>Done! Now test: <a href='/sitemap-posts.xml'>/sitemap-posts.xml</a></h3>";
echo "<p style='color: red;'><strong>DELETE THIS FILE NOW!</strong></p>";
