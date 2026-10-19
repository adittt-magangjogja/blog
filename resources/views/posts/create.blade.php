<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Artikel | Blog</title>

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

            </div>

        </div>
    </nav>


    {{-- FORM --}}
    <main class="mx-auto max-w-3xl px-6 py-12 sm:py-16">

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- HEADER --}}
            <div class="border-b border-slate-200 px-6 py-7 sm:px-8">

                <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">Blog</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Buat artikel baru</h1>
                <p class="mt-2 text-sm leading-6 text-slate-500">Isi informasi berikut untuk menerbitkan artikel.</p>
            </div>

            {{-- FORM --}}
            <form
                action="{{ route('posts.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6 px-6 py-7 sm:px-8"
            >
                @csrf

                <div>
                    <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Judul</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        placeholder="Masukkan judul artikel">
                    @error('title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="slug" class="mb-2 block text-sm font-semibold text-slate-700">Slug</label>
                    <input id="slug" type="text" name="slug" value="{{ old('slug') }}" required
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        placeholder="contoh: artikel-baru">
                    @error('slug') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="content" class="mb-2 block text-sm font-semibold text-slate-700">Isi artikel</label>
                    <textarea id="content" name="content" rows="8" required
                        class="block w-full resize-y rounded-lg border border-slate-300 px-4 py-3 text-sm leading-6 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                        placeholder="Tulis isi artikel di sini...">{{ old('content') }}</textarea>
                    @error('content') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="mb-2 block text-sm font-semibold text-slate-700">Kategori (opsional)</label>
                    <select id="category_id" name="category_id"
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                        <option value="">Pilih kategori...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="image" class="mb-2 block text-sm font-semibold text-slate-700">Upload Gambar (opsional)</label>
                    <p class="mb-3 text-sm text-slate-500">Format JPG, PNG, WEBP, atau GIF. Maksimal 5 MB.</p>
                    <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                    @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- TOMBOL --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('posts.index') }}"
                        class="inline-flex justify-center rounded-lg px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex justify-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200"
                    >
                        Simpan artikel
                    </button>

                </div>

            </form>

        </section>

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
