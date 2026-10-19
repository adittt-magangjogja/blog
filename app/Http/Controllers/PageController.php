<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $users = \App\Models\User::orderBy('id')->get();

        return view('about', [
            'users' => $users,
            'totalUsers' => $users->count(),
            'adminCount' => $users->where('is_admin', true)->count(),
            'userCount' => $users->where('is_admin', false)->count(),
        ]);
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function sendContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact')
            ->with('success', 'Pesan berhasil dikirim. Kami akan merespons dalam 1x24 jam.');
    }
}
