<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FirstAdminController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('posts.index');
        }

        if (User::query()->exists()) {
            return redirect()->route('login');
        }

        return view('auth.first-admin');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('posts.index');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
        ]);

        $user = Cache::lock('first-admin-registration', 10)->block(5, function () use ($validated): ?User {
            if (User::query()->exists()) {
                return null;
            }

            $user = User::query()->create($validated);
            $user->forceFill(['is_admin' => true])->save();

            return $user;
        });

        if (! $user) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Akun admin pertama sudah dibuat. Silakan masuk.']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('posts.index');
    }
}
