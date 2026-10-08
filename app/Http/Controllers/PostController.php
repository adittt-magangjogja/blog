<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $posts = Post::latest()->get();

        return view('posts.index', compact('posts'));
    }
    public function show(Post $post): \Illuminate\Contracts\View\View
    {
        return view('posts.show', compact('post'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        return view('posts.create');
    }

    public function edit(Post $post): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): \Illuminate\Http\RedirectResponse
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,' . $post->id],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        } else {
            unset($validated['image']);
        }

        $post->update($validated);

        return redirect('/posts/' . $post->id)->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Post $post): \Illuminate\Http\RedirectResponse
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        $post->delete();

        return redirect('/posts')->with('success', 'Artikel berhasil dihapus.');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $imagePath = $request->file('image')?->store('posts', 'public');

        Post::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }
}
