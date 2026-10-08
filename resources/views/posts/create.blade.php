<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Artikel | Blog</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <main class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:py-16">
        <a href="/posts" class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 transition hover:text-indigo-800">
            <span aria-hidden="true">←</span> Kembali ke daftar artikel
        </a>

        <section class="mt-6 overflow-hidden rounded-2xl bg-white shadow-xl shadow-slate-200/60 ring-1 ring-slate-200">
            <div class="border-b border-slate-200 px-6 py-7 sm:px-8">
                <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">Blog</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Buat artikel baru</h1>
                <p class="mt-2 text-sm leading-6 text-slate-500">Isi informasi berikut untuk menerbitkan artikel.</p>
            </div>

            <form action="/posts" method="POST" enctype="multipart/form-data" class="space-y-6 px-6 py-7 sm:px-8">
                @csrf

                <div>
                    <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Judul</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                        placeholder="Masukkan judul artikel">
                    @error('title') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="slug" class="mb-2 block text-sm font-semibold text-slate-700">Slug</label>
                    <input id="slug" type="text" name="slug" value="{{ old('slug') }}" required
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
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
                    <label for="image" class="mb-2 block text-sm font-semibold text-slate-700">Upload Gambar (opsional)</label>
                    <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp"
                        class="block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm shadow-sm outline-none transition file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                    @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                    <a href="/posts" class="inline-flex justify-center rounded-lg px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Batal</a>
                    <button type="submit" class="inline-flex justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">Simpan artikel</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
