<?php
/**
 * Laravel 500 Error Diagnostic & Fix Script
 * Upload to public folder and access via browser
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Laravel 500 Error Diagnostic</h1>";
echo "<hr>";

// Check if running from public folder
$basePath = dirname(__DIR__);
echo "<h2>1. Path Check</h2>";
echo "<p>Base Path: <code>$basePath</code></p>";

// Check .env file
echo "<h2>2. .env File Check</h2>";
$envPath = $basePath . '/.env';
if (file_exists($envPath)) {
    echo "<p style='color:green'>✅ .env file EXISTS</p>";
} else {
    echo "<p style='color:red'>❌ .env file MISSING!</p>";
    
    // Try to copy from .env.example
    $examplePath = $basePath . '/.env.example';
    if (file_exists($examplePath)) {
        if (copy($examplePath, $envPath)) {
            echo "<p style='color:orange'>📋 Copied .env.example to .env</p>";
            echo "<p style='color:red'>⚠️ IMPORTANT: You need to update .env with correct database credentials!</p>";
        } else {
            echo "<p style='color:red'>❌ Failed to copy .env.example</p>";
        }
    } else {
        echo "<p style='color:red'>❌ .env.example also missing!</p>";
    }
}

// Check storage folders
echo "<h2>3. Storage Folder Check</h2>";
$storageFolders = [
    $basePath . '/storage/app',
    $basePath . '/storage/app/public',
    $basePath . '/storage/framework',
    $basePath . '/storage/framework/cache',
    $basePath . '/storage/framework/cache/data',
    $basePath . '/storage/framework/sessions',
    $basePath . '/storage/framework/views',
    $basePath . '/storage/logs',
    $basePath . '/bootstrap/cache',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        if (mkdir($folder, 0755, true)) {
            echo "<p style='color:orange'>📁 Created: " . str_replace($basePath, '', $folder) . "</p>";
        } else {
            echo "<p style='color:red'>❌ Failed to create: " . str_replace($basePath, '', $folder) . "</p>";
        }
    } else {
        echo "<p style='color:green'>✅ Exists: " . str_replace($basePath, '', $folder) . "</p>";
    }
}

// Check permissions
echo "<h2>4. Permission Check</h2>";
$checkPerms = [
    $basePath . '/storage' => 'Storage',
    $basePath . '/bootstrap/cache' => 'Bootstrap Cache',
];

foreach ($checkPerms as $path => $name) {
    if (is_dir($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $writable = is_writable($path) ? '✅ Writable' : '❌ NOT Writable';
        echo "<p>$name: Perms: $perms - $writable</p>";
        
        if (!is_writable($path)) {
            @chmod($path, 0755);
            echo "<p style='color:orange'>Attempted to fix permissions</p>";
        }
    }
}

// Clear bootstrap cache files
echo "<h2>5. Clear Bootstrap Cache</h2>";
$cacheFiles = glob($basePath . '/bootstrap/cache/*.php');
foreach ($cacheFiles as $file) {
    if (basename($file) !== '.gitignore') {
        if (@unlink($file)) {
            echo "<p style='color:green'>🗑️ Deleted: " . basename($file) . "</p>";
        }
    }
}
echo "<p>Cache cleared!</p>";

// Check for APP_KEY
echo "<h2>6. APP_KEY Check</h2>";
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    if (preg_match('/APP_KEY=(.*)/', $envContent, $matches)) {
        $key = trim($matches[1]);
        if (empty($key) || $key === 'base64:') {
            echo "<p style='color:red'>❌ APP_KEY is empty! Generating...</p>";
            
            // Generate a new key
            $newKey = 'base64:' . base64_encode(random_bytes(32));
            $envContent = preg_replace('/APP_KEY=.*/', 'APP_KEY=' . $newKey, $envContent);
            file_put_contents($envPath, $envContent);
            echo "<p style='color:green'>✅ Generated new APP_KEY</p>";
        } else {
            echo "<p style='color:green'>✅ APP_KEY is set</p>";
        }
    }
}

// Check error log
echo "<h2>7. Recent Error Log</h2>";
$logPath = $basePath . '/storage/logs/laravel.log';
if (file_exists($logPath)) {
    $log = file_get_contents($logPath);
    $lastLines = implode("\n", array_slice(explode("\n", $log), -50));
    echo "<pre style='background:#f0f0f0;padding:10px;overflow:auto;max-height:300px;font-size:12px'>" . htmlspecialchars($lastLines) . "</pre>";
} else {
    echo "<p>No error log found yet.</p>";
}

echo "<hr>";
echo "<h2>✅ Diagnostic Complete!</h2>";
echo "<p><a href='/'>← Try Homepage</a> | <a href='/admin/login'>Try Admin Login</a></p>";
echo "<p style='color:orange'>⚠️ DELETE this file after fixing! (fix-500.php)</p>";
