<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Blog</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-mist font-sans text-ink antialiased">
    @php
        $now = now('Asia/Jakarta')->locale('id');
        $hour = $now->hour;
        $greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));
        $fullName = ucwords(strtolower(auth()->user()->name));
        $firstName = explode(' ', trim($fullName))[0];
        $initial = mb_strtoupper(mb_substr($fullName, 0, 1));
    @endphp

    {{-- Navigation --}}
    <nav class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur-sm">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-3 sm:px-6">
            <div class="flex items-center gap-6">
                <a href="/admin" class="flex items-center gap-2.5 rounded-lg font-display text-lg font-semibold tracking-tight focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">
                    <span class="grid size-8 place-items-center rounded-lg bg-leaf text-white">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z" />
                        </svg>
                    </span>
                    <span class="hidden sm:inline">Blog</span>
                </a>
                <div class="hidden items-center gap-1 sm:flex">
                    <a href="/admin" class="rounded-lg bg-leaf/10 px-3 py-1.5 text-sm font-semibold text-leaf focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">Dashboard</a>
                    <a href="/posts" class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">Artikel</a>
                    <a href="/categories" class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">Kategori</a>
                    <a href="/" target="_blank" class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 transition hover:bg-slate-100 hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">
                        Lihat blog
                        <svg class="ml-1 inline size-3.5 align-[-2px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 3h6v6M10 14 21 3M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" /></svg>
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <span class="grid size-8 place-items-center rounded-full bg-leaf/10 text-sm font-semibold text-leaf ring-1 ring-leaf/20">{{ $initial }}</span>
                    <span class="hidden text-sm font-medium sm:inline">{{ $fullName }}</span>
                </div>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="rounded-lg px-3 py-1.5 text-sm font-semibold text-slate-500 ring-1 ring-slate-300 transition hover:bg-white hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile nav --}}
        <div class="flex items-center gap-1 overflow-x-auto px-4 pb-2 sm:hidden">
            <a href="/admin" class="shrink-0 rounded-lg bg-leaf/10 px-3 py-1.5 text-sm font-semibold text-leaf focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf">Dashboard</a>
            <a href="/posts" class="shrink-0 rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf">Artikel</a>
            <a href="/categories" class="shrink-0 rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf">Kategori</a>
            <a href="/" target="_blank" class="shrink-0 rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf">Lihat blog</a>
        </div>
    </nav>

    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:py-8">

        {{-- Hero (compact, max ~1/3 viewport) --}}
        <section class="rounded-2xl bg-ink px-6 py-6 text-white sm:px-8 sm:py-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="min-w-0">
                    <p class="text-sm text-slate-400">{{ $now->translatedFormat('l, j F Y') }}</p>
                    <h1 class="mt-1.5 font-display text-2xl font-semibold leading-tight tracking-tight sm:text-3xl">
                        {{ $greeting }}, {{ $firstName }}.
                    </h1>
                    <p class="mt-2 text-sm leading-relaxed text-slate-300">
                        @if ($totalPosts > 0)
                            Mau menulis artikel baru atau merapikan yang sudah ada?
                        @else
                            Blogmu masih kosong. Tulis artikel pertama untuk memulai.
                        @endif
                    </p>
                </div>
                <a href="/posts/create" class="inline-flex shrink-0 items-center gap-2 self-start rounded-xl bg-sun px-5 py-2.5 text-sm font-semibold text-ink transition hover:bg-amber-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sun focus-visible:ring-offset-2 focus-visible:ring-offset-ink">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
                    Tulis artikel
                </a>
            </div>
        </section>

        {{-- Stat cards --}}
        <section class="mt-6 grid grid-cols-2 gap-4">
            <div class="rounded-xl bg-white p-5 ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Total artikel</p>
                <p class="mt-1 font-display text-3xl font-semibold tracking-tight text-ink">{{ $totalPosts }}</p>
            </div>
            <div class="rounded-xl bg-white p-5 ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-500">Artikel minggu ini</p>
                <p class="mt-1 font-display text-3xl font-semibold tracking-tight text-leaf">{{ $postsThisWeek }}</p>
            </div>
        </section>

        {{-- Artikel terbaru --}}
        @if ($recentPosts->count() > 0)
        <section class="mt-6">
            <h2 class="font-display text-lg font-semibold tracking-tight">Artikel terbaru</h2>

            {{-- Desktop table --}}
            <div class="mt-3 hidden overflow-hidden rounded-xl bg-white ring-1 ring-slate-200 sm:block">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="px-5 py-3 font-semibold text-slate-600">Judul</th>
                            <th class="px-5 py-3 font-semibold text-slate-600">Kategori</th>
                            <th class="px-5 py-3 font-semibold text-slate-600">Tanggal</th>
                            <th class="px-5 py-3 text-right font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($recentPosts as $post)
                        <tr class="transition hover:bg-slate-50/50">
                            <td class="max-w-xs truncate px-5 py-3.5 font-medium text-ink">{{ $post->title }}</td>
                            <td class="px-5 py-3.5">
                                @if ($post->category)
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset"
                                          style="background-color: {{ $post->category->color ?? '#0e7c7b' }}15; color: {{ $post->category->color ?? '#0e7c7b' }}; --tw-ring-color: {{ $post->category->color ?? '#0e7c7b' }}30;">
                                        {{ $post->category->name }}
                                    </span>
                                @else
                                    <span class="text-slate-400">&mdash;</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-500">{{ $post->created_at->locale('id')->translatedFormat('j M Y') }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="/posts/{{ $post->id }}/edit" class="rounded-lg px-2.5 py-1 text-xs font-semibold text-leaf ring-1 ring-leaf/30 transition hover:bg-leaf/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">Edit</a>
                                    <a href="/posts/{{ $post->id }}" target="_blank" class="rounded-lg px-2.5 py-1 text-xs font-semibold text-slate-500 ring-1 ring-slate-300 transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">Lihat</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile cards --}}
            <div class="mt-3 space-y-2 sm:hidden">
                @foreach ($recentPosts as $post)
                <div class="rounded-xl bg-white p-4 ring-1 ring-slate-200">
                    <p class="truncate font-medium text-ink">{{ $post->title }}</p>
                    <div class="mt-2 flex items-center gap-2">
                        @if ($post->category)
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ring-1 ring-inset"
                                  style="background-color: {{ $post->category->color ?? '#0e7c7b' }}15; color: {{ $post->category->color ?? '#0e7c7b' }}; --tw-ring-color: {{ $post->category->color ?? '#0e7c7b' }}30;">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <span class="text-xs text-slate-500">{{ $post->created_at->locale('id')->translatedFormat('j M Y') }}</span>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <a href="/posts/{{ $post->id }}/edit" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-leaf ring-1 ring-leaf/30 transition hover:bg-leaf/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf">Edit</a>
                        <a href="/posts/{{ $post->id }}" target="_blank" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-500 ring-1 ring-slate-300 transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf">Lihat</a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- Pintasan --}}
        <section class="mt-6">
            <h2 class="font-display text-lg font-semibold tracking-tight">Pintasan</h2>

            <div class="mt-3 grid gap-3 sm:grid-cols-3">
                <a href="/posts" class="group flex items-center gap-3.5 rounded-xl bg-white p-4 ring-1 ring-slate-200 transition hover:shadow-sm hover:ring-leaf/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">
                    <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-leaf/10 text-leaf">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" /></svg>
                    </span>
                    <span>
                        <span class="block text-sm font-semibold text-ink">Kelola artikel</span>
                        <span class="block text-xs text-slate-500">Lihat, edit, atau hapus.</span>
                    </span>
                </a>

                <a href="/categories" class="group flex items-center gap-3.5 rounded-xl bg-white p-4 ring-1 ring-slate-200 transition hover:shadow-sm hover:ring-leaf/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">
                    <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-sun/15 text-amber-600">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82zM7 7h.01" /></svg>
                    </span>
                    <span>
                        <span class="block text-sm font-semibold text-ink">Kelola kategori</span>
                        <span class="block text-xs text-slate-500">Tambah atau atur kategori.</span>
                    </span>
                </a>

                <a href="/" target="_blank" class="group flex items-center gap-3.5 rounded-xl bg-white p-4 ring-1 ring-slate-200 transition hover:shadow-sm hover:ring-leaf/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf focus-visible:ring-offset-2">
                    <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-leaf/10 text-leaf">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 3h6v6M10 14 21 3M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" /></svg>
                    </span>
                    <span>
                        <span class="block text-sm font-semibold text-ink">Lihat blog</span>
                        <span class="block text-xs text-slate-500">Buka halaman publik.</span>
                    </span>
                </a>
            </div>
        </section>

    </div>
</body>
</html>