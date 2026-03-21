<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PropertyInquiryController extends Controller
{
    public function storeTour(Request $request, Property $property): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'tour_date' => ['required', 'date', 'after_or_equal:today'],
            'tour_time' => ['required', 'string', 'max:20'],
            'tour_type' => ['required', 'in:in-person,video'],
        ]);

        PropertyInquiry::create([
            'property_id' => $property->id,
            'type' => 'tour',
            ...$data,
        ]);

        return back()->with('inquiry_success', 'Tour request sent! The agent will contact you shortly.');
    }

    public function storeMessage(Request $request, Property $property): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        PropertyInquiry::create([
            'property_id' => $property->id,
            'type' => 'message',
            ...$data,
        ]);

        return back()->with('inquiry_success', 'Message sent! The agent will get back to you soon.');
    }
}
