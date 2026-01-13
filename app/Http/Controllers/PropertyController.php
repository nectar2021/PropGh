<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PropertyController extends Controller
{
    public function index(Request $request): Response
    {
        $properties = Property::query()
            ->with(['images' => fn ($query) => $query->orderBy('sort_order')])
            ->where('status', 'live')
            ->where('visibility', 'public')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        return response()->view('properties.index', [
            'properties' => $properties,
        ]);
    }

    public function show(Property $property): Response
    {
        $property->load(['images' => fn ($query) => $query->orderBy('sort_order'), 'owner']);

        if (! $this->canPreview($property)) {
            abort(404);
        }

        $property->increment('views');

        return response()->view('properties.show', [
            'property' => $property,
        ]);
    }

    public function map(Request $request): JsonResponse
    {
        $properties = Property::query()
            ->with(['images' => fn ($query) => $query->orderBy('sort_order')])
            ->where('status', 'live')
            ->where('visibility', 'public')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        $markers = $properties->map(function (Property $property): array {
            $imagePath = $property->cover_image?->path ?? 'assets/img/listings/real-estate/01.jpg';

            $addressParts = array_filter([
                $property->address,
                $property->city,
                $property->region,
            ]);

            $address = $addressParts ? implode(', ', $addressParts) : $property->title;

            return [
                'coordinates' => [
                    'lat' => (float) $property->latitude,
                    'lng' => (float) $property->longitude,
                ],
                'price' => '$' . number_format((float) $property->price),
                'address' => $address,
                'area' => (string) ($property->area ?? 0),
                'bedrooms' => (string) ($property->bedrooms ?? 0),
                'bathrooms' => (string) ($property->bathrooms ?? 0),
                'garage' => (string) ($property->garage_spaces ?? 0),
                'image' => asset($imagePath),
            ];
        })->values();

        return response()->json($markers);
    }

    private function canPreview(Property $property): bool
    {
        if ($property->status === 'live' && $property->visibility === 'public') {
            return true;
        }

        $user = auth()->user();
        return $user && $user->role === 'admin';
    }
}
