<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempat Sampah | Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    {{-- NAVBAR --}}
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
            <a href="{{ route('posts.index') }}" class="text-2xl font-bold tracking-tight text-slate-900">
                Blog<span class="text-blue-600">.</span>
            </a>

            <div class="flex items-center gap-4 text-sm font-medium">
                <a href="{{ route('posts.index') }}" class="text-slate-600 transition hover:text-blue-600">
                    ← Kembali
                </a>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-6 py-16">
        <div class="mb-10">
            <p class="text-sm font-semibold uppercase tracking-widest text-red-600">Tempat Sampah</p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Artikel Terhapus</h2>
            <p class="mt-2 text-slate-500">Artikel yang dihapus bisa dipulihkan atau dihapus permanen.</p>
        </div>

        @if (session('success'))
            <div class="mb-8 rounded-lg border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($posts->count())
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="aspect-video overflow-hidden bg-slate-100">
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="h-full w-full object-cover opacity-50">
                            @else
                                <div class="flex h-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                    <span class="text-sm font-medium text-slate-400">Tidak ada gambar</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            @if ($post->deleted_at)
                                <p class="text-xs font-medium uppercase tracking-wide text-red-400">
                                    Dihapus {{ $post->deleted_at->diffForHumans() }}
                                </p>
                            @endif

                            <h3 class="mt-3 text-xl font-bold leading-snug text-slate-900">{{ $post->title }}</h3>
                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-500">
                                {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                            </p>

                            <div class="mt-5 flex items-center gap-3 border-t border-slate-100 pt-4">
                                <form action="{{ route('posts.restore', $post->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                                        Pulihkan
                                    </button>
                                </form>

                                <form action="{{ route('posts.force-delete', $post->id) }}" method="POST" 
                                      onsubmit="return confirm('Hapus permanen? Tindakan ini tidak dapat dibatalkan!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700">
                                        Hapus Permanen
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($posts->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @endif
        @else
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center">
                <div class="mx-auto max-w-md">
                    <h3 class="text-2xl font-bold text-slate-900">Tempat sampah kosong</h3>
                    <p class="mt-3 text-slate-500">Tidak ada artikel yang dihapus.</p>
                    <a href="{{ route('posts.index') }}" class="mt-6 inline-flex rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Kembali ke Artikel
                    </a>
                </div>
            </div>
        @endif
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto max-w-7xl px-6 py-8">
            <div class="flex flex-col items-center justify-between gap-3 sm:flex-row">
                <p class="text-sm text-slate-500">Blog<span class="text-blue-600">.</span></p>
                <p class="text-sm text-slate-400">© {{ date('Y') }} Blog. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
