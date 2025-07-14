# Dokumentasi Perubahan Sistem Data Penumpang

## Perubahan yang Dilakukan

### 1. Penghapusan Sistem Karyawan Lama

-   ✅ Hapus Model `Karyawan.php`
-   ✅ Hapus Controller `KaryawanController.php`
-   ✅ Hapus Request Classes `StoreKaryawanRequest.php` dan `UpdateKaryawanRequest.php`
-   ✅ Hapus Policy `KaryawanPolicy.php`
-   ✅ Hapus Observer `KaryawanObserver.php`
-   ✅ Hapus Views folder `resources/views/karyawan/`
-   ✅ Hapus Migration `2025_07_10_184844_create_karyawan_table.php`
-   ✅ Drop table `karyawan` dari database

### 2. Implementasi Sistem Data Manifes Penumpang

#### A. Database & Model

-   ✅ **Migration**: `2025_01_11_000001_create_penumpang_table.php`

    -   Kolom: user_id, usia, jenis_kelamin, tujuan, tanggal, nopol, jenis_kendaraan, nomor_tiket, url_image_tiket, status
    -   Indexes untuk optimasi query: user_id, tanggal, status, created_at, nomor_tiket, jenis_kelamin, tujuan, jenis_kendaraan

-   ✅ **Model**: `app/Models/Penumpang.php`
    -   Relationship dengan User
    -   Scopes untuk filtering: byStatus, byDateRange, search, ownData
    -   Accessors untuk label: status_label, jenis_kelamin_label

#### B. Controller & Business Logic

-   ✅ **Controller**: `app/Http/Controllers/PenumpangController.php`
    -   CRUD operations lengkap
    -   Role-based authorization (user: own data, manager/admin: all data)
    -   Caching untuk performance
    -   Bulk operations (update status)
    -   Export data (CSV & JSON)
    -   File upload handling untuk foto tiket

#### C. Authorization & Security

-   ✅ **Policy**: `app/Policies/PenumpangPolicy.php`
    -   user: hanya bisa CRUD data sendiri
    -   manager: bisa mengelola semua data penumpang
    -   admin: bisa mengelola user dan data penumpang

#### D. Validation

-   ✅ **Request Classes**:
    -   `StorePenumpangRequest.php`: Validasi untuk create
    -   `UpdatePenumpangRequest.php`: Validasi untuk update
    -   Custom error messages dalam bahasa Indonesia

#### E. Views & Frontend

-   ✅ **Views**:
    -   `index.blade.php`: List data dengan filtering, searching, pagination, bulk actions
    -   `create.blade.php`: Form tambah data
    -   `edit.blade.php`: Form edit data
    -   `show.blade.php`: Detail data dengan modal foto tiket

#### F. Caching & Performance

-   ✅ **Observer**: `app/Observers/PenumpangObserver.php`
    -   Auto cache clearing saat ada perubahan data
    -   Cache keys: dashboard_stats, penumpang_stats, recent_penumpang

### 3. Update Sistem Lain

#### A. Routes

-   ✅ Update `routes/web.php`:
    -   Hapus routes karyawan
    -   Tambah routes penumpang lengkap dengan bulk operations

#### B. Navigation & UI

-   ✅ Update `resources/views/components/admin-layout.blade.php`:
    -   Ganti menu "Data Karyawan" → "Data Penumpang"
-   ✅ Update `resources/views/dashboard.blade.php`:
    -   Ganti quick actions karyawan → penumpang
    -   Update statistics panel

#### C. Service Provider

-   ✅ Update `app/Providers/AppServiceProvider.php`:
    -   Daftarkan PenumpangObserver
    -   Daftarkan PenumpangPolicy

### 4. Data Management

#### A. Seeders & Factories

-   ✅ **PenumpangSeeder**: `database/seeders/PenumpangSeeder.php`
    -   Generate 50 data penumpang dummy
    -   Nomor polisi dan tiket otomatis
-   ✅ **PenumpangFactory**: `database/factories/PenumpangFactory.php`
    -   Factory untuk testing dan development

#### B. Database Optimization

-   ✅ **Indexes**:
    -   Primary indexes pada kolom yang sering di-query
    -   Composite indexes untuk performa filtering

## Fitur-Fitur Sistem Baru

### 1. Data Penumpang Lengkap

-   **Informasi Penumpang**: Nama (relasi User), Usia, Jenis Kelamin
-   **Informasi Perjalanan**: Tujuan, Tanggal, Nopol, Jenis Kendaraan
-   **Informasi Tiket**: Nomor Tiket (unique), Foto Tiket, Status (Open/Close)

### 2. Authorization yang Ketat

-   **User**: Hanya bisa CRUD data penumpang dirinya sendiri
-   **Manager**: Bisa mengelola semua data penumpang
-   **Admin**: Bisa mengelola user dan data penumpang

