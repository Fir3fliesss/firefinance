# Needs to Know: Aplikasi Jasa Keuangan (Fintech E-Commerce)

Dokumen ini disusun sebagai panduan **"Needs to Know"** untuk keperluan Ujian Keahlian Kompetensi. Dokumen ini merangkum seluruh aspek krusial dari proyek platform E-Commerce Jasa Keuangan yang telah dirancang.

> [!IMPORTANT]
> Proyek ini bukan aplikasi e-commerce barang fisik biasa, melainkan platform eksklusif untuk menjual jasa atau layanan keuangan (Fintech), seperti Konsultan Keuangan dan *Financial Planner*.

---

## 1. Konsep Utama (Core Concept)
Aplikasi ini adalah **E-Commerce Layanan Keuangan (Fintech)** premium yang berfokus pada **akuntabilitas tinggi** dan **nuansa profesionalisme**. Berbeda dengan toko online pada umumnya, proyek ini bertindak sebagai jembatan antara klien dan konsultan dengan mengedepankan rekam jejak transaksi yang jelas, validasi pengguna, dan penagihan (invoice) yang terstruktur. 

---

## 2. Tema & Desain (Theme & UI/UX)
Platform ini mengadopsi tema **"Wealth" (Kekayaan) dan Profesionalisme**, dirancang agar pengguna merasa aman dan percaya untuk membeli layanan keuangan.

*   **Desain Minimalis & Bersih**: Hanya menampilkan data yang esensial dengan hierarki yang sangat jelas. Tidak ada elemen visual yang berlebihan.
*   **Estetika Tajam & Elegan (Glassmorphism & Claymorphism)**: Menggunakan tekstur kaca (translucent) dan finishing tipe *matte* atau *metallic* untuk memberi kesan mahal, premium, dan modern.
*   **Palet Warna "Money Atmosphere"**: 
    *   Warna Dasar: Putih bersih.
    *   Warna Aksen: Hijau zamrud (Emerald Growth Green - `#10B981`) yang melambangkan pertumbuhan finansial, warna *Slate* gelap untuk teks dan bayangan, serta aksen warna emas (Gold) untuk menonjolkan fitur eksklusif.
*   **Tipografi**: Menggunakan font modern (seperti Inter) untuk teks utama agar mudah dibaca, dikombinasikan dengan sentuhan font Serif (seperti Cormorant Garamond) pada judul untuk kesan klasik dan mapan.

---

## 3. Keunggulan Platform (Key Advantages)
> [!TIP]
> Ini adalah poin-poin yang bisa ditonjolkan saat presentasi ujian kompetensi untuk menunjukkan nilai jual sistem.

1.  **Akuntabilitas Transaksi yang Tinggi (High Accountability)**
    Setiap transaksi wajib melalui proses login (tidak ada *guest checkout*). Hal ini memastikan semua aktivitas dapat dilacak, diaudit, dan dipertanggungjawabkan baik oleh klien maupun penyedia jasa (Admin).
2.  **Sistem Invoicing Terintegrasi**
    Aplikasi dapat mencetak, melihat, dan mengunduh Invoice dalam bentuk PDF dengan layout yang profesional (dilengkapi *watermark* dan QR Code verifikasi), meningkatkan tingkat kepercayaan klien.
3.  **Checkout Instan via WhatsApp**
    Untuk mempercepat deal bisnis dan layanan kustom, pembayaran dan konsultasi lanjutan dihubungkan langsung menggunakan WhatsApp Bisnis yang memuat informasi ringkasan pesanan secara otomatis.
4.  **Manajemen Layanan Finansial Terpilah**
    Sistem keranjang belanja disesuaikan menjadi "Keranjang/Bucket Layanan", dan fitur Wishlist dibentuk dengan terminologi target masa depan *(Future Goals)*.

---

## 4. Fitur-Fitur Utama (Core Features)

### A. Fitur Pengguna & Keamanan (Authentication & RBAC)
*   Sistem registrasi & login pengguna standar.
*   Pembagian hak akses pengguna (*Roles*):
    *   **Admin**: Manajemen penuh terhadap riwayat transaksi klien dan katalog layanan (CRUD Layanan Finansial).
    *   **Client**: Akses Dashboard pribadi untuk melihat layanan keuangan yang sedang aktif/berjalan dan riwayat pembelian.

### B. Katalog & Navigasi Layanan
*   Katalog khusus yang memprioritaskan jasa Konsultan dan *Financial Planner*.
*   Fitur **"Future Goals"** (Wishlist) untuk menyimpan plan keuangan yang tertunda.
*   Sistem bundling pesanan/layanan dengan keranjang belanja (*Bucket*).

### C. Dashboard Klien & Admin
*   **Admin**: Monitoring analitik klien, mengubah status pembayaran (*Pending, Paid, Cancelled, Active*), dan manajemen layanan.
*   **Klien**: Papan kontrol interaktif untuk melacak status pesanan layanan dan memanajemen dokumen invoice (cetak langsung via *Print Support* web atau unduh PDF).

---

## 5. Alur Proses Bisnis

1.  **Eksplorasi**: Pengguna mengunjungi situs dan mengeksplorasi layanan.
2.  **Keputusan Berinvestasi**: Pengguna menambahkan layanan yang mereka butuhkan ke Keranjang.
3.  **Kewajiban Login**: Sistem akan memaksa pengguna untuk login/register untuk keperluan akuntabilitas data.
4.  **Checkout**: Pengguna akan meninjau ringkasan pesanan/layanan keuangan.
5.  **Pembuatan Invoice & Redirect**: Sistem di *backend* membuat draft Order serta dokumen Invoice, lalu mengarahkan *(redirect)* klien ke WhatsApp milik konsultan/pemilik sistem untuk konfirmasi pembayaran aktual.
6.  **Pengelolaan (Admin)**: Admin mengkonfirmasi pembayaran dan mengubah status order, klien lalu dapat mengunduh Invoice resmi dari *dashboard* mereka.

---

## 6. Teknologi yang Digunakan (Tech Stack)
*   **Backend**: Laravel 12 (Modern PHP Framework untuk keamanan dan kestabilan bisnis).
*   **Frontend**: Blade Engine + Tailwind CSS (Untuk desain UI yang sangat *custom* dan ringan).
*   **Database**: SQLite (Untuk kesederhanaan *deployment* dan struktur yang *compact* namun kuat).
*   **Fungsi Khusus**: *PDF Generator* untuk manipulasi dokumen Invoice.
