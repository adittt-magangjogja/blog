# Daftar Prioritas Perbaikan Blog Laravel

> Hasil audit otomatis AI Agent pada codebase `C:\laragon\www\blog`  
> Format: **P0 (Critical)** → **P1 (High)** → **P2 (Medium)** → **P3 (Low)**

---

## P0 — Critical (Aman & Stabilitas)

### 1. Slug collision saat update artikel (Bug)
- **Lokasi:** `PostController@update`, baris 36
- **Masalah:** `unique:posts,slug,' . $post->id` — ini benar, tapi di view `edit.blade.php` slug di-edit manual oleh user. Dua artikel berbeda bisa punya slug sama kalau user sengaja isi slug identik dengan post lain.
- **Risiko:** Route model binding `Post $post` pakai ID, jadi show/edit aman. Tapi SEO & link permanen bisa rusak. Lebih parah: kalau ada fitur "cari by slug" di masa depan, langsung crash.
- **Fix:** Auto-generate slug dari title di backend (pakai `Str::slug()`) dan hilangkan field slug dari form, atau tambahkan validasi `unique` yang lebih ketat + pesan error jelas.

### 2. Tidak ada rate limiting di `update` & `destroy` Post
- **Lokasi:** `routes/web.php`, baris 46–48
- **Masalah:** Hanya `store` yang pakai `throttle:20,1`. `update` dan `destroy` bebas di-spam.
- **Risiko:** Brute-force modifikasi / penghapusan massal oleh bot yang sudah login.
- **Fix:** Tambahkan `->middleware('throttle:10,1')` pada group update/destroy.

### 3. File storage tidak dihapus kalau update gagal setelah upload (Race condition edge case)
- **Lokasi:** `PostController@update`, baris 41–48
- **Masalah:** File baru disimpan dulu (`store()`), baru update DB. Kalau update DB gagal (extremely rare tapi possible), file baru tetap ada di storage tapi tidak direferensi.
- **Risiko:** Garbage file accumulation.
- **Fix:** Gunakan transaction DB atau hapus file baru kalau update gagal.

---

## P1 — High (Fungsionalitas & UX)

### 4. User biasa bisa register tapi tidak punya akses apa-apa (UX Dead-end)
- **Lokasi:** `RegisterController@store`
- **Masalah:** Route `/register` masih aktif. User bisa daftar, login, tapi karena `is_admin` default `false` / `null`, mereka tidak bisa buat artikel. Tombol "+ Buat Artikel" di navbar muncul untuk SEMUA user `@auth`, tapi route-nya diprotect `EnsureUserIsAdmin`.
- **Risiko:** User biasa klik "+ Buat Artikel" → 403 Forbidden. Pengalaman sangat membingungkan.
- **Fix (pilih satu):**
  - **A.** Hapus route register sama sekali (blog ini memang single-admin).
  - **B.** Atau ubah navbar: tombol "+ Buat Artikel" hanya muncul kalau `auth()->user()->is_admin`.
  - **C.** Atau arahkan register ke permintaan akses / kontak admin.

### 5. Tombol "+ Buat Artikel" muncul untuk user non-admin (Bug UI)
- **Lokasi:** `resources/views/posts/index.blade.php`, baris 40–43
- **Masalah:** Tombol "+ Buat Artikel" ada di dalam `@auth`, tapi TIDAK dicek `is_admin`. Non-admin klik → 403.
- **Fix:** Bungkus dengan `@if(auth()->user()->is_admin)`.

### 6. Tidak ada soft delete & riwayat perubahan
- **Lokasi:** `PostController@destroy`
- **Masalah:** Hapus = hilang selamanya. Tidak ada konfirmasi "kembalikan".
- **Risiko:** Human error menghapus artikel penting.
- **Fix:** Implementasi `SoftDeletes` pada model Post + halaman "Artikel Terhapus" di admin.

### 7. Tidak ada manajemen gambar yang robust
- **Lokasi:** `PostController@store` & `@update`
- **Masalah:**
  - Gambar lama dihapus langsung dari disk saat update. Tidak ada backup.
  - Tidak ada resize/compress otomatis. User upload foto 10MB → langsung disimpan utuh.
  - Tidak ada validasi dimensi gambar.
- **Fix:** Pakai library seperti `spatie/laravel-image-optimizer` atau `intervention/image` untuk resize + compress.

### 8. Konten artikel plain text — tidak ada rich text / formatting
- **Lokasi:** `resources/views/posts/show.blade.php`, baris 137–138
- **Masalah:** `{{ $post->content }}` di-render sebagai plain text dengan `whitespace-pre-line`. User tidak bisa bold, list, link, dsb.
- **Fix:** Integrasi editor WYSIWYG (TinyMCE, Tiptap, atau CKEditor) + sanitasi HTML output.

