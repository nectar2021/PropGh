<?php

namespace App\Http\Controllers;

use App\Http\Requests\LookupPropertyLocationRequest;
use App\Support\PropertyLocationResolver;
use Illuminate\Http\JsonResponse;

class PropertyLocationLookupController extends Controller
{
    public function __invoke(LookupPropertyLocationRequest $request, PropertyLocationResolver $propertyLocationResolver): JsonResponse
    {
        $location = $propertyLocationResolver->lookup(
            city: (string) $request->string('city')->trim(),
            region: $request->string('region')->trim()->toString(),
            country: $request->string('country')->trim()->toString(),
            address: $request->string('address')->trim()->toString(),
        );

        if ($location === null) {
            return response()->json([
                'message' => 'We could not find that location on the map.',
            ], 422);
        }

        return response()->json($location);
    }
}
