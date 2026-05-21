<?php
/**
 * Convert signature images to transparent PNG
 * Auto-detects actual file type regardless of extension
 * Removes white/near-white background pixels
 */

$dir   = __DIR__ . '/public/assets/img/ttd/';
$files = glob($dir . '*.*');

function removeWhiteBackground(string $inputPath, string $outputPath, int $threshold = 40): bool
{
    // Detect actual image type using getimagesize()
    $info = @getimagesize($inputPath);
    if (!$info) {
        echo "  ❌ Cannot read image info: $inputPath\n";
        return false;
    }

    $mimeType = $info['mime'];

    switch ($mimeType) {
        case 'image/jpeg':
            $src = imagecreatefromjpeg($inputPath);
            break;
        case 'image/png':
            $src = imagecreatefrompng($inputPath);
            break;
        case 'image/gif':
            $src = imagecreatefromgif($inputPath);
            break;
        default:
            echo "  ❌ Unsupported MIME type: $mimeType\n";
            return false;
    }

    if (!$src) {
        echo "  ❌ Failed to load image: $inputPath\n";
        return false;
    }

    $w = imagesx($src);
    $h = imagesy($src);

    // Create truecolor output image with alpha
    $dst = imagecreatetruecolor($w, $h);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);

    // Fill entirely with transparent first
    $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
    imagefill($dst, 0, 0, $transparent);

    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {
            $rgba  = imagecolorat($src, $x, $y);
            $alpha = ($rgba >> 24) & 0x7F; // 0=opaque, 127=transparent
            $r     = ($rgba >> 16) & 0xFF;
            $g     = ($rgba >> 8)  & 0xFF;
            $b     =  $rgba        & 0xFF;

            // Already transparent in source → keep transparent
            if ($alpha > 90) {
                imagesetpixel($dst, $x, $y, $transparent);
                continue;
            }

            // Check if pixel is white/near-white
            // White = R≈255, G≈255, B≈255 with all channels close together
            $minChannel = min($r, $g, $b);
            $maxChannel = max($r, $g, $b);
            $isWhitish  = $minChannel >= (255 - $threshold) && ($maxChannel - $minChannel) <= $threshold;

            if ($isWhitish) {
                // Make transparent
                imagesetpixel($dst, $x, $y, $transparent);
            } else {
                // Keep original pixel
                $newColor = imagecolorallocatealpha($dst, $r, $g, $b, 0);
                imagesetpixel($dst, $x, $y, $newColor);
            }
        }
    }

    $saved = imagepng($dst, $outputPath, 9);
    imagedestroy($src);
    imagedestroy($dst);

    return $saved;
}

echo "=== Converting TTD images to Transparent PNG ===\n\n";
echo "Detected files:\n";

foreach ($files as $file) {
    $basename = pathinfo($file, PATHINFO_FILENAME);
    $outPath  = $dir . $basename . '_transparent.png';

    $info = @getimagesize($file);
    $actualMime = $info ? $info['mime'] : 'unknown';

    echo "\nProcessing: " . basename($file) . " (actual type: $actualMime)\n";

    $ok = removeWhiteBackground($file, $outPath, threshold: 40);

    if ($ok) {
        // Overwrite the original .png with the transparent version
        $finalPath = $dir . $basename . '.png';
        rename($outPath, $finalPath);
        echo "  ✅ Saved: " . basename($finalPath) . "\n";
    }
}

echo "\n=== Done! ===\n";
