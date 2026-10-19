<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Artikel | Blog</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">

    <main class="mx-auto max-w-3xl px-6 py-12 sm:py-16">

        {{-- KEMBALI --}}
        <a href="{{ route('posts.show', $post) }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 transition hover:text-blue-800">

            <span aria-hidden="true">←</span>
            Kembali ke artikel

        </a>


        {{-- FORM --}}
        <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- HEADER --}}
            <div class="border-b border-slate-200 px-6 py-7 sm:px-8">

                <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">
                    Blog
                </p>

                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">
                    Edit Artikel
                </h1>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Perbarui informasi artikel, lalu simpan perubahan.
                </p>

            </div>


            {{-- FORM --}}
            <form
                action="{{ route('posts.update', $post) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6 px-6 py-7 sm:px-8"
            >

                @csrf
                @method('PUT')


                {{-- JUDUL --}}
                <div>

                    <label
                        for="title"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Judul
                    </label>

                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="{{ old('title', $post->title) }}"
                        required
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >

                    @error('title')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- SLUG --}}
                <div>

                    <label
                        for="slug"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Slug
                    </label>

                    <input
                        id="slug"
                        type="text"
                        name="slug"
                        value="{{ old('slug', $post->slug) }}"
                        required
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >

                    @error('slug')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ISI ARTIKEL --}}
                <div>

                    <label
                        for="content"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Isi Artikel
                    </label>

                    <textarea
                        id="content"
                        name="content"
                        rows="10"
                        required
                        class="block w-full resize-y rounded-lg border border-slate-300 px-4 py-3 text-sm leading-6 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >{{ old('content', $post->content) }}</textarea>

                    @error('content')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- KATEGORI --}}
                <div>

                    <label
                        for="category_id"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Kategori
                        <span class="font-normal text-slate-400">
                            (opsional)
                        </span>
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                        <option value="">Pilih kategori...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- GAMBAR --}}
                <div>

                    <label
                        for="image"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Upload Gambar
                        <span class="font-normal text-slate-400">
                            (opsional)
                        </span>
                    </label>

                    @if ($post->image)
                        <img
                            src="{{ asset('storage/' . $post->image) }}"
                            alt="{{ $post->title }}"
                            class="mb-3 h-32 w-auto rounded-lg object-cover"
                        >
                    @endif

                    <p class="mb-3 text-sm text-slate-500">Format JPG, PNG, WEBP, atau GIF. Maksimal 5 MB.</p>

                    <input
                        id="image"
                        type="file"
                        name="image"
                        accept="image/jpeg,image/png,image/webp,image/gif"
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >

                    @error('image')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- TOMBOL --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('posts.show', $post) }}"
                        class="inline-flex justify-center rounded-lg px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex justify-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </section>

    </main>

</body>
</html>
