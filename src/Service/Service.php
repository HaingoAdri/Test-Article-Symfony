<?php
namespace App\Service;

class Service
{
    public function compressImage(string $inputPath, string $outputPath, int $maxWidth, int $maxHeight, int $quality = 75): bool
    {
        $imageType = exif_imagetype($inputPath);

        if ($imageType === IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($inputPath);
        } elseif ($imageType === IMAGETYPE_PNG) {
            $image = imagecreatefrompng($inputPath);
        } elseif ($imageType === IMAGETYPE_GIF) {
            $image = imagecreatefromgif($inputPath);
        } else {
            throw new \Exception("Unsupported image type");
        }

        // Redimensionnement
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
            $image = imagescale($image, $maxWidth, $maxHeight, IMG_BICUBIC);
        }

        // Compression et sauvegarde
        if ($imageType === IMAGETYPE_JPEG) {
            imagejpeg($image, $outputPath, $quality);
        } elseif ($imageType === IMAGETYPE_PNG) {
            imagepng($image, $outputPath, 6);
        } elseif ($imageType === IMAGETYPE_GIF) {
            imagegif($image, $outputPath);
        }

        imagedestroy($image);  // Libérer les ressources

        return true;
    }
}
