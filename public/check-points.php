<?php
// Check welcome.blade.php content for loyalty points checkbox
$file = __DIR__ . '/../resources/views/welcome.blade.php';

if (!file_exists($file)) {
    echo "File not found!";
    exit;
}

$content = file_get_contents($file);

// Check for loyalty points checkbox
if (strpos($content, 'pm-use-points-wrapper') !== false) {
    echo "✅ pm-use-points-wrapper FOUND<br>";
} else {
    echo "❌ pm-use-points-wrapper NOT FOUND<br>";
}

if (strpos($content, 'Sử dụng điểm tích lũy') !== false) {
    echo "✅ 'Sử dụng điểm tích lũy' text FOUND<br>";
} else {
    echo "❌ 'Sử dụng điểm tích lũy' text NOT FOUND<br>";
}

if (strpos($content, 'display:none') !== false && strpos($content, 'pm-use-points-wrapper') !== false) {
    // Check if display:none is near pm-use-points-wrapper
    preg_match('/pm-use-points-wrapper[^>]*style=["\'][^"\']*display:\s*none/', $content, $matches);
    if (!empty($matches)) {
        echo "⚠️ WARNING: pm-use-points-wrapper has display:none<br>";
    } else {
        echo "✅ pm-use-points-wrapper does NOT have display:none<br>";
    }
}

// Show relevant section
preg_match('/<!-- Use Points Checkbox -->.*?<\/label>/s', $content, $pointsSection);
if (!empty($pointsSection)) {
    echo "<hr><strong>Points Checkbox Section:</strong><pre>" . htmlspecialchars($pointsSection[0]) . "</pre>";
}

// Show git log
echo "<hr><strong>Last Git Commit:</strong><pre>";
passthru('cd ' . __DIR__ . '/.. && git log -1 --oneline 2>&1');
echo "</pre>";
?>
