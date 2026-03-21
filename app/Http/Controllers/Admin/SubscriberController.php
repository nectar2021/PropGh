<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriberController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $subscribers = Subscriber::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where('email', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.subscribers.index', [
            'subscribers' => $subscribers,
            'search' => $search,
        ]);
    }

    public function destroy(Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return redirect()
            ->route('admin.subscribers.index')
            ->with('status', 'Subscriber removed.');
    }
}
