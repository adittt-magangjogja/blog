<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;
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

        try {
            Mail::to('aditltsh1992@gmail.com')->send(new ContactFormMail($validated));
        } catch (\Exception $e) {
            // Log or ignore mail transport error in local dev
        }

        return redirect()->route('contact')
            ->with('success', 'Pesan berhasil dikirim. Kami akan merespons dalam 1x24 jam.');
    }
}
