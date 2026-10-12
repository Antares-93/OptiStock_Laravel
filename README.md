# OptiStock - Sistem Informasi Manajemen Inventaris (Laravel Framework)

OptiStock adalah sistem inventaris toko dan pergudangan berbasis web yang dikembangkan menggunakan **Laravel Framework** dan database **MySQL**. Sistem ini dirancang untuk memberikan transparansi pergerakan stok secara *real-time*, mengotomatisasi perhitungan mutasi barang masuk/keluar, mendeteksi peringatan stok menipis (*low stock warning*), serta mendukung manajemen multi-role dengan antarmuka modern bertema **Emerald & Slate**.

---

## Fitur Utama

### 1. Manajemen Hak Akses (Role-Based Access Control)
* **Administrator (`admin`)**:
  * Akses penuh ke dashboard metrik inventaris (total jenis produk, estimasi nilai total barang, volume masuk & keluar).
  * Manajemen katalog produk: pembuatan produk baru, unggah foto fisik barang, pembaruan data (*edit*), dan penghapusan produk.
  * Transaksi mutasi stok barang masuk (*Stock In*) dan barang keluar (*Stock Out*).
  * Pemantauan rekam jejak log histori mutasi secara menyeluruh.
  * Pengelolaan master data: Kategori barang, Vendor/Supplier, dan pembuatan akun petugas baru.
* **Staff Gudang (`staff`)**:
  * Akses monitoring katalog produk dan ringkasan ketersediaan barang.
  * Pencatatan operasional harian: mencatat stok barang masuk dan stok keluar.
  * Memeriksa riwayat mutasi stok.
  * Proteksi sistem: akses ke master data kategori, supplier, dan manajemen user dibatasi secara otomatis melalui middleware/guard.

### 2. Antarmuka & UX Modern
* **Modern Sidebar Layout:** Navigasi vertikal minimalis di sisi kiri tanpa elemen dekoratif berlebih, dilengkapi pemisah visual yang rapi.
* **Katalog Produk Berbasis Grid:** Tampilan kartu barang (*product cards*) dengan gambar fisik produk, indikator ketersediaan status, dan harga satuan.
* **Horizontal Filter Bar:** Form pencarian terpadu (*search by name/SKU*) dan filter kategori yang diletakkan secara ergonomis di bagian atas.
* **Peringatan Stok Rendah:** Deteksi otomatis produk yang stoknya berada di bawah batas minimum (*early warning system*).
* **Proteksi Mutasi Negatif:** Validasi ketat dengan transaksi basis data (*database transaction & row locking*) untuk mencegah stok bernilai negatif saat transaksi keluar.

---

## Tech Stack & Spesifikasi

* **Framework Backend:** Laravel 11.x / 10.x (PHP 8.2+)
* **Basis Data:** MySQL / MariaDB
* **Template Engine:** Blade Templating
* **Frontend:** Modern CSS Grid & Flexbox (Tema Custom: *Emerald & Slate*)
* **Tipografi:** Google Fonts *Plus Jakarta Sans*
* **Dependency Manager:** Composer & NPM

---

## Akun Demo Pengujian

Aplikasi telah dilengkapi seeder data awal dengan akun pengujian sebagai berikut:

| Peran (Role) | Username | Password | Cakupan Hak Akses |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin` | `admin123` | Akses penuh (Dashboard, CRUD Produk + Foto, Stok, Kategori, Supplier, Users) |
| **Staff Gudang** | `staff` | `staff123` | Akses operasional (Dashboard, Katalog Produk, Stok Masuk & Keluar, Histori) |

---

## Panduan Instalasi & Menjalankan Proyek

### 1. Kebutuhan Sistem
Pastikan perangkat Anda telah terpasang:
* PHP >= 8.2 dengan ekstensi `pdo_mysql`, `mbstring`, `fileinfo`, `gd`
* Composer
* MySQL / MariaDB (via XAMPP, Laragon, atau Docker)

### 2. Kloning / Ekstraksi Proyek
Buka terminal dan arahkan ke direktori proyek:
```bash
cd inventory_app
```

### 3. Instalasi Dependensi PHP
Jalankan Composer untuk mengunduh pustaka vendor:
```bash
composer install
```

### 4. Konfigurasi Environment (`.env`)
Salin berkas `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan koneksi database MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_app
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Migrasi & Seeding Database
Jalankan migrasi skema tabel dan isi data awal:
```bash
php artisan migrate --seed
```