---

## P2 — Medium (Maintainability & Skalabilitas)

### 9. Tidak ada Policy / Gate untuk authorization
- **Lokasi:** Seluruh controller
- **Masalah:** Semua cek admin dilakukan via middleware `EnsureUserIsAdmin`. Ini OK untuk sekarang, tapi tidak scalable kalau nanti ada fitur "editor" vs "admin".
- **Fix:** Buat `PostPolicy` dengan method `create`, `update`, `delete` dan pakai `$this->authorize()` di controller.

### 10. Tidak ada API Resource / transformer
- **Lokasi:** `PostController`
- **Masalah:** Controller langsung return View dengan model mentah. Kalau nanti butuh API JSON, harus refactor besar.
- **Fix:** Buat `PostResource` untuk standarisasi output.

### 11. Tidak ada scope / repository pattern untuk query
- **Lokasi:** `PostController@index`
- **Masalah:** `Post::latest()->paginate(9)` hardcoded. Tidak ada filter kategori, pencarian, atau sorting.
- **Fix:** Buat scope seperti `scopePublished()`, `scopeSearch($query, $term)`.

### 12. Tidak ada logging aktivitas admin
- **Lokasi:** —
- **Masalah:** Siapa yang edit/hapus artikel? Tidak ada jejak.
- **Fix:** Tambahkan package `spatie/laravel-activitylog` atau log manual di controller.

### 13. Test suite gagal total karena SQLite driver tidak tersedia
- **Lokasi:** `phpunit.xml`
- **Masalah:** `DB_CONNECTION=sqlite` & `DB_DATABASE=:memory:`, tapi environment Windows Laragon tidak punya SQLite PDO driver.
- **Fix:** Install extension `pdo_sqlite` di PHP Laragon, atau ganti test DB ke MySQL test database.

### 14. Test `ExampleTest` gagal (route `/` redirect 302, bukan 200)
- **Lokasi:** `tests/Feature/ExampleTest.php`
- **Masalah:** Route `/` redirect ke `/posts` (302), tapi test expect 200.
- **Fix:** Update test: `$response->assertRedirect('/posts')` atau hapus test ini.

### 15. `UserFactory` tidak set `is_admin`
- **Lokasi:** `database/factories/UserFactory.php`
- **Masalah:** Factory tidak generate `is_admin`, padahal test butuh admin user.
- **Fix:** Tambahkan state `admin()` di factory: `$this->state(fn () => ['is_admin' => true])`.

---

## P3 — Low (Polish & Enhancement)

### 16. Tidak ada meta tag SEO
- **Lokasi:** Seluruh view
- **Masalah:** Tidak ada `<meta name="description">`, Open Graph, Twitter Card, structured data.
- **Fix:** Tambahkan di layout master atau per halaman.

### 17. Tidak ada RSS feed / sitemap
- **Lokasi:** —
- **Masalah:** Blog tidak bisa di-subscribe atau di-index search engine dengan optimal.
- **Fix:** Buat route `/feed.xml` dan `/sitemap.xml`.

### 18. Tidak ada komentar / interaksi pembaca
- **Lokasi:** —
- **Masalah:** Blog one-way communication.
- **Fix:** Integrasi Disqus atau buat sistem komentar native.

### 19. Tidak ada analytics dasar
- **Lokasi:** —
- **Masalah:** Tidak tahu artikel mana yang populer.
- **Fix:** Tambahkan view counter di tabel `posts` atau integrasi Google Analytics.

### 20. Footer copyright typo / inkonsisten
- **Lokasi:** `resources/views/posts/index.blade.php` baris 295 vs `show.blade.php` baris 175
- **Masalah:** Index: `© 2025 BLOG. RIFKY ADITYA .` — Show: `© 2025 Blog. All rights reserved.`
- **Fix:** Gunakan layout partial agar konsisten.

---

## Ringkasan Eksekusi Rekomendasi

| Prioritas | Jumlah | Fokus Utama |
|---|---|---|
| P0 Critical | 3 | Keamanan & data integrity |
| P1 High | 5 | UX & fitur core |
| P2 Medium | 7 | Maintainability & testing |
| P3 Low | 5 | Polish & growth |

**Sprint 1 (Minggu ini):** Perbaiki P0 + P1 no. 4, 5 (bug auth/ui).  
**Sprint 2:** P1 no. 6, 7, 8 (soft delete, image management, editor).  
**Sprint 3:** P2 (testing, policy, scope).  
**Sprint 4:** P3 (SEO, RSS, komentar).
