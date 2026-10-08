<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Blog | Artikel Terbaru</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    {{-- ================= NAVBAR ================= --}}
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">

            {{-- Logo --}}
            <a href="{{ route('posts.index') }}"
               class="text-2xl font-bold tracking-tight text-slate-900">
                Blog<span class="text-blue-600">.</span>
            </a>

            {{-- Menu --}}
            <div class="flex items-center gap-6 text-sm font-medium">

                <a href="{{ route('posts.index') }}"
                   class="text-blue-600">
                    Beranda
                </a>

                @auth
                    @if (auth()->user()->is_admin)
                        <a href="/admin"
                           class="rounded-lg border border-blue-200 px-4 py-2.5 text-blue-700 transition hover:bg-blue-50">
                            Dashboard Admin
                        </a>
                    @endif

                    <a href="{{ route('posts.create') }}"
                       class="rounded-lg bg-blue-600 px-4 py-2.5 text-white transition hover:bg-blue-700">
                        + Buat Artikel
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                                class="text-slate-600 transition hover:text-red-600">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-lg border border-slate-300 px-4 py-2.5 text-slate-700 transition hover:bg-slate-100">
                        Login Admin
                    </a>
                @endauth

            </div>

        </div>
    </nav>


    {{-- ================= HERO ================= --}}
    <header class="bg-white">
        <div class="mx-auto max-w-7xl px-6 py-20">

            <div class="max-w-3xl">

                <p class="mb-4 text-sm font-semibold uppercase tracking-widest text-blue-600">
                    Selamat datang di Blog
                </p>

                <h1 class="text-4xl font-bold leading-tight tracking-tight text-slate-900 sm:text-5xl">
                    Temukan artikel,
                    <span class="text-blue-600">
                        ide, dan inspirasi.
                    </span>
                </h1>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-500">
                    Kumpulan tulisan dan informasi menarik seputar teknologi,
                    pemrograman, dan berbagai hal lainnya.
                </p>

            </div>

        </div>
    </header>


    {{-- ================= ARTIKEL ================= --}}
    <main class="mx-auto max-w-7xl px-6 py-16">

        {{-- Judul section --}}
        <div class="mb-10 flex items-end justify-between">

            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">
                    Blog
                </p>

                <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                    Artikel Terbaru
                </h2>
            </div>

            <p class="hidden text-sm text-slate-500 sm:block">
                Temukan tulisan terbaru kami
            </p>

        </div>


        {{-- Pesan berhasil --}}
        @if (session('success'))
            <div class="mb-8 rounded-lg border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- Jika ada artikel --}}
        @if ($posts->count())

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($posts as $post)

                    <article
                        class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                        {{-- Gambar --}}
                        <div class="aspect-video overflow-hidden bg-slate-100">

                            @if ($post->image)

                                <img
                                    src="{{ asset('storage/' . $post->image) }}"
                                    alt="{{ $post->title }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                            @else

                                <div class="flex h-full items-center justify-center bg-gradient-to-br from-blue-100 to-indigo-100">

                                    <span class="text-sm font-medium text-blue-500">
                                        Tidak ada gambar
                                    </span>

                                </div>

                            @endif

                        </div>


                        {{-- Isi card --}}
                        <div class="p-6">

                            {{-- Tanggal --}}
                            @if ($post->created_at)
                                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    {{ $post->created_at->format('d M Y') }}
                                </p>
                            @endif


                            {{-- Judul --}}
                            <h3 class="mt-3 text-xl font-bold leading-snug text-slate-900">

                                <a href="{{ route('posts.show', $post) }}"
                                   class="transition hover:text-blue-600">

                                    {{ $post->title }}

                                </a>

                            </h3>


                            {{-- Isi singkat --}}
                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-500">

                                {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}

                            </p>


                            {{-- Link --}}
                            <a href="{{ route('posts.show', $post) }}"
                               class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:gap-3">

                                Baca selengkapnya

                                <span aria-hidden="true">
                                    →
                                </span>

                            </a>

                            @auth
                                @if (auth()->user()->is_admin)
                                    <div class="mt-5 flex items-center gap-4 border-t border-slate-100 pt-4">
                                        <a href="{{ route('posts.edit', $post) }}"
                                           class="text-sm font-medium text-slate-600 hover:text-blue-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth


                        </div>

                    </article>

                @endforeach

            </div>

        @else

            {{-- Jika belum ada artikel --}}
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-20 text-center">

                <div class="mx-auto max-w-md">

                    <h3 class="text-2xl font-bold text-slate-900">
                        Belum ada artikel
                    </h3>

                    <p class="mt-3 text-slate-500">
                        Belum ada artikel yang dipublikasikan.
                    </p>

                    @auth

                        <a href="{{ route('posts.create') }}"
                           class="mt-6 inline-flex rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

                            + Buat Artikel Pertama

                        </a>

                    @endauth

                </div>

            </div>

        @endif

    </main>


    {{-- ================= FOOTER ================= --}}
    <footer class="border-t border-slate-200 bg-white">

        <div class="mx-auto max-w-7xl px-6 py-10">

            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">

                <div>

                    <p class="text-lg font-bold text-slate-900">
                        Blog<span class="text-blue-600">.</span>
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        Berbagi tulisan dan inspirasi.
                    </p>

                </div>

                <p class="text-sm text-slate-400">
                    © {{ date('Y') }} BLOG. RIFKY ADITYA .
                </p>

            </div>

        </div>

    </footer>

</body>
</html>
 
