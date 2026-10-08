<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Admin Pertama | Blog</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <main class="mx-auto max-w-md px-4 py-12 sm:px-6 lg:py-16">
        <a href="{{ route('posts.index') }}" class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-800">
            ← Kembali ke artikel
        </a>

        <section class="mt-6 rounded-2xl bg-white px-6 py-8 shadow-xl shadow-slate-200/60 ring-1 ring-slate-200 sm:px-8">
            <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">Pengaturan awal</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight">Buat admin pertama</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Formulir ini hanya tersedia selama belum ada akun. Setelah dibuat, akun akan langsung masuk dan pendaftaran ditutup.
            </p>

            <form action="{{ route('first-admin.store') }}" method="POST" class="mt-7 space-y-5">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                    @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                    @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Kata sandi</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                    <p class="mt-2 text-xs text-slate-500">Gunakan minimal 12 karakter.</p>
                    @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Ulangi kata sandi</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                </div>

                <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                    Buat akun admin
                </button>
            </form>
        </section>
    </main>
</body>
</html>
