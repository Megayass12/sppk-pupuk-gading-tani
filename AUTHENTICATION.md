# Panduan Autentikasi SPK Supplier Pupuk

## ✅ Status Implementasi

Sistem autentikasi lengkap telah diimplementasikan dengan fitur-fitur berikut:

### Fitur yang Telah Diterapkan
- ✅ Halaman login dengan desain hijau seragam
- ✅ Autentikasi user dengan username dan password
- ✅ Verifikasi CSRF token pada semua form POST/PUT/PATCH/DELETE
- ✅ Proteksi rute dengan middleware authentication
- ✅ Session management dan regenerasi ID session
- ✅ Logout dengan session invalidation
- ✅ Data user login ditampilkan di topbar
- ✅ Tombol logout di halaman utama
- ✅ Desain warna hijau seragam di seluruh aplikasi

## Setup Awal

Setelah melakukan perubahan ini, jalankan perintah berikut untuk setup database:

```bash
# Migrate database dan seed data awal
php artisan migrate:refresh --seed
```

## Kredensial Login Default

Setelah menjalankan seeder, Anda dapat login dengan:

### Admin User
- **Username:** `admin`
- **Password:** `password123`

### Manager User
- **Username:** `manager`
- **Password:** `password123`

## Fitur Keamanan

### CSRF Token Protection
- Semua form POST, PUT, PATCH, DELETE dilindungi dengan CSRF token
- Token CSRF otomatis disertakan dalam setiap form menggunakan `@csrf`
- Middleware VerifyCsrfToken diaktifkan secara default untuk rute web
- Token CSRF diregenerasi saat logout untuk keamanan maksimal

### Session Management
- Session ID diregenerasi setelah login berhasil
- Session diinvalidate saat logout
- Token CSRF diregenerasi saat logout

### Authentication Middleware
- Rute yang dilindungi memerlukan user untuk login
- User yang tidak login akan diarahkan ke halaman login
- Semua rute kecuali `/login` dilindungi dengan middleware `auth`

### Password Security
- Password di database di-hash menggunakan bcrypt
- Password hanya diterima dari input form, tidak disimpan dalam plaintext
- Perbandingan password dilakukan secara aman oleh Laravel

## Struktur File Autentikasi

- `app/Http/Controllers/AuthController.php` - Kontroller autentikasi (login/logout)
- `app/Http/Middleware/Authenticate.php` - Middleware untuk verifikasi autentikasi
- `resources/views/login.blade.php` - View halaman login dengan warna hijau
- `resources/views/layouts/app.blade.php` - Layout utama dengan logout button
- `database/seeders/UserSeeder.php` - Seeder untuk data user awal
- `routes/web.php` - Route configuration
- `bootstrap/app.php` - Middleware configuration

## Design & User Interface

### Halaman Login
- Warna background: Gradient hijau (#2d6a4f ke #52b788)
- Card putih dengan shadow
- Input field dengan border hijau saat focus
- Tombol Masuk dengan gradient hijau
- Error messages dengan styling yang jelas

### Dashboard (Setelah Login)
- Sidebar hijau dengan menu navigasi
- Topbar dengan informasi user yang login
- Tombol Logout dengan warna merah untuk visibility
- Status "Logged in as [Username]"

## Cara Kerja

### Proses Login
1. User membuka `/login`
2. User memasukkan username dan password
3. Form dikirim dengan CSRF token yang terverifikasi
4. `AuthController@login` memvalidasi input
5. Auth attempt dengan `name` (username) dan password
6. Jika berhasil: session di-regenerate, redirect ke `/supplier`
7. Jika gagal: kembali ke login dengan error message

### Proses Logout
1. User klik tombol Logout
2. Form POST dikirim ke `/logout` dengan CSRF token
3. `AuthController@logout` dijalankan
4. Session di-invalidate
5. CSRF token di-regenerate
6. Redirect ke `/login` dengan success message

## Mengubah Password

Untuk mengubah password user, gunakan Artisan tinker:

```bash
php artisan tinker
```

Kemudian jalankan:
```php
$user = User::where('username', 'admin')->first();
$user->password = Hash::make('password_baru');
$user->save();
```

## Testing Login

Untuk memverifikasi sistem autentikasi:

1. Buka aplikasi di `http://localhost:8000`
2. Anda akan diarahkan ke halaman login
3. Login dengan username: `admin` dan password: `password123`
4. Dashboard akan ditampilkan
5. Klik tombol Logout untuk test logout
6. Anda akan kembali ke halaman login

## Keamanan Tambahan

### Best Practices yang Diterapkan
1. **CSRF Protection**: Semua form POST dilindungi token CSRF
2. **Session Regeneration**: ID session diubah setelah login
3. **Session Invalidation**: Session dihapus saat logout
4. **Password Hashing**: Password di-hash dengan bcrypt
5. **Redirect After Login**: User diarahkan ke halaman intended (atau supplier index)
6. **Middleware Authentication**: Rute dilindungi dengan middleware auth

### Rekomendasi untuk Production
1. Gunakan environment variables untuk konfigurasi sensitif
2. Enable HTTPS untuk semua request
3. Implementasikan rate limiting untuk login attempts
4. Gunakan 2FA (Two-Factor Authentication)
5. Monitoring dan logging untuk aktivitas login/logout
6. Timeout session yang lebih pendek
7. Implementasikan audit trail
