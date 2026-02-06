<?php
/**
 * Minify CSS/JS Assets
 * Run from browser: https://thuetaikhoan.net/minify-assets.php?key=thuetai2026minify
 */

$secretKey = 'thuetai2026minify';
if (!isset($_GET['key']) || $_GET['key'] !== $secretKey) {
    die('Forbidden - Invalid key');
}

header('Content-Type: text/plain');
echo "=== Asset Minifier ===\n\n";

$publicPath = __DIR__;

// CSS files to minify
$cssFiles = [
    'css/modern-ui.css',
    'css/mobile-menu.css',
    'css/price-modal.css',
    'css/service-page.css',
];

// JS files to minify
$jsFiles = [
    'js/modern-ui.js',
];

function minifyCSS($css) {
    // Remove comments
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    // Remove whitespace
    $css = preg_replace('/\s+/', ' ', $css);
    // Remove spaces around { } : ; , 
    $css = preg_replace('/\s*([{}:;,>+~])\s*/', '$1', $css);
    // Remove trailing semicolons before }
    $css = preg_replace('/;}/', '}', $css);
    // Remove leading/trailing whitespace
    $css = trim($css);
    return $css;
}

function minifyJS($js) {
    // Remove single-line comments (but not URLs)
    $js = preg_replace('#^\s*//[^\n]*$#m', '', $js);
    // Remove multi-line comments
    $js = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $js);
    // Remove extra whitespace
    $js = preg_replace('/\s+/', ' ', $js);
    // Remove whitespace around operators (simple version)
    $js = preg_replace('/\s*([{};,=:()[\]])\s*/', '$1', $js);
    // Trim
    $js = trim($js);
    return $js;
}

// Process CSS files
echo "Minifying CSS files:\n";
foreach ($cssFiles as $file) {
    $inputPath = $publicPath . '/' . $file;
    $outputPath = preg_replace('/\.css$/', '.min.css', $inputPath);
    
    if (!file_exists($inputPath)) {
        echo "  ⚠️  Skipped (not found): $file\n";
        continue;
    }
    
    $content = file_get_contents($inputPath);
    $originalSize = strlen($content);
    
    $minified = minifyCSS($content);
    $minifiedSize = strlen($minified);
    
    file_put_contents($outputPath, $minified);
    
    $reduction = round((1 - $minifiedSize / $originalSize) * 100, 1);
    echo "  ✅ $file -> " . basename($outputPath) . " ($originalSize -> $minifiedSize bytes, -{$reduction}%)\n";
}

// Process JS files
echo "\nMinifying JS files:\n";
foreach ($jsFiles as $file) {
    $inputPath = $publicPath . '/' . $file;
    $outputPath = preg_replace('/\.js$/', '.min.js', $inputPath);
    
    if (!file_exists($inputPath)) {
        echo "  ⚠️  Skipped (not found): $file\n";
        continue;
    }
    
    $content = file_get_contents($inputPath);
    $originalSize = strlen($content);
    
    $minified = minifyJS($content);
    $minifiedSize = strlen($minified);
    
    file_put_contents($outputPath, $minified);
    
    $reduction = round((1 - $minifiedSize / $originalSize) * 100, 1);
    echo "  ✅ $file -> " . basename($outputPath) . " ($originalSize -> $minifiedSize bytes, -{$reduction}%)\n";
}

echo "\n✅ Done! Now update your views to use .min.css and .min.js files.\n";
