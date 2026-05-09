<?php

namespace App\Support;

use App\Models\Property;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyImageUploader
{
    private const MAX_WIDTH = 1600;

    private const MAX_HEIGHT = 1200;

    private const JPEG_QUALITY = 82;

    private const PNG_COMPRESSION = 7;

    private const WEBP_QUALITY = 82;

    /**
     * @param  array<int, UploadedFile>  $uploadedImages
     */
    public function store(Property $property, array $uploadedImages, bool $replaceExisting = false): void
    {
        if ($uploadedImages === []) {
            return;
        }

        if ($replaceExisting) {
            $this->deleteManagedImages($property);
            $property->images()->delete();
        }

        $maxSortOrder = $property->images()->max('sort_order');
        $sortOffset = $maxSortOrder === null ? 0 : ((int) $maxSortOrder + 1);
        $hasCover = $property->images()->where('is_cover', true)->exists();

        foreach ($uploadedImages as $index => $uploadedImage) {
            $storedPath = $this->storeUploadedImage($property, $uploadedImage);

            $property->images()->create([
                'path' => 'storage/'.$storedPath,
                'is_cover' => ! $hasCover && $index === 0,
                'sort_order' => $sortOffset + $index,
            ]);
        }
    }

    public function deleteManagedImages(Property $property): void
    {
        $property->loadMissing('images');

        foreach ($property->images as $image) {
            if (! str_starts_with($image->path, 'storage/properties/')) {
                continue;
            }

            Storage::disk('public')->delete(Str::after($image->path, 'storage/'));
        }
    }

    private function storeUploadedImage(Property $property, UploadedFile $uploadedImage): string
    {
        $directory = 'properties/'.$property->id;

        if (! $this->gdIsAvailable()) {
            return $uploadedImage->store($directory, 'public');
        }

        $normalizedImage = $this->createNormalizedImage($uploadedImage);

        if ($normalizedImage === null) {
            return $uploadedImage->store($directory, 'public');
        }

        $relativePath = $directory.'/'.Str::ulid().'.'.$normalizedImage['extension'];

        if (! Storage::disk('public')->put($relativePath, $normalizedImage['contents'])) {
            return $uploadedImage->store($directory, 'public');
        }

        return $relativePath;
    }

    private function gdIsAvailable(): bool
    {
        return function_exists('gd_info')
            && function_exists('imagecreatetruecolor')
            && function_exists('imagecopyresampled');
    }

    /**
     * @return array{contents:string, extension:string}|null
     */
    private function createNormalizedImage(UploadedFile $uploadedImage): ?array
    {
        $mime = (string) $uploadedImage->getMimeType();
        $sourceImage = $this->createImageResource($uploadedImage, $mime);

        if (! $sourceImage instanceof \GdImage) {
            return null;
        }

        $sourceImage = $this->normalizeOrientation($uploadedImage, $mime, $sourceImage);

        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);
        [$targetWidth, $targetHeight] = $this->targetDimensions($sourceWidth, $sourceHeight);
        $destinationImage = imagecreatetruecolor($targetWidth, $targetHeight);

        if (! $destinationImage instanceof \GdImage) {
            imagedestroy($sourceImage);

            return null;
        }

        $this->prepareCanvas($destinationImage, $mime);

        imagecopyresampled(
            $destinationImage,
            $sourceImage,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $sourceWidth,
            $sourceHeight,
        );

        $contents = $this->encodeImage($destinationImage, $mime);

        imagedestroy($sourceImage);
        imagedestroy($destinationImage);

        if ($contents === null) {
            return null;
        }

        return [
            'contents' => $contents,
            'extension' => $this->extensionForMime($mime),
        ];
    }

    private function createImageResource(UploadedFile $uploadedImage, string $mime): \GdImage|false
    {
        return match ($mime) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($uploadedImage->getRealPath()),
            'image/png' => imagecreatefrompng($uploadedImage->getRealPath()),
            'image/gif' => imagecreatefromgif($uploadedImage->getRealPath()),
            'image/webp' => function_exists('imagecreatefromwebp')
                ? imagecreatefromwebp($uploadedImage->getRealPath())
                : false,
            default => false,
        };
    }

    private function normalizeOrientation(UploadedFile $uploadedImage, string $mime, \GdImage $sourceImage): \GdImage
    {
        if ($mime !== 'image/jpeg' || ! function_exists('exif_read_data')) {
            return $sourceImage;
        }

        $exif = @exif_read_data($uploadedImage->getRealPath());
        $orientation = $exif['Orientation'] ?? null;

        $rotatedImage = match ($orientation) {
            3 => imagerotate($sourceImage, 180, 0),
            6 => imagerotate($sourceImage, -90, 0),
            8 => imagerotate($sourceImage, 90, 0),
            default => $sourceImage,
        };

        if ($rotatedImage instanceof \GdImage && $rotatedImage !== $sourceImage) {
            imagedestroy($sourceImage);

            return $rotatedImage;
        }

        return $sourceImage;
    }

    /**
     * @return array{0:int, 1:int}
     */
    private function targetDimensions(int $width, int $height): array
    {
        $scale = min(
            self::MAX_WIDTH / max($width, 1),
            self::MAX_HEIGHT / max($height, 1),
            1,
        );

        return [
            max(1, (int) round($width * $scale)),
            max(1, (int) round($height * $scale)),
        ];
    }

    private function prepareCanvas(\GdImage $destinationImage, string $mime): void
    {
        if (! in_array($mime, ['image/png', 'image/webp', 'image/gif'], true)) {
            return;
        }

        imagealphablending($destinationImage, false);
        imagesavealpha($destinationImage, true);

        $transparent = imagecolorallocatealpha($destinationImage, 0, 0, 0, 127);
        imagefill($destinationImage, 0, 0, $transparent);
    }

    private function encodeImage(\GdImage $image, string $mime): ?string
    {
        ob_start();

        $encoded = match ($mime) {
            'image/jpeg', 'image/jpg' => imagejpeg($image, null, self::JPEG_QUALITY),
            'image/png' => imagepng($image, null, self::PNG_COMPRESSION),
            'image/gif' => imagegif($image),
            'image/webp' => function_exists('imagewebp')
                ? imagewebp($image, null, self::WEBP_QUALITY)
                : false,
            default => false,
        };

        $contents = ob_get_clean();

        if ($encoded === false || ! is_string($contents)) {
            return null;
        }

        return $contents;
    }

    private function extensionForMime(string $mime): string
    {
        return match ($mime) {
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            default => 'jpg',
        };
    }
}
