<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blog teknologi dan pemrograman. Kumpulan artikel, tutorial, dan inspirasi seputar coding dan web development.">
    <meta name="theme-color" content="#2563eb">

    <title>Blog | Artikel Terbaru</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body, html {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
    </style>

    <style>
        @layer base {
            *, ::after, ::before {
                border-color: var(--color-slate-200);
            }
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    {{-- ================= NAVBAR ================= --}}
    <nav class="sticky top-0 z-20 border-b border-slate-200 bg-white h-16">
        <div class="mx-auto flex max-w-6xl items-center justify-between h-full px-4 sm:px-6">

            {{-- Logo --}}
            <a href="{{ route('posts.index') }}"
               class="text-2xl font-bold tracking-tight text-slate-900 shrink-0">
                Blog<span class="text-slate-900">.</span>
            </a>

            {{-- Mobile menu toggle --}}
            <button id="mobileMenuToggle" class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg text-slate-600 hover:bg-slate-100 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            {{-- Menu Desktop & Mobile --}}
            <div id="navMenu" class="hidden md:flex! absolute md:relative top-16 md:top-auto left-0 right-0 md:left-auto md:right-auto flex-col md:flex-row bg-white md:bg-transparent border-b md:border-b-0 md:items-center gap-0 text-base font-medium p-4 md:p-0">

                <a href="{{ route('posts.index') }}"
                   class="px-4 py-2 {{ request()->is('posts') || request()->is('/') ? 'text-slate-900 border-b-2 border-slate-900' : 'text-slate-600 transition hover:text-slate-900' }}">
                    Beranda
                </a>

                <a href="{{ route('about') }}"
                   class="px-4 py-2 {{ request()->is('about') ? 'text-slate-900 border-b-2 border-slate-900' : 'text-slate-600 transition hover:text-slate-900' }}">
                    Tentang
                </a>

                <a href="{{ route('contact') }}"
                   class="px-4 py-2 {{ request()->is('contact') ? 'text-slate-900 border-b-2 border-slate-900' : 'text-slate-600 transition hover:text-slate-900' }}">
                    Kontak
                </a>

                @auth
                    @if (auth()->user()->is_admin)
                        <a href="/admin"
                           class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-900 transition hover:bg-slate-50">
                            Dashboard
                        </a>

                        @if(isset($trashedCount) && $trashedCount > 0)
                            <a href="{{ route('posts.trashed') }}"
                               class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                🗑️ ({{ $trashedCount }})
                            </a>
                        @endif

                        <a href="{{ route('posts.create') }}"
                           class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-85">
                            + Artikel
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                                class="px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:text-slate-900">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-900 transition hover:bg-slate-50">
                        Login
                    </a>
                @endauth

            </div>

        </div>
    </nav>


    {{-- ================= HERO ================= --}}
    <header class="relative overflow-hidden pb-12 sm:pb-24" style="background: #FFFFFF;">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 py-8 sm:py-20 relative z-10">
            <div class="flex flex-col items-center text-center">
                <div class="max-w-2xl">
                    <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-slate-300 bg-slate-50 px-3 py-1 text-sm font-medium uppercase tracking-widest text-slate-600">
                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-slate-900"></span>
                        Selamat datang
                    </p>

                    <h1 class="mt-4 text-3xl font-bold leading-tight tracking-tight text-slate-900 sm:mt-6 sm:text-5xl">
                        Temukan artikel,
                        <span class="text-slate-900">
                            ide, dan inspirasi.
                        </span>
                    </h1>

                    <p class="mt-4 mb-5 text-base leading-7 text-slate-600 sm:mt-6 sm:mb-6 sm:text-lg">
                        Kumpulan tulisan menarik dari berbagai topik, perspektif, dan pengalaman.
                    </p>

                    {{-- CATEGORY CHIPS --}}
                    <div class="mt-6 mb-4 flex flex-wrap items-center justify-center gap-2 pb-2 sm:mt-10 sm:mb-6">
                        <span class="w-full text-center text-sm font-medium text-slate-600 sm:w-auto">Populer:</span>
                        @foreach ($categories as $cat)
                            @php
                                $aktif = request('category') === $cat->slug;
                                $warna = $cat->color;
                            @endphp
                            <a href="{{ route('posts.index', ['category' => $cat->slug]) }}"
                               class="inline-flex min-h-11 items-center px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap transition border"
                               @style([
                                   'background-color' => $aktif ? $warna . '20' : '#F5F5F5',
                                   'color' => $aktif ? $warna : '#666666',
                                   'border-color' => $aktif ? $warna : '#E0E0E0',
                               ])>
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>

                    {{-- BUTTONS --}}
                    <div class="mt-6 mb-4 flex flex-wrap gap-3 justify-center sm:mt-10 sm:mb-8">
                        <a href="#artikel" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-6 py-3 text-base font-medium text-white transition hover:opacity-85">
                            Mulai Baca
                            <span aria-hidden="true">→</span>
                        </a>

                        @auth
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('posts.create') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-6 py-3 text-base font-medium text-slate-900 transition hover:bg-slate-50">
                                    + Tulis Artikel
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                {{-- STATS COUNTER (1 BARIS KECIL) --}}
                <div class="mt-8 flex w-full max-w-3xl justify-center sm:mt-16">
                    <div class="flex-1 text-center">
                        <p class="text-3xl font-bold text-slate-900">{{ $posts->total() }}</p>
                        <p class="mt-2 text-sm font-medium text-slate-600">Total Artikel</p>
                    </div>
                    <div class="border-l border-slate-300"></div>
                    <div class="flex-1 text-center">
                        <p class="text-3xl font-bold text-slate-900">{{ \App\Models\Post::where('created_at', '>=', now()->subDays(7))->count() }}</p>
                        <p class="mt-2 text-sm font-medium text-slate-600">Minggu Ini</p>
                    </div>
                    <div class="border-l border-slate-300"></div>
                    <div class="flex-1 text-center">
                        <p class="text-3xl font-bold text-slate-900">{{ \App\Models\User::count() }}</p>
                        <p class="mt-2 text-sm font-medium text-slate-600">Pembaca</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- WAVE SVG (absolute, behind content) --}}
        <svg class="absolute bottom-0 left-0 w-full pointer-events-none" viewBox="0 0 1200 80" preserveAspectRatio="none" style="height: 80px; z-index: 0;">
            <path d="M0,40 Q300,10 600,40 T1200,40 L1200,80 L0,80 Z" fill="white" fill-opacity="1"></path>
        </svg>
    </header>


    {{-- ================= FEATURED POSTS ================= --}}
    @if ($featuredPosts->count())
        <section class="mx-auto max-w-6xl px-4 sm:px-6 pt-8 sm:pt-12">
            <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <p class="text-sm font-medium uppercase tracking-widest text-slate-600">Unggulan</p>
                    <h2 class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                        Artikel populer minggu ini
                    </h2>
                </div>
                <a href="{{ route('posts.index') }}" class="min-h-11 inline-flex items-center text-sm font-medium text-slate-900 transition hover:text-slate-600">
                    Lihat semua →
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($featuredPosts as $post)
                    <a href="{{ route('posts.show', $post) }}"
                       class="group overflow-hidden rounded-lg border border-slate-200 bg-white transition duration-300 hover:border-slate-300">

                        <div class="aspect-video w-full overflow-hidden bg-slate-100">
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}"
                                     alt="{{ $post->title }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center bg-slate-100">
                                    <span class="text-sm font-medium text-slate-500">Tidak ada gambar</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <span class="text-sm font-medium uppercase tracking-wide text-slate-600">
                                {{ $post->created_at->format('d M Y') }}
                            </span>
                            <h3 class="mt-2 line-clamp-2 text-lg font-bold leading-snug text-slate-900 group-hover:text-slate-600">
                                {{ $post->title }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ================= ARTIKEL ================= --}}
    <main class="mx-auto max-w-6xl px-4 sm:px-6 py-10 sm:py-16">

        {{-- Judul section --}}
        <div id="artikel" class="mb-10 flex flex-col gap-4 rounded-lg border border-slate-200 bg-white p-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-widest text-slate-600">
                    Blog
                </p>

                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Artikel Terbaru
                </h2>
            </div>

            <p class="text-sm text-slate-600">
                @if ($posts->count())
                    Menampilkan {{ $posts->firstItem() ?? 0 }} - {{ $posts->lastItem() ?? 0 }} dari {{ $posts->total() }} artikel
                @else
                    Belum ada artikel
                @endif
            </p>
        </div>


        {{-- Pesan berhasil --}}
        @if (session('success'))
            <div class="mb-8 rounded-lg border border-slate-300 bg-slate-50 px-5 py-4 text-sm text-slate-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- ================= SEARCH & FILTER BAR ================= --}}
        <form method="GET" action="{{ route('posts.index') }}" class="mb-8 flex flex-col gap-4 rounded-lg border border-slate-200 bg-white p-6 sm:flex-row sm:items-end">
            <style>
                select {
                    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23666666' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 14l-7 7m0 0l-7-7m7 7V3'%3E%3C/path%3E%3C/svg%3E");
                    background-repeat: no-repeat;
                    background-position: right 8px center;
                    background-size: 18px;
                    padding-right: 32px;
                }
            </style>

            <div class="relative flex-1">
                <label class="mb-2 block text-sm font-medium text-slate-700">Cari Artikel</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Judul atau isi..."
                    class="w-full rounded-lg border border-slate-300 bg-white py-3 px-4 text-base text-slate-900 placeholder-slate-500 transition focus:border-slate-900 focus:ring-2 focus:ring-slate-200 focus:outline-none">
            </div>

            <div class="relative">
                <label class="mb-2 block text-sm font-medium text-slate-700">Kategori</label>
                <select name="category" class="w-full appearance-none rounded-lg border border-slate-300 bg-white py-3 px-4 text-base text-slate-900 transition focus:border-slate-900 focus:ring-2 focus:ring-slate-200 focus:outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="relative">
                <label class="mb-2 block text-sm font-medium text-slate-700">Urutkan</label>
                <select name="sort" class="w-full appearance-none rounded-lg border border-slate-300 bg-white py-3 px-4 text-base text-slate-900 transition focus:border-slate-900 focus:ring-2 focus:ring-slate-200 focus:outline-none">
                    <option value="">Terbaru</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>Judul A-Z</option>
                    <option value="title_desc" {{ request('sort') === 'title_desc' ? 'selected' : '' }}>Judul Z-A</option>
                </select>
            </div>

            <button type="submit" class="rounded-lg bg-slate-900 px-6 py-3 text-base font-medium text-white transition hover:opacity-85">
                Cari
            </button>

            @if (request('search') || request('sort') || request('category'))
                <a href="{{ route('posts.index') }}" class="rounded-lg border border-slate-300 bg-white px-6 py-3 text-base font-medium text-slate-900 transition hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>

        {{-- Result info saat search aktif --}}
        @if (request('search'))
            <div class="mb-6 text-sm text-slate-600">
                Hasil pencarian untuk "<span class="font-medium text-slate-900">{{ request('search') }}</span>" — {{ $posts->total() }} artikel ditemukan
            </div>
        @endif


        {{-- Jika ada artikel --}}
        @if ($posts->count())

            <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

                @foreach ($posts as $post)

                    <article
                        class="group flex flex-col overflow-hidden rounded-lg border border-slate-200 bg-white transition duration-300 hover:border-slate-300">

                        {{-- Gambar & Badge Kategori --}}
                        <div class="relative aspect-video w-full overflow-hidden bg-slate-100">
                            @if ($post->image)
                                <img
                                    src="{{ asset('storage/' . $post->image) }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center bg-slate-100">
                                    <span class="text-sm font-medium text-slate-500">
                                        Tidak ada gambar
                                    </span>
                                </div>
                            @endif

                            {{-- Category Badge on Top-Left --}}
                            <div class="absolute top-3 left-3 z-10">
                                @if ($post->category)
                                    @php
                                        $catColor = $post->category->color ?? '#2563EB';
                                        $isLight = in_array(strtolower($catColor), ['#f59e0b', '#fcd34d', '#fbbf24', '#fde047', '#facc15', '#fef08a', '#ffeb3b']);
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold shadow-sm"
                                          @style([
                                              'background-color' => $catColor,
                                              'color' => $isLight ? '#1F2937' : '#FFFFFF',
                                          ])>
                                        {{ $post->category->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-slate-800 px-3 py-1 text-xs font-bold text-white shadow-sm">
                                        Umum
                                    </span>
                                @endif
                            </div>
                        </div>


                        {{-- Isi card --}}
                        <div class="flex flex-1 flex-col p-6">

                            {{-- Meta (Tanggal & Penulis) --}}
                            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500 mb-3">
                                @if ($post->created_at)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>{{ $post->created_at->locale('id')->translatedFormat('j M Y') }}</span>
                                    </div>
                                @endif

                                @if (isset($post->user) && $post->user)
                                    <span class="text-slate-300">•</span>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span>{{ $post->user->name }}</span>
                                    </div>
                                @endif
                            </div>


                            {{-- Judul --}}
                            <h3 class="text-lg font-bold leading-snug text-slate-900 group-hover:text-blue-600 transition">
                                <a href="{{ route('posts.show', $post) }}" class="line-clamp-2">
                                    {{ $post->title }}
                                </a>
                            </h3>


                            {{-- Isi singkat --}}
                            <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-slate-600">
                                {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                            </p>


                            {{-- Footer Card (Mnt baca & Link) --}}
                            <div class="mt-auto pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-sm">
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ max(1, ceil(str_word_count(strip_tags($post->content)) / 200)) }} mnt baca</span>
                                </div>

                                <a href="{{ route('posts.show', $post) }}"
                                   class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 transition hover:gap-2">
                                    <span>Baca selengkapnya</span>
                                    <span aria-hidden="true">→</span>
                                </a>
                            </div>

                            @auth
                                @if (auth()->user()->is_admin)
                                    <div class="mt-3 flex items-center gap-3 border-t border-slate-100 pt-3 text-xs">
                                        <a href="{{ route('posts.edit', $post) }}"
                                           class="font-medium text-slate-600 transition hover:text-slate-900">
                                            Edit
                                        </a>

                                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 transition hover:text-red-800">
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
            <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-16 text-center sm:py-24">

                <div class="mx-auto max-w-sm">

                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                        <svg class="h-8 w-8 text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-slate-900">
                        Belum ada artikel
                    </h3>

                    <p class="mt-2 text-slate-600">
                        Belum ada artikel yang dipublikasikan. Kembali lagi nanti atau buat artikel pertama.
                    </p>

                    @auth
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('posts.create') }}"
                               class="mt-6 inline-flex items-center gap-2 rounded-lg bg-slate-900 px-6 py-3 text-base font-medium text-white transition hover:opacity-85">
                                + Buat Artikel Pertama
                            </a>
                        @endif
                    @endauth

                </div>

            </div>

        @endif

        {{-- PAGINATION --}}
        @if ($posts->hasPages())
            <div class="mt-12 flex justify-center">
                <nav class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white p-2">
                    {{-- Previous --}}
                    @if ($posts->onFirstPage())
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg text-slate-400">
                            <span aria-hidden="true">‹</span>
                        </span>
                    @else
                        <a href="{{ $posts->previousPageUrl() }}"
                           class="flex h-10 w-10 items-center justify-center rounded-lg text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                            <span aria-hidden="true">‹</span>
                        </a>
                    @endif

                    {{-- Page numbers --}}
                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-900 text-sm font-medium text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($posts->hasMorePages())
                        <a href="{{ $posts->nextPageUrl() }}"
                           class="flex h-10 w-10 items-center justify-center rounded-lg text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                            <span aria-hidden="true">›</span>
                        </a>
                    @else
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg text-slate-400">
                            <span aria-hidden="true">›</span>
                        </span>
                    @endif
                </nav>
            </div>
        @endif

    </main>


    {{-- ================= FOOTER ================= --}}
    <footer class="bg-slate-900 text-slate-300">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 py-16 sm:py-20">

            <div class="grid gap-8 sm:gap-12 grid-cols-1 md:grid-cols-2 lg:grid-cols-4">

                {{-- Brand Column --}}
                <div>
                    <div class="flex items-center gap-1 mb-4">
                        <p class="text-2xl font-bold text-white">
                            Blog<span class="text-slate-400">.</span>
                        </p>
                    </div>
                    <p class="text-sm leading-6 text-slate-400 mb-6">
                        Berbagi tulisan, ide, dan pengalaman dari berbagai topik.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-800 text-slate-300 transition hover:text-white hover:bg-slate-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                        </a>
                        <a href="#" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-800 text-slate-300 transition hover:text-white hover:bg-slate-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Menu Column --}}
                <div>
                    <h4 class="text-sm font-medium text-white mb-4">Menu</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('posts.index') }}" class="text-sm text-slate-400 transition hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('about') }}" class="text-sm text-slate-400 transition hover:text-white">Tentang</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm text-slate-400 transition hover:text-white">Kontak</a></li>
                    </ul>
                </div>

                {{-- Kategori Column --}}
                <div>
                    <h4 class="text-sm font-medium text-white mb-4">Kategori</h4>
                    <ul class="space-y-3">
                        @foreach ($categories as $cat)
                            <li>
                                <a href="{{ route('posts.index', ['category' => $cat->slug]) }}" class="text-sm text-slate-400 transition hover:text-white flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full" @style(['background-color' => $cat->color])></span>
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Contact Column --}}
                <div>
                    <h4 class="text-sm font-medium text-white mb-4">Hubungi</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="mailto:aditltsh1992@gmail.com" class="text-sm text-slate-400 transition hover:text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>aditltsh1992@gmail.com</span>
                            </a>
                        </li>
                        <li>
                            <p class="text-sm text-slate-500">
                                Kirim pesan kami untuk kolaborasi atau pertanyaan.
                            </p>
                        </li>
                    </ul>
                </div>

            </div>

            {{-- Divider & Bottom --}}
            <div class="mt-12 pt-8 border-t border-slate-800">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-center sm:text-left text-sm text-slate-500">
                        © {{ date('Y') }} Blog. Semua hak dilindungi.
                    </p>
                    <a href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" class="text-sm text-slate-400 transition hover:text-white flex items-center gap-1">
                        ↑ Kembali ke atas
                    </a>
                </div>
            </div>

        </div>

    </footer>

    {{-- Mobile Menu Script --}}
    <script>
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const navMenu = document.getElementById('navMenu');

        if (mobileMenuToggle && navMenu) {
            // Toggle menu saat klik hamburger
            mobileMenuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('hidden');
            });

            // Tutup menu saat klik link
            navMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    navMenu.classList.add('hidden');
                });
            });

            // Pastikan status menu sesuai breakpoint setelah ukuran layar berubah.
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) {
                    navMenu.classList.remove('hidden');
                } else {
                    navMenu.classList.add('hidden');
                }
            });
        }
    </script>

</body>
</html>
 
