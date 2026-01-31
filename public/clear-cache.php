<?php
/**
 * Clear Laravel cache - Access này một lần rồi xóa file
 */

// Đường dẫn đến artisan
$basePath = __DIR__;

// Clear các cache
$commands = [
    'config:clear',
    'cache:clear', 
    'view:clear',
    'route:clear',
];

echo "<h2>Clearing Laravel Cache...</h2>";
echo "<pre>";

foreach ($commands as $cmd) {
    echo "Running: php artisan $cmd\n";
    echo shell_exec("cd $basePath && php artisan $cmd 2>&1");
    echo "\n";
}

echo "</pre>";
echo "<h3 style='color:green'>Done! Bây giờ hãy XÓA file này (clear-cache.php) để bảo mật!</h3>";
echo "<p><a href='/admin/login'>→ Đi đến Admin Login</a></p>";
