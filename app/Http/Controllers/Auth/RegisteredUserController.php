<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'account_type' => ['required', 'in:client,agent'],
            'company_name' => ['nullable', 'required_if:account_type,agent', 'string', 'max:255'],
        ]);

        $role = $validated['account_type'];

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'is_admin' => false,
            'is_verified' => false,
            'company_name' => $role === 'agent' ? $validated['company_name'] : null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        if ($role === 'agent') {
            return redirect()->intended('/')->with('status', 'Your agent account has been created. It will be reviewed and verified by our team shortly.');
        }

        return redirect()->intended('/');
    }
}
