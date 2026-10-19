@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    @if (!auth()->check() || !auth()->user()->is_admin)
        <div class="mx-auto max-w-7xl px-6 py-20 text-center">
            <p class="text-slate-600">Akses ditolak.</p>
        </div>
    @else
        <div class="mx-auto max-w-2xl px-6 py-12">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-slate-900">
                    {{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}
                </h1>
            </div>

            {{-- Form --}}
            <form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}" method="POST" class="space-y-6 rounded-lg border border-slate-200 bg-white p-8 shadow-sm">
                @csrf
                @if (isset($category))
                    @method('PUT')
                @endif

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-900">Nama Kategori</label>
                    <input type="text" name="name" value="{{ $category->name ?? old('name') }}" required maxlength="50"
                        class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        placeholder="Contoh: Tips Belajar">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label class="block text-sm font-medium text-slate-900">Slug (URL-friendly)</label>
                    <input type="text" name="slug" value="{{ $category->slug ?? old('slug') }}" required maxlength="50"
                        class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-2 text-slate-900 placeholder-slate-400 transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        placeholder="Contoh: tips-belajar">
                    <p class="mt-1 text-xs text-slate-500">Gunakan huruf kecil, angka, dan tanda hubung. Contoh: tips-belajar</p>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Color --}}
                <div>
                    <label class="block text-sm font-medium text-slate-900">Warna (Hex)</label>
                    <div class="mt-2 flex items-center gap-3">
                        <input type="color" name="color" value="{{ $category->color ?? '#3B82F6' }}" required
                            class="h-12 w-12 cursor-pointer rounded border border-slate-300">
                        <input type="text" value="{{ $category->color ?? '#3B82F6' }}" readonly
                            class="flex-1 rounded-lg border border-slate-300 px-4 py-2 bg-slate-50 text-slate-600">
                    </div>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 font-semibold text-white transition hover:bg-blue-700">
                        {{ isset($category) ? 'Simpan Perubahan' : 'Buat Kategori' }}
                    </button>
                    <a href="{{ route('categories.index') }}" class="rounded-lg border border-slate-300 px-6 py-2 font-semibold text-slate-600 transition hover:bg-slate-100">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
