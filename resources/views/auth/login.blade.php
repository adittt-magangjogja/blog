<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Blog</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-linear-to-br from-slate-100 to-indigo-100">

    <main class="flex min-h-screen items-center justify-center px-4 py-10">

        <section
            class="w-full max-w-md rounded-3xl bg-white px-8 py-10 shadow-2xl shadow-slate-300/50 sm:px-10">

            <!-- Kembali -->
            <a
                href="/posts"
                class="text-sm font-medium text-slate-500 transition hover:text-indigo-600">
                ← Kembali ke artikel
            </a>

            <!-- Judul -->
            <div class="mt-8 text-center">

                <h1 class="text-4xl font-bold tracking-tight text-slate-950">
                    Sign In
                </h1>

                <!-- Social Login -->
                <div class="mt-7 flex justify-center gap-3">

                    <button
                        type="button"
                        class="flex h-12 w-12 items-center justify-center rounded-xl border border-slate-300 bg-white font-bold text-slate-800 transition hover:bg-slate-50">
                        G+
                    </button>

                    <button
                        type="button"
                        class="flex h-12 w-12 items-center justify-center rounded-xl border border-slate-300 bg-white text-lg font-bold text-slate-800 transition hover:bg-slate-50">
                        f
                    </button>

                    <button
                        type="button"
                        class="flex h-12 w-12 items-center justify-center rounded-xl border border-slate-300 bg-white font-bold text-slate-800 transition hover:bg-slate-50">
                        ◉
                    </button>

                    <button
                        type="button"
                        class="flex h-12 w-12 items-center justify-center rounded-xl border border-slate-300 bg-white text-sm font-bold text-slate-800 transition hover:bg-slate-50">
                        in
                    </button>

                </div>

                <p class="mt-6 text-sm text-slate-600">
                    or use your email password
                </p>

            </div>


            <!-- Error Laravel -->
            @if ($errors->any())
                <div
                    role="alert"
                    class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif


            <!-- FORM LOGIN -->
            <form
                action="/login"
                method="POST"
                class="mt-7 space-y-5">

                @csrf

                <!-- Email -->
                <div>

                    <label for="email" class="sr-only">
                        Email
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                        placeholder="Email"
                        required
                        autofocus
                        class="block w-full rounded-xl border-0 bg-slate-100 px-5 py-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-500 focus:bg-white focus:ring-2 focus:ring-indigo-500">

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Password -->
                <div>

                    <label for="password" class="sr-only">
                        Kata sandi
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        placeholder="Password"
                        required
                        class="block w-full rounded-xl border-0 bg-slate-100 px-5 py-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-500 focus:bg-white focus:ring-2 focus:ring-indigo-500">

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Ingat saya -->
                <div class="flex items-center justify-center">

                    <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">

                        Ingat saya

                    </label>

                </div>


                <!-- Lupa Password -->
                <div class="text-center">

                    <a
                        href="#"
                        class="text-sm text-slate-600 transition hover:text-indigo-600">
                        Forget Your Password?
                    </a>

                </div>


                <!-- Tombol Login -->
                <div class="flex justify-center pt-2">

                    <button
                        type="submit"
                        class="w-48 rounded-xl bg-indigo-700 px-5 py-3.5 text-sm font-bold uppercase tracking-wide text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                        Sign In
                    </button>

                </div>

            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-700 transition hover:text-indigo-800">
                    Daftar
                </a>
            </p>

        </section>

    </main>

</body>
</html>
