@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50">
    {{-- Admin only check --}}
    @if (!auth()->check() || !auth()->user()->is_admin)
        <div class="mx-auto max-w-7xl px-6 py-20 text-center">
            <p class="text-slate-600">Akses ditolak. Halaman ini hanya untuk admin.</p>
        </div>
    @else
        <div class="mx-auto max-w-7xl px-6 py-12">
            {{-- Header --}}
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-slate-900">Kelola Kategori</h1>
                    <p class="mt-2 text-slate-600">Tambah, ubah, atau hapus kategori artikel.</p>
                </div>
                <a href="{{ route('categories.create') }}" class="rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700">
                    + Kategori Baru
                </a>
            </div>

            {{-- Success message --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Table --}}
            <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm">
                <table class="w-full">
                    <thead class="border-b border-slate-200 bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Nama</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Slug</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Warna</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-900">Artikel</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-slate-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $category->slug }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-6 w-6 rounded" style="background-color: {{ $category->color }}"></div>
                                        <span class="text-sm text-slate-500">{{ $category->color }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-slate-900">{{ $category->posts_count ?? 0 }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('categories.edit', $category) }}" class="text-sm font-medium text-blue-600 transition hover:text-blue-700">
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-4 text-sm font-medium text-red-600 transition hover:text-red-700" onclick="return confirm('Yakin ingin menghapus? Artikel tetap tersimpan tanpa kategori.')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada kategori. <a href="{{ route('categories.create') }}" class="text-blue-600 transition hover:text-blue-700">Buat kategori pertama</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($categories->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
