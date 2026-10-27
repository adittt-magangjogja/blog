<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Masuk ke dashboard blog admin.">
    <title>Login | Blog</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <nav class="sticky top-0 z-20 h-16 border-b border-slate-200 bg-white">
        <div class="mx-auto flex h-full max-w-6xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('posts.index') }}" class="shrink-0 text-2xl font-bold tracking-tight text-slate-900">
                Blog<span class="text-slate-900">.</span>
            </a>

            <div class="hidden items-center gap-2 md:flex">
                <a href="{{ route('posts.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 transition hover:text-slate-900">
                    Beranda
                </a>
                <a href="{{ route('about') }}" class="px-4 py-2 text-sm font-medium text-slate-600 transition hover:text-slate-900">
                    Tentang
                </a>
                <a href="{{ route('contact') }}" class="px-4 py-2 text-sm font-medium text-slate-600 transition hover:text-slate-900">
                    Kontak
                </a>
            </div>

            <a href="{{ route('login') }}" class="rounded-lg border border-slate-300 bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:opacity-85">
                Login
            </a>
        </div>
    </nav>

    <main class="mx-auto flex min-h-[calc(100vh-4rem)] max-w-6xl items-center px-4 py-12 sm:px-6">
        <section class="w-full overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_18px_45px_rgba(15,23,42,0.08)]">
            <div class="grid md:grid-cols-[1.1fr_0.9fr]">
                <div class="flex flex-col justify-between bg-slate-950 px-6 py-8 text-white sm:px-10 md:px-12 md:py-12">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-300">
                            Blog Admin
                        </p>
                        <h1 class="mt-4 text-3xl font-bold leading-tight tracking-tight sm:text-4xl">
                            Temukan artikel,
                            <span class="text-slate-200">ide, dan inspirasi.</span>
                        </h1>
                    </div>

                    <div class="mt-8 space-y-4 text-sm text-slate-300">
                        <p>Masuk untuk mengelola artikel, menulis konten baru, dan menjaga blog tetap aktif.</p>
                        <div class="flex items-center gap-3 rounded-2xl border border-slate-700 bg-slate-900/60 p-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-sm font-bold text-slate-900">B</span>
                            <div>
                                <p class="font-medium text-white">Akses cepat</p>
                                <p>Kelola postingan dengan mudah.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-8 sm:px-8 md:px-10 md:py-10">
                    <div class="mb-8">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Masuk</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Selamat datang kembali</h2>
                    </div>

                    @if ($errors->any())
                        <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autocomplete="username"
                                placeholder="nama@email.com"
                                required
                                autofocus
                                class="block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            >
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                required
                                class="block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:bg-white focus:ring-2 focus:ring-slate-200"
                            >
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between gap-3">
                            <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                                Ingat saya
                            </label>

                            <a href="#" class="text-sm font-medium text-slate-600 transition hover:text-slate-900">
                                Lupa password?
                            </a>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-slate-200"
                        >
                            Masuk
                        </button>
                    </form>

                    @if($canRegisterAdmin ?? false)
                        <p class="mt-6 text-center text-sm text-slate-600">
                            Belum punya akun admin?
                            <a href="{{ route('first-admin.create') }}" class="font-semibold text-slate-900 transition hover:text-slate-700">
                                Buat admin pertama
                            </a>
                        </p>
                    @else
                        <p class="mt-6 text-center text-sm text-slate-600">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="font-semibold text-slate-900 transition hover:text-slate-700">
                                Daftar
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </section>
    </main>
</body>
</html>
