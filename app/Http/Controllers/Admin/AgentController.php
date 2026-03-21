<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'agent');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_verified', $request->input('status') === 'verified');
        }

        $agents = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.agents.index', compact('agents'));
    }

    public function verify(User $user): RedirectResponse
    {
        if ($user->role !== 'agent') {
            abort(404);
        }

        $user->update(['is_verified' => true]);

        return back()->with('status', "{$user->name} has been verified as an agent.");
    }

    public function unverify(User $user): RedirectResponse
    {
        if ($user->role !== 'agent') {
            abort(404);
        }

        $user->update(['is_verified' => false]);

        return back()->with('status', "{$user->name}'s verification has been revoked.");
    }
}
