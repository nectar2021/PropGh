<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyInquiryController extends Controller
{
    public function index(Request $request): View
    {
        $query = PropertyInquiry::with('property')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('property', function ($pq) use ($search): void {
                        $pq->where('title', 'like', "%{$search}%");
                    });
            });
        }

        $inquiries = $query->paginate(20)->withQueryString();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function destroy(PropertyInquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();

        return back()->with('status', 'Inquiry removed.');
    }
}