### 3. Performance Optimizations

-   **Caching**: Dashboard stats, recent data, bulk operations
-   **Database Indexes**: Optimasi query untuk pencarian dan filtering
-   **Lazy Loading**: Minimal data selection untuk list view
-   **Bulk Operations**: Update status multiple records sekaligus

### 4. User Experience

-   **Advanced Filtering**: Status, tanggal, pencarian text
-   **Export Data**: CSV dan JSON format
-   **Bulk Actions**: Update status multiple data
-   **Image Upload**: Foto tiket dengan preview dan modal
-   **Responsive Design**: Mobile-friendly interface

### 5. Security Features

-   **File Upload Validation**: Type, size, security checks
-   **CSRF Protection**: Semua forms protected
-   **Role-based Access**: Strict authorization rules
-   **Data Sanitization**: Input validation dan escaping

## Cara Menggunakan

### 1. Akses Sistem

-   Login dengan user yang telah dibuat
-   Dashboard menampilkan statistik dan data terbaru

### 2. Mengelola Data Penumpang

-   **User**: Bisa tambah, edit, hapus data penumpang sendiri
-   **Manager/Admin**: Bisa mengelola semua data penumpang
-   **Bulk Operations**: Pilih multiple data untuk update status

### 3. Export Data

-   Filter data sesuai kebutuhan
-   Klik Export CSV atau JSON
-   File akan ter-download otomatis

### 4. Upload Foto Tiket

-   Saat create/edit data penumpang
-   Upload foto tiket (JPG, PNG, max 2MB)
-   Foto disimpan di storage/public/tiket_photos/

## Status Implementasi (Update Terbaru)

### ✅ Image Fake Tiket Berhasil Dibuat

-   **Total image dibuat**: 100 file SVG (dari 50 penumpang yang di-seed 2x)
-   **Lokasi penyimpanan**: `storage/app/public/tiket_photos/`
-   **Format file**: `tiket_TKT{nomor}_{timestamp}.svg`
-   **Ukuran file**: ~3.5KB per file
-   **Desain**: SVG dengan header, konten tiket, barcode fake, dan QR code fake

### ✅ Data Penumpang Berhasil Di-seed

-   **Total data**: 100 penumpang
-   **Setiap data memiliki**: Image tiket fake yang disimpan di storage
-   **Path image**: Tersimpan di kolom `url_image_tiket`
-   **Akses publik**: Melalui symbolic link `public/storage`

### ✅ Fitur Image Tiket

-   **Pembuatan otomatis**: Setiap kali seeder dijalankan
-   **Format SVG**: Tidak memerlukan library GD/Imagick
-   **Konten realistis**: Nomor tiket, tujuan, tanggal, nopol, jenis kendaraan
-   **Barcode & QR Code**: Simulasi visual untuk tampilan realistis

### ✅ Server Laravel Berjalan

-   **Status**: Aktif di http://127.0.0.1:8001
-   **Database**: Terkoneksi dengan 100 data penumpang
-   **Storage**: Linked dan accessible
-   **Cache**: Aktif dan berfungsi

## Status Implementasi (Update 14 Juli 2025)

### ✅ Penghapusan Fitur Image Tiket

-   **Kolom url_image_tiket**: Dihapus dari database melalui migration
-   **PenumpangSeeder**: Diperbaharui untuk tidak membuat image tiket fake
-   **PenumpangFactory**: Diperbaharui untuk tidak generate url_image_tiket
-   **Model Penumpang**: Kolom url_image_tiket dihapus dari fillable
-   **Storage cleanup**: Folder tiket_photos dihapus dari storage
-   **Data refresh**: Data penumpang di-refresh tanpa kolom image tiket

### ✅ Struktur Data Penumpang (Updated)

-   **user_id**: Relasi ke tabel users
-   **usia**: Usia penumpang (16-65 tahun)
-   **jenis_kelamin**: L (Laki-laki) atau P (Perempuan)
-   **tujuan**: Tujuan perjalanan
-   **tanggal**: Tanggal perjalanan
-   **nopol**: Nomor polisi kendaraan
-   **jenis_kendaraan**: Bus, Minibus, Mobil, Motor, atau Truk
-   **status**: Open/Close (boolean)
-   ~~**url_image_tiket**: Dihapus~~ ❌
-   ~~**nomor_tiket**: Dihapus~~ ❌

### ✅ Penghapusan Kolom Nomor Tiket

-   **Kolom nomor_tiket**: Dihapus dari database melalui migration
-   **PenumpangController**: Semua referensi nomor_tiket dihapus dari select, export, dan logic
-   **DashboardController**: Referensi nomor_tiket dihapus dari recent penumpang
-   **Request Classes**: Validasi nomor_tiket dihapus dari StorePenumpangRequest dan UpdatePenumpangRequest
-   **Views**: Semua field dan tampilan nomor_tiket dihapus dari view index, create, edit, dan show
-   **Data refresh**: Data penumpang di-refresh tanpa kolom nomor_tiket dan url_image_tiket

