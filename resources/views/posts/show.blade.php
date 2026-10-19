<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $post->title }} | Blog</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    {{-- ================= READING PROGRESS BAR ================= --}}
    <div id="reading-progress" class="fixed top-0 left-0 z-50 h-1 w-0 bg-gradient-to-r from-blue-500 to-indigo-500 transition-all duration-150"></div>


    {{-- NAVBAR --}}
    <nav class="sticky top-0 z-40 border-b border-slate-200 bg-white/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">

            <a href="{{ route('posts.index') }}"
               class="text-xl font-bold tracking-tight text-slate-900 transition hover:text-blue-600">
                Blog<span class="text-blue-600">.</span>
            </a>

            <div class="flex items-center gap-4 text-sm font-medium">

                <a href="{{ route('posts.index') }}"
                   class="inline-flex items-center gap-1 rounded-lg px-3 py-2 text-slate-600 transition hover:bg-slate-100 hover:text-blue-600">
                    ← Kembali
                </a>

                @auth

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                                class="rounded-lg px-3 py-2 text-slate-600 transition hover:bg-red-50 hover:text-red-600">
                            Keluar
                        </button>
                    </form>

                @else

                    <a href="{{ route('login') }}"
                       class="rounded-lg border border-slate-300 px-4 py-2 text-slate-700 transition hover:bg-slate-100">
                        Login Admin
                    </a>

                @endauth

            </div>
        </div>
    </nav>


    {{-- ================= HERO HEADER (ARTIKEL) ================= --}}
    <header class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute -top-32 -right-32 h-80 w-80 rounded-full bg-blue-200 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 h-80 w-80 rounded-full bg-indigo-200 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-4xl px-6 py-12 sm:py-16">

            {{-- Meta info --}}
            <div class="mb-5 flex flex-wrap items-center gap-3 text-sm">

                <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1 font-medium text-blue-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    {{ $post->created_at ? $post->created_at->format('d M Y') : 'N/A' }}
                </span>

                <span class="inline-flex items-center gap-1.5 rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 font-medium text-indigo-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    ~{{ str_word_count($post->content) }} kata
                </span>

                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 font-medium text-emerald-700">
                    #{{ $post->slug }}
                </span>

            </div>

            {{-- Judul --}}
            <h1 class="text-4xl font-bold leading-tight tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                {{ $post->title }}
            </h1>

            {{-- Subtle divider --}}
            <div class="mt-8 h-px w-full bg-gradient-to-r from-transparent via-blue-200 to-transparent"></div>

        </div>
    </header>


    {{-- ================= MAIN CONTENT ================= --}}
    <main class="mx-auto max-w-4xl px-6 pb-16">

        {{-- GAMBAR UTAMA --}}
        @if ($post->image)

            <div class="-mx-6 mt-0 overflow-hidden sm:-mx-12 sm:mt-[-60px] sm:max-w-none">
                <div class="mx-auto max-w-5xl px-6 sm:px-12">

                    <figure class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50">
                        <img src="{{ asset('storage/' . $post->image) }}"
                             alt="{{ $post->title }}"
                             class="w-full object-cover">

                        <figcaption class="px-6 py-3 text-xs text-slate-400">
                            Gambar utama artikel "{{ $post->title }}"
                        </figcaption>
                    </figure>

                </div>
            </div>

        @endif


        {{-- ADMIN ACTIONS BAR --}}
        @auth
            @if (auth()->user()->is_admin)
                <div class="sticky top-[65px] z-30 mt-8 flex flex-wrap items-center gap-3 rounded-xl border border-blue-200 bg-blue-50/70 p-4 backdrop-blur-sm">

                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-600">Mode Admin</span>

                    <div class="ml-auto flex flex-wrap gap-2">

                        <a href="{{ route('posts.edit', $post) }}"
                           class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-md shadow-blue-600/20 transition hover:bg-blue-700">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Edit Artikel
                        </a>

                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                Hapus
                            </button>
                        </form>

                    </div>
                </div>
            @endif
        @endauth


        {{-- ARTICLE BODY — PROSE STYLING --}}
        <article class="prose prose-lg prose-blue mx-auto mt-10 max-w-none prose-headings:font-bold prose-headings:tracking-tight prose-h2:text-2xl prose-h2:text-slate-900 prose-h2:border-b prose-h2:border-slate-200 prose-h2:pb-3 prose-h2:mt-12 prose-h2:mb-6 prose-h3:text-xl prose-h3:text-slate-800 prose-h3:mt-8 prose-h3:mb-4 prose-p:leading-8 prose-p:text-slate-700 prose-a:text-blue-600 prose-a:no-underline hover:prose-a:underline prose-strong:text-slate-900 prose-code:before:content-none prose-code:after:content-none prose-code:rounded prose-code:bg-slate-100 prose-code:px-1.5 prose-code:py-0.5 prose-code:text-sm prose-code:font-mono prose-code:text-blue-700 prose-pre:rounded-xl prose-pre:bg-slate-900 prose-pre:shadow-lg sm:prose-xl">

            {!! nl2br(e($post->content)) !!}

        </article>


        {{-- ================= DIVIDER + SHARE ================= --}}
        <div class="mt-16 flex flex-col items-center gap-6">

            <div class="h-px w-full bg-gradient-to-r from-transparent via-slate-300 to-transparent"></div>

            <p class="text-sm text-slate-500">Artikel ini bermanfaat? Share ke teman-teman!</p>

            <div class="flex flex-wrap justify-center gap-3">

                {{-- X / Twitter --}}
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-900 hover:text-white">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.9 1.15h3.68l-8.04 9.19L24 22.85h-7.4l-5.8-7.58-6.64 7.58H.46l8.6-9.83L0 1.15h7.6l5.24 6.93 6.06-6.93zm-1.3 19.5h2.04L6.5 3.24H4.3l13.3 17.4z"/>
                    </svg>
                    X
                </a>

                {{-- Facebook --}}
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-blue-600 hover:text-white">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.09 10.13 24v-8.44H7.08v-3.49h3.04V9.41c0-3.02 1.8-4.7 4.54-4.7 1.31 0 2.68.24 2.68.24v2.97h-1.5c-1.5 0-1.96.93-1.96 1.89v2.26h3.32l-.53 3.49h-2.8V24C19.62 23.1 24 18.1 24 12.07z"/>
                    </svg>
                    Facebook
                </a>

                {{-- WhatsApp --}}
                <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' — ' . request()->url()) }}"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-green-500 hover:text-white">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                    WhatsApp
                </a>

                {{-- Salin Link --}}
                <button onclick="navigator.clipboard.writeText(window.location.href); this.querySelector('span').textContent='Tersalin!'; setTimeout(() => this.querySelector('span').textContent='Salin Link', 2000)"
                        class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                    </svg>
                    <span>Salin Link</span>
                </button>

            </div>

        </div>


        {{-- ================= NAVIGATION (PREV/NEXT) ================= --}}
        <nav class="mt-12 grid gap-4 sm:grid-cols-2">

            <a href="{{ route('posts.index') }}"
               class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-white p-5 transition hover:border-blue-300 hover:shadow-md">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 transition group-hover:bg-blue-100">
                    <svg class="h-5 w-5 text-slate-600 transition group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Sebelumnya</p>
                    <p class="font-semibold text-slate-700">Kembali ke daftar</p>
                </div>

            </a>

            <a href="{{ route('posts.index') }}"
               class="group flex items-center justify-end gap-3 rounded-xl border border-slate-200 bg-white p-5 text-right transition hover:border-blue-300 hover:shadow-md">

                <div>
                    <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Selanjutnya</p>
                    <p class="font-semibold text-slate-700">Jelajahi lainnya</p>
                </div>

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-100 transition group-hover:bg-blue-100">
                    <svg class="h-5 w-5 text-slate-600 transition group-hover:text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>

            </a>

        </nav>

    </main>


    {{-- FOOTER --}}
    <footer class="border-t border-slate-200 bg-white">

        <div class="mx-auto max-w-7xl px-6 py-8">

            <div class="flex flex-col items-center justify-between gap-3 sm:flex-row">

                <p class="text-sm text-slate-500">
                    Blog<span class="text-blue-600">.</span> — Platform blog sederhana.
                </p>

                <p class="text-sm text-slate-400">
                    © {{ date('Y') }} Blog. All rights reserved.
                </p>

            </div>

        </div>

    </footer>


    {{-- ================= READING PROGRESS SCRIPT ================= --}}
    <script>
        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            document.getElementById('reading-progress').style.width = scrollPercent + '%';
        });
    </script>

</body>
</html>