### 7. Menjalankan Server Lokal
Nyalakan server development Laravel:
```bash
php artisan serve
```
Buka browser dan akses aplikasi pada URL:
```text
http://127.0.0.1:8000
```

---

## Struktur Arsitektur Direktori (Core Architecture)

Struktur file fungsional utama yang dibangun di dalam aplikasi:

```text
inventory_app/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php          # Logika autentikasi & sesi pengguna
│   │   ├── CategoryController.php      # Manajemen master data kategori
│   │   ├── DashboardController.php     # Perhitungan metrik & status inventaris
│   │   ├── ProductController.php       # CRUD katalog & upload foto produk
│   │   ├── StockController.php         # Transaksi stok masuk/keluar & histori
│   │   ├── SupplierController.php      # Manajemen master data vendor/supplier
│   │   └── UserController.php          # Manajemen hak akses & akun pengguna
│   └── Models/
│       ├── Category.php                # Relasi kategori barang
│       ├── Product.php                 # Entitas produk & ketersediaan stok
│       ├── StockMovement.php           # Log mutasi barang (in/out)
│       ├── Supplier.php                # Entitas supplier
│       └── User.php                    # Model pengguna & otorisasi role
│
├── database/
│   ├── migrations/                     # Skema tabel database (DDL)
│   └── seeders/
│       └── DatabaseSeeder.php          # Data awal pengguna, kategori, & produk
│
├── public/
│   ├── css/
│   │   └── style.css                   # Desain antarmuka kustom (Emerald Theme)
│   └── uploads/
│       └── products/                   # Media penyimpanan gambar produk fisik
│
├── resources/views/                    # Template UI (Blade)
│   ├── auth/
│   │   └── login.blade.php             # Form login ringkas & responsif
│   ├── categories/
│   │   └── index.blade.php             # Master kategori & jumlah keterkaitan produk
│   ├── layouts/
│   │   └── app.blade.php               # Master shell (Sidebar navigasi & topbar)
│   ├── products/
│   │   ├── create.blade.php            # Form produk baru dengan unggah foto
│   │   ├── edit.blade.php              # Form edit data produk & ganti gambar
│   │   └── index.blade.php             # Katalog produk grid & filter horizontal
│   ├── stock/
│   │   ├── history.blade.php           # Riwayat mutasi stok barang
│   │   ├── in.blade.php                # Form transaksi stok masuk
│   │   └── out.blade.php               # Form transaksi stok keluar
│   ├── suppliers/
│   │   └── index.blade.php             # Master supplier & informasi kontak
│   ├── users/
│   │   └── index.blade.php             # Kelola akun admin dan staf gudang
│   └── dashboard.blade.php             # 4 Kartu metrik & peringatan stok menipis
│
├── routes/
│   └── web.php                         # Definisi rute, auth guard, & RBAC admin
│
├── .env.example                        # Template konfigurasi environment
├── composer.json                       # Konfigurasi paket dependensi backend
└── README.md                           # Dokumentasi teknis proyek
```

---

## Keamanan & Integritas Data

1. **CSRF Protection:** Seluruh form transaksi (POST, PUT, DELETE) dilindungi token `@csrf`.
2. **Database Concurrency:** Mutasi stok keluar dan masuk dieksekusi di dalam `DB::transaction()` dengan proteksi row locking (`lockForUpdate()`) guna menghindari selisih stok (*race condition*).
3. **Mass Assignment Prevention:** Penggunaan properti `$fillable` pada setiap Eloquent Model untuk mencegah injeksi kolom yang tidak diizinkan.
4. **Validasi File Upload:** Pemeriksaan tipe MIME berkas gambar (`jpeg,png,jpg,webp`) serta batasan ukuran file maksimal sebesar 2 MB.
