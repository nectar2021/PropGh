<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'client');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $clients = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.clients.index', compact('clients'));
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->role !== 'client') {
            abort(404);
        }

        $user->delete();

        return back()->with('status', "Client \"{$user->name}\" has been removed.");
    }
}
