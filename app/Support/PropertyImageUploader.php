<?php

namespace App\Support;

use App\Models\Property;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PropertyImageUploader
{
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
            $storedPath = $uploadedImage->store('properties/'.$property->id, 'public');

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
}
