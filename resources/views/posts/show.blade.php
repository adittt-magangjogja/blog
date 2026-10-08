<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $post->title }} | Blog</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    {{-- NAVBAR --}}
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">

            <a href="{{ route('posts.index') }}"
               class="text-2xl font-bold tracking-tight text-slate-900">
                Blog<span class="text-blue-600">.</span>
            </a>

            <div class="flex items-center gap-4 text-sm font-medium">

                <a href="{{ route('posts.index') }}"
                   class="text-slate-600 transition hover:text-blue-600">
                    ← Kembali
                </a>

                @auth

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


    {{-- ARTIKEL --}}
    <main class="mx-auto max-w-4xl px-6 py-12 sm:py-16">

        <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- GAMBAR --}}
            @if ($post->image)

                <div class="aspect-video overflow-hidden bg-slate-100">

                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">

                </div>

            @endif


            {{-- ISI ARTIKEL --}}
            <div class="px-6 py-10 sm:px-10 sm:py-12">

                {{-- TANGGAL --}}
                @if ($post->created_at)

                    <p class="text-sm font-medium uppercase tracking-wide text-slate-400">
                        {{ $post->created_at->format('d M Y') }}
                    </p>

                @endif


                {{-- JUDUL --}}
                <h1 class="mt-3 text-3xl font-bold leading-tight tracking-tight text-slate-900 sm:text-5xl">
                    {{ $post->title }}
                </h1>


                {{-- SLUG --}}
                <div class="mt-5">

                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700">
                        {{ $post->slug }}
                    </span>

                </div>


                {{-- TOMBOL ADMIN --}}
                @auth

                    <div class="mt-7 flex flex-wrap gap-3 border-b border-slate-100 pb-7">

                        <a href="{{ route('posts.edit', $post) }}"
                           class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Edit Artikel
                        </a>


                        <form
                            action="{{ route('posts.destroy', $post) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus artikel ini?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex items-center rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                            >
                                Hapus Artikel
                            </button>

                        </form>

                    </div>

                @endauth


                {{-- ISI --}}
                <div class="mt-8 whitespace-pre-line text-base leading-8 text-slate-700 sm:text-lg">
                    {{ $post->content }}
                </div>

            </div>

        </article>


        {{-- KEMBALI --}}
        <div class="mt-8">

            <a href="{{ route('posts.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-800">

                <span>←</span>

                Kembali ke semua artikel

            </a>

        </div>

    </main>


    {{-- FOOTER --}}
    <footer class="border-t border-slate-200 bg-white">

        <div class="mx-auto max-w-7xl px-6 py-8">

            <div class="flex flex-col items-center justify-between gap-3 sm:flex-row">

                <p class="text-sm text-slate-500">
                    Blog<span class="text-blue-600">.</span>
                </p>

                <p class="text-sm text-slate-400">
                    © {{ date('Y') }} Blog. All rights reserved.
                </p>

            </div>

        </div>

    </footer>

</body>
</html>