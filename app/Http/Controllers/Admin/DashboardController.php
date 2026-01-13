<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProperties = Property::count();
        $liveProperties = Property::where('status', 'live')->count();
        $draftProperties = Property::where('status', 'draft')->count();
        $reviewProperties = Property::where('status', 'review')->count();
        $newThisWeek = Property::where('created_at', '>=', now()->subDays(7))->count();
        $totalViews = (int) Property::sum('views');
        $featuredCount = Property::where('is_featured', true)->count();
        $averagePrice = (int) Property::avg('price');

        $recentProperties = Property::with('owner')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'totalProperties' => $totalProperties,
            'liveProperties' => $liveProperties,
            'draftProperties' => $draftProperties,
            'reviewProperties' => $reviewProperties,
            'newThisWeek' => $newThisWeek,
            'totalViews' => $totalViews,
            'featuredCount' => $featuredCount,
            'averagePrice' => $averagePrice,
            'recentProperties' => $recentProperties,
        ]);
    }
}
