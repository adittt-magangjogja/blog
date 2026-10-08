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
        $fullName = auth()->user()->name;
        $firstName = explode(' ', trim($fullName))[0];
        $initial = mb_strtoupper(mb_substr($fullName, 0, 1));
    @endphp

    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:py-12">
        {{-- Bilah atas --}}
        <header class="flex items-center justify-between gap-4">
            <a href="/" class="flex items-center gap-3 font-display text-xl font-semibold tracking-tight">
                <span class="grid size-9 place-items-center rounded-xl bg-leaf text-white">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z" />
                    </svg>
                </span>
                Blog
            </a>

            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2.5">
                    <span class="grid size-9 place-items-center rounded-full bg-white text-sm font-semibold text-leaf ring-1 ring-slate-200">{{ $initial }}</span>
                    <span class="hidden text-sm font-medium sm:inline">{{ $fullName }}</span>
                </div>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="rounded-lg px-3.5 py-2 text-sm font-semibold text-slate-600 ring-1 ring-slate-300 transition hover:bg-white hover:text-ink focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-leaf">
                        Keluar
                    </button>
                </form>
            </div>
        </header>

        {{-- Sapaan --}}
        <section class="mt-8 rounded-3xl bg-ink p-8 text-white sm:p-10">
            <div class="flex flex-col gap-10 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-xl">
                    <p class="text-sm text-slate-400">{{ $now->translatedFormat('l, j F Y') }}</p>
                    <h1 class="mt-3 font-display text-4xl font-semibold leading-tight tracking-tight sm:text-5xl">
                        {{ $greeting }}, {{ $firstName }}.
                    </h1>
                    <p class="mt-4 text-base leading-7 text-slate-300">
                        @if ($totalPosts > 0)
                            Mau menulis artikel baru atau merapikan yang sudah ada?
                        @else
                            Blogmu masih kosong. Tulis artikel pertama untuk memulai.
                        @endif
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="/posts/create" class="inline-flex items-center gap-2 rounded-xl bg-sun px-5 py-3 text-sm font-semibold text-ink transition hover:bg-amber-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sun focus-visible:ring-offset-2 focus-visible:ring-offset-ink">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
                            Tulis artikel
                        </a>
                        @if ($totalPosts > 0)
                            <a href="/posts" class="inline-flex items-center rounded-xl px-5 py-3 text-sm font-semibold text-white ring-1 ring-white/25 transition hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white">
                                Kelola artikel
                            </a>
                        @endif
                    </div>
                </div>

                <div class="border-t border-white/15 pt-6 lg:border-l lg:border-t-0 lg:pl-10 lg:pt-0">
                    <p class="font-display text-7xl font-semibold leading-none tracking-tight text-sun">{{ $totalPosts }}</p>
                    <p class="mt-3 text-sm text-slate-300">artikel tersimpan</p>
                </div>
            </div>
        </section>

        {{-- Pintasan --}}
        <section class="mt-8">
            <h2 class="font-display text-xl font-semibold tracking-tight">Pintasan</h2>

            <div class="mt-4 divide-y divide-slate-100 overflow-hidden rounded-2xl bg-white ring-1 ring-slate-200">
                <a href="/posts/create" class="group flex items-center gap-4 p-5 transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-leaf">
                    <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-leaf/10 text-leaf">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block font-semibold">Tambah artikel</span>
                        <span class="mt-0.5 block text-sm text-slate-500">Tulis dan terbitkan artikel baru.</span>
                    </span>
                    <svg class="size-5 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-leaf" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
                </a>

                <a href="/posts" class="group flex items-center gap-4 p-5 transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-leaf">
                    <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-leaf/10 text-leaf">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" /></svg>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block font-semibold">Kelola artikel</span>
                        <span class="mt-0.5 block text-sm text-slate-500">Lihat, edit, atau hapus artikel yang ada.</span>
                    </span>
                    <svg class="size-5 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-leaf" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
                </a>

                <a href="/" class="group flex items-center gap-4 p-5 transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-leaf">
                    <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-leaf/10 text-leaf">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 3h6v6M10 14 21 3M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" /></svg>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block font-semibold">Lihat blog</span>
                        <span class="mt-0.5 block text-sm text-slate-500">Buka blog seperti yang dilihat pembaca.</span>
                    </span>
                    <svg class="size-5 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-leaf" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6" /></svg>
                </a>
            </div>
        </section>
    </div>
</body>
</html>