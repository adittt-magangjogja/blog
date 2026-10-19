<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tentang Kami | Blog</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    {{-- ================= NAVBAR ================= --}}
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">

            <a href="{{ route('posts.index') }}"
               class="text-2xl font-bold tracking-tight text-slate-900">
                Blog<span class="text-blue-600">.</span>
            </a>

            <div class="flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('posts.index') }}" class="text-slate-600 transition hover:text-blue-600">
                    Beranda
                </a>
                <a href="{{ route('about') }}" class="text-blue-600">
                    Tentang
                </a>
                <a href="{{ route('contact') }}" class="text-slate-600 transition hover:text-blue-600">
                    Kontak
                </a>

                @auth
                    @if (auth()->user()->is_admin)
                        <a href="/admin"
                           class="rounded-lg border border-blue-200 px-4 py-2.5 text-blue-700 transition hover:bg-blue-50">
                            Dashboard Admin
                        </a>
                        <a href="{{ route('posts.create') }}"
                           class="rounded-lg bg-blue-600 px-4 py-2.5 text-white transition hover:bg-blue-700">
                            + Buat Artikel
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-slate-600 transition hover:text-red-600">
                                Keluar
                            </button>
                        </form>
                    @else
                        <span class="text-slate-400">Pengguna</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-slate-600 transition hover:text-red-600">
                                Keluar
                            </button>
                        </form>
                    @endif
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
    <header class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-blue-100 to-indigo-100">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-blue-400 blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-indigo-400 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-6 py-16 sm:py-20">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-blue-300 bg-blue-100 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-blue-700">
                        <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-blue-500"></span>
                        Tentang Kami
                    </p>

                    <h1 class="text-4xl font-bold leading-tight tracking-tight text-slate-900 sm:text-5xl">
                        Cerita di balik
                        <span class="text-blue-600">Blog ini.</span>
                    </h1>

                    <p class="mt-5 max-w-xl text-base leading-7 text-slate-700 sm:text-lg">
                        Blog ini lahir dari kegemaran menulis dan berbagi pengetahuan.
                        Kami percaya ide sederhana yang ditulis dengan jelas bisa
                        menginspirasi banyak orang.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('posts.index') }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition hover:bg-blue-700">
                            Baca Artikel
                            <span aria-hidden="true">→</span>
                        </a>
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-blue-400 bg-white px-5 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
                            Hubungi Kami
                        </a>
                    </div>
                </div>

                {{-- STATS USER & POST --}}
                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    <div class="rounded-2xl border border-blue-300 bg-white/80 p-5 shadow-sm backdrop-blur">
                        <p class="text-3xl font-bold text-blue-600 sm:text-4xl">{{ $totalUsers }}</p>
                        <p class="mt-1 text-xs font-medium text-slate-600">Total User</p>
                    </div>
                    <div class="rounded-2xl border border-blue-300 bg-white/80 p-5 shadow-sm backdrop-blur">
                        <p class="text-3xl font-bold text-indigo-600 sm:text-4xl">{{ $adminCount }}</p>
                        <p class="mt-1 text-xs font-medium text-slate-600">Admin</p>
                    </div>
                    <div class="rounded-2xl border border-blue-300 bg-white/80 p-5 shadow-sm backdrop-blur">
                        <p class="text-3xl font-bold text-indigo-600 sm:text-4xl">{{ $userCount }}</p>
                        <p class="mt-1 text-xs font-medium text-slate-600">Pengguna</p>
                    </div>
                    <div class="rounded-2xl border border-blue-300 bg-white/80 p-5 shadow-sm backdrop-blur">
                        <p class="text-3xl font-bold text-blue-600 sm:text-4xl">{{ \App\Models\Post::count() }}</p>
                        <p class="mt-1 text-xs font-medium text-slate-600">Total Artikel</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ================= MISI & TIM ================= --}}
    <main class="mx-auto max-w-7xl px-6 py-16">

        {{-- Misi --}}
        <section class="mb-16">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">Misi</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                    Mengapa blog ini ada?
                </h2>
                <p class="mt-4 text-base leading-7 text-slate-600">
                    Kami menulis tentang teknologi, pemrograman, dan produktivitas —
                    disajikan ringkas, jujur, dan mudah dipraktikkan. Setiap artikel
                    melewati proses editing sebelum dipublikasikan.
                </p>
            </div>
        </section>

        {{-- Tim / User --}}
        <section>
            <div class="mb-8">
                <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">Tim & Pengguna</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Orang-orang di dalamnya
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Data user terdaftar di blog ini (admin dan pengguna).
                </p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($users as $user)
                    <article
                        class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                        {{-- Avatar inisial --}}
                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br {{ $user->is_admin ? 'from-amber-400 to-orange-500' : 'from-blue-400 to-indigo-500 }} text-lg font-bold text-white">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <div class="min-w-0">
                                <h3 class="truncate text-lg font-bold text-slate-900">
                                    {{ $user->name }}
                                </h3>
                                <p class="truncate text-sm text-slate-500">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold {{ $user->is_admin ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $user->is_admin ? 'bg-amber-500' : 'bg-blue-500' }}"></span>
                                {{ $user->is_admin ? 'Admin' : 'Pengguna' }}
                            </span>

                            <span class="text-xs text-slate-400">
                                sejak {{ $user->created_at->format('M Y') }}
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

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
                <div class="flex items-center gap-6 text-sm text-slate-500">
                    <a href="{{ route('posts.index') }}" class="transition hover:text-blue-600">Beranda</a>
                    <a href="{{ route('about') }}" class="transition hover:text-blue-600">Tentang</a>
                    <a href="{{ route('contact') }}" class="transition hover:text-blue-600">Kontak</a>
                </div>
                <p class="text-sm text-slate-400">
                    © {{ date('Y') }} BLOG.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
