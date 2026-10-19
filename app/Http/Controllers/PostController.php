<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $query = Post::latest();

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Sort filter
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'title_asc':
                    $query->orderBy('title');
                    break;
                case 'title_desc':
                    $query->orderBy('title', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $posts = $query->paginate(9)->withQueryString();
        $trashedCount = Post::onlyTrashed()->count();
        $categories = \App\Models\Category::all();

        $featuredPosts = Post::where('created_at', '>=', now()->subDays(7))
            ->latest()
            ->limit(3)
            ->get();

        return view('posts.index', compact('posts', 'trashedCount', 'featuredPosts', 'categories'));
    }
    public function show(Post $post): \Illuminate\Contracts\View\View
    {
        return view('posts.show', compact('post'));
    }

    public function create(): \Illuminate\Contracts\View\View|string
    {
        $categories = \App\Models\Category::all();
        return view('posts.create', compact('categories'));
    }

    public function edit(Post $post): \Illuminate\Contracts\View\View
    {
        $categories = \App\Models\Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,' . $post->id, 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'content' => ['required', 'string', 'max:65535'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ], [
            'slug.regex' => 'Slug hanya boleh huruf kecil, angka, dan tanda hubung (-). Contoh: artikel-baru',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $post, $validated) {
            $oldImage = $post->image;
            $newImagePath = null;

            if ($request->hasFile('image')) {
                $newImagePath = $request->file('image')->store('posts', 'public');
                $validated['image'] = $newImagePath;
            } else {
                unset($validated['image']);
            }

            $post->update($validated);

            // Delete old image only after successful DB update
            if ($newImagePath && $oldImage) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldImage);
            }
        });

        return redirect()->route('posts.show', $post)->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Post $post): \Illuminate\Http\RedirectResponse
    {
        $post->delete(); // Soft delete - image kept for restore

        return redirect()->route('posts.index')->with('success', 'Artikel dipindahkan ke tempat sampah.');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'content' => ['required', 'string', 'max:65535'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ], [
            'slug.regex' => 'Slug hanya boleh huruf kecil, angka, dan tanda hubung (-). Contoh: artikel-baru',
        ]);

        $imagePath = $request->file('image')?->store('posts', 'public');

        Post::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'image' => $imagePath,
            'category_id' => $validated['category_id'] ?? null,
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Artikel berhasil dibuat.');
    }

    public function trashed(): \Illuminate\Contracts\View\View
    {
        $posts = Post::onlyTrashed()->latest('deleted_at')->paginate(9);

        return view('posts.trashed', compact('posts'));
    }

    public function restore(int $id): \Illuminate\Http\RedirectResponse
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.trashed')->with('success', 'Artikel berhasil dipulihkan.');
    }

    public function forceDelete(int $id): \Illuminate\Http\RedirectResponse
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        if ($post->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($post->image);
        }

        $post->forceDelete();

        return redirect()->route('posts.trashed')->with('success', 'Artikel dihapus permanen.');
    }
}