### ✅ File yang Diperbaharui

-   `/app/Models/Penumpang.php`: Hapus kolom url_image_tiket dan nomor_tiket dari fillable
-   `/database/migrations/2025_07_14_103310_hapus_kolom_url_image_tiket_dari_penumpang_table.php`: Migration baru
-   `/database/migrations/2025_07_14_104125_hapus_kolom_nomor_tiket_dari_penumpang_table.php`: Migration baru
-   `/database/seeders/PenumpangSeeder.php`: Hapus logic pembuatan image tiket dan nomor_tiket
-   `/database/factories/PenumpangFactory.php`: Hapus kolom url_image_tiket dan nomor_tiket
-   `/app/Http/Controllers/PenumpangController.php`: Hapus semua referensi kolom yang dihapus
-   `/app/Http/Controllers/DashboardController.php`: Hapus referensi nomor_tiket dari recent penumpang
-   `/app/Http/Requests/StorePenumpangRequest.php`: Hapus validasi kolom yang dihapus
-   `/app/Http/Requests/UpdatePenumpangRequest.php`: Hapus validasi kolom yang dihapus
-   `/resources/views/penumpang/index.blade.php`: Hapus tampilan kolom yang dihapus
-   `/resources/views/penumpang/create.blade.php`: Hapus field kolom yang dihapus
-   `/resources/views/penumpang/edit.blade.php`: Hapus field kolom yang dihapus
-   `/resources/views/penumpang/show.blade.php`: Hapus tampilan kolom yang dihapus dan modal image
-   `storage/app/public/tiket_photos/`: Folder dihapus

## Hasil Akhir

### ✅ Sistem Penumpang Berhasil Dibangun

1. **Data Penumpang**: 100 data penumpang dengan image tiket fake
2. **Image Tiket**: 100 file SVG tersimpan di storage dengan format realistis
3. **Server**: Laravel berjalan di http://127.0.0.1:8001
4. **Akses Image**: Tiket dapat diakses melalui URL publik
5. **Database**: Terkoneksi dengan data lengkap

### ✅ Fitur yang Telah Berhasil

-   **CRUD Penumpang**: Create, Read, Update, Delete dengan otorisasi
-   **Image Tiket**: Pembuatan dan penyimpanan otomatis
-   **Caching**: Cache otomatis dengan invalidasi via Observer
-   **Authorization**: Role-based access control
-   **Validation**: Server-side validation untuk semua input
-   **Storage**: Public storage untuk image tiket
-   **Seeder**: Fake data generator dengan image

### ✅ Kualitas Kode

-   **Bahasa Indonesia**: Semua variabel, komentar, dan method dalam bahasa Indonesia
-   **Laravel 12**: Menggunakan standar Laravel terbaru
-   **Optimasi**: Query optimization dengan cache dan index
-   **Security**: Proper authorization dan validation
-   **Performance**: Pagination dan efficient queries

### ✅ Testing

-   **Manual**: Semua fitur telah ditest dan berfungsi
-   **Browser**: Image tiket dapat diakses dan ditampilkan
-   **Database**: Data tersimpan dengan benar dan relasi berfungsi
-   **Storage**: File SVG tersimpan dan accessible

## Database Schema

```sql
CREATE TABLE penumpang (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    usia INT NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tujuan VARCHAR(255) NOT NULL,
    tanggal DATE NOT NULL,
    nopol VARCHAR(255) NOT NULL,
    jenis_kendaraan VARCHAR(255) NOT NULL,
    nomor_tiket VARCHAR(255) UNIQUE NOT NULL,
    url_image_tiket VARCHAR(255) NULL,
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_tanggal (tanggal),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    INDEX idx_nomor_tiket (nomor_tiket),
    INDEX idx_jenis_kelamin (jenis_kelamin),
    INDEX idx_tujuan (tujuan),
    INDEX idx_jenis_kendaraan (jenis_kendaraan)
);
```

## Testing

Sistem telah diuji dengan:

-   50 data penumpang dummy
-   Berbagai role user (admin, manager, user)
-   CRUD operations lengkap
-   File upload functionality
-   Bulk operations
-   Export functionality
-   Caching system

## Kesimpulan

Sistem Data Manifes Penumpang telah berhasil menggantikan sistem karyawan lama dengan:

-   ✅ Struktur data yang lebih lengkap dan sesuai kebutuhan
-   ✅ Authorization yang ketat sesuai role
-   ✅ Performance optimization dengan caching dan indexing
-   ✅ User experience yang lebih baik
-   ✅ Security yang terjamin
-   ✅ Kode yang clean dan maintainable

Sistem siap digunakan untuk production dengan kemampuan mengelola data penumpang secara efisien dan aman.
