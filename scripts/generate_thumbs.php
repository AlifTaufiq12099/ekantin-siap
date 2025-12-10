<?php

// Pure PHP (GD) thumbnail generator to avoid Intervention dependency in CLI

$dir = __DIR__ . '/../storage/app/public/menus';

if (!is_dir($dir)) {
    echo "Folder not found: $dir\n";
    exit(1);
}

$files = scandir($dir);
$count = 0;
foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    $path = $dir . DIRECTORY_SEPARATOR . $file;
    if (!is_file($path)) continue;
    if (stripos($file, 'thumb_') === 0) continue;

    $info = @getimagesize($path);
    if ($info === false) continue;
    $mime = $info['mime'];

    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $thumbName = 'thumb_' . $file;
    $thumbPath = $dir . DIRECTORY_SEPARATOR . $thumbName;
    if (file_exists($thumbPath)) continue;

    list($width, $height) = [$info[0], $info[1]];
    $newW = 300;
    $newH = intval(($newW / $width) * $height);

    // create source image
    $src = null;
    switch ($mime) {
        case 'image/jpeg':
        case 'image/jpg':
            $src = imagecreatefromjpeg($path);
            break;
        case 'image/png':
            $src = imagecreatefrompng($path);
            break;
        case 'image/gif':
            $src = imagecreatefromgif($path);
            break;
        case 'image/webp':
            if (function_exists('imagecreatefromwebp')) $src = imagecreatefromwebp($path);
            break;
        default:
            $src = null;
    }
    if (!$src) {
        echo "Skipping unsupported image: $file\n";
        continue;
    }

    $dst = imagecreatetruecolor($newW, $newH);
    // preserve transparency for png/gif
    if (in_array($mime, ['image/png','image/gif'])) {
        imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
    }

    imagecopyresampled($dst, $src, 0,0,0,0, $newW, $newH, $width, $height);

    // save thumb according to type
    $saved = false;
    switch ($mime) {
        case 'image/jpeg':
        case 'image/jpg':
            $saved = imagejpeg($dst, $thumbPath, 80);
            break;
        case 'image/png':
            // PNG quality: 0 (no compression) - 9
            $saved = imagepng($dst, $thumbPath, 6);
            break;
        case 'image/gif':
            $saved = imagegif($dst, $thumbPath);
            break;
        case 'image/webp':
            if (function_exists('imagewebp')) $saved = imagewebp($dst, $thumbPath, 80);
            break;
    }

    imagedestroy($src);
    imagedestroy($dst);

    if ($saved) {
        echo "Created thumbnail: $thumbName\n";
        $count++;
    } else {
        echo "Failed to save thumbnail for: $file\n";
    }
}

echo "Done. Thumbnails created: $count\n";
