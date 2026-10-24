<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kontak Kami | Blog</title>

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
                <a href="{{ route('about') }}" class="text-slate-600 transition hover:text-blue-600">
                    Tentang
                </a>
                <a href="{{ route('contact') }}" class="text-blue-600">
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
                @endif
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
            <div class="max-w-2xl">
                <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-blue-300 bg-blue-100 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-blue-700">
                    <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-blue-500"></span>
                    Kontak
                </p>

                <h1 class="text-4xl font-bold leading-tight tracking-tight text-slate-900 sm:text-5xl">
                    Punya ide atau
                    <span class="text-blue-600">pertanyaan?</span>
                </h1>

                <p class="mt-5 text-base leading-7 text-slate-700 sm:text-lg">
                    Kami terbuka untuk kolaborasi, kritik, dan saran.
                    Kirim pesan melalui formulir atau hubungi kami langsung.
                </p>
            </div>
        </div>
    </header>

    {{-- ================= KONTAK ================= --}}
    <main class="mx-auto max-w-7xl px-6 py-16">

        <div class="grid gap-10 lg:grid-cols-2">

            {{-- INFO KONTAK --}}
            <section>
                <div class="mb-8">
                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">Info Kontak</p>
                    <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                        Saluran yang tersedia
                    </h2>
                </div>

                <div class="space-y-4">

                    {{-- Alamat --}}
                    <div class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">Alamat</h3>
                            <p class="mt-1 text-sm text-slate-500">Jl. Contoh No. 123, Kota, Provinsi</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">Email</h3>
                            <a href="mailto:aditltsh1992@gmail.com" class="mt-1 text-sm text-blue-600 transition hover:underline">
                                aditltsh1992@gmail.com
                            </a>
                        </div>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">WhatsApp</h3>
                            <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="mt-1 text-sm text-blue-600 transition hover:underline">
                                +62 812-3456-7890
                            </a>
                        </div>
                    </div>

                    {{-- Instagram --}}
                    <div class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">Instagram</h3>
                            <a href="https://instagram.com/blog.contoh" target="_blank" rel="noopener" class="mt-1 text-sm text-blue-600 transition hover:underline">
                                @blog.contoh
                            </a>
                        </div>
                    </div>

                    {{-- Jam buka --}}
                    <div class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">Jam Respons</h3>
                            <p class="mt-1 text-sm text-slate-500">Senin - Jumat, 09.00 - 18.00 WIB</p>
                        </div>
                    </div>

                </div>
            </section>

            {{-- FORM --}}
            <section>
                <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">Formulir</p>
                    <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                        Kirim pesan
                    </h2>

                    @if (session('success'))
                        <div class="mt-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="mt-6 space-y-5">
                        @csrf

                        {{-- Nama --}}
                        <div>
                            <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Nama</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                required
                                placeholder="Nama Anda"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="email@contoh.com"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none">
                            @error('email')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Pesan --}}
                        <div>
                            <label for="message" class="mb-1.5 block text-sm font-medium text-slate-700">Pesan</label>
                            <textarea
                                id="message"
                                name="message"
                                rows="5"
                                required
                                placeholder="Tulis pesan Anda di sini..."
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"></textarea>
                            @error('message')
                                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition hover:bg-blue-700">
                            Kirim Pesan
                        </button>
                    </form>

                    <p class="mt-4 text-xs text-slate-400">
                        Formulir ini menyimpan pesan ke database (tabel <code class="rounded bg-slate-100 px-1">contact_messages</code>).
                    </p>
                </div>
            </section>

        </div>

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
