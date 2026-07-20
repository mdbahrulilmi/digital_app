# 🚀 Digital App - Platform Manajemen Program & Produk Digital

**Digital App** adalah aplikasi berbasis web yang dibangun menggunakan **Laravel** untuk mengelola landing page, produk digital, program/kursus, serta transaksi pembayaran secara otomatis mengintegrasikan Payment Gateway **DOKU**. Aplikasi ini dilengkapi dengan *Member Area* interaktif untuk memudahkan pengguna mengakses kelas, materi, jadwal webinar, hingga mengumpulkan tugas harian/jurnal.

## ✨ Fitur Utama

### 1. 🌐 Landing Page Management
* Configurasi halaman + Fitur SEO
* Mengubah tampilan halaman seperti Wordpress.

### 2. 🛍️ Management Product & Program
* **Product:** Pengelolaan katalog produk digital (E-book, template, asset, dll.).
* **Program/Kelas:** Pengelolaan program kursus atau *bootcamp* berseri.
* **Manajemen Konten Program:** 
  * Pengisian materi harian/mingguan.
  * Manajemen penugasan (*assignment*).
  * Pengaturan jadwal *webinar* / pertemuan *online*.
  * Comment tugas dan jurnal member.

### 3. 💳 Management Transaksi & Payment Gateway (DOKU)
* Pencatatan riwayat transaksi secara *real-time*.
* Integration **DOKU Payment Gateway** (Virtual Account, Credit Card, E-Wallet, QRIS).
* Otomatisasi perubahan status transaksi (*Pending*, *Success*, *Expired*, *Failed*) via Webhook/Callback.

### 4. 👤 Member Area (Dashboard Member)
* **Dashboard Utama:** Ringkasan aktivitas, produk, dan program yang telah dibeli.
* **Riwayat Transaksi:** Detail tagihan, bukti pembayaran, dan status transaksi.
* **Pengaturan Akun (Settings):** Update profil, ubah kata sandi, dan preferensi notifikasi.

### 5. 📚 Dashboard Program (Ruang Belajar / Kelas Member)
* **Materi Hari Ini:** Akses cepat ke modul/materi yang aktif sesuai *timeline*.
* **Jadwal Webinar:** Link dan pengingat sesi *live webinar*.
* **Input Tugas & Jurnal:** Form pengumpulan tug

## 🚀 Panduan Instalasi (Development)

Pastikan sistem kamu sudah terinstal **PHP >= 8.2**, **Composer**, **Node.js & NPM**, serta **MySQL**.

### Setup
1. **Clone Repository & Install Dependencies:**
   ```bash
   git clone https://github.com/username/digital_app.git
   cd digital_app
   composer install
   npm install && npm run dev
   ```

2. **Environment & App Key:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database & Storage:**
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

4. **Jalankan Server:**
   ```bash
   php artisan serve
   ```

---

## ⚙️ Konfigurasi `.env`

#### Database Setup
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=digital_app_db
DB_USERNAME=root
DB_PASSWORD=
```

#### DOKU Payment Gateway Setup
```env
DOKU_CLIENT_ID=YOUR_DOKU_CLIENT_ID
DOKU_SECRET_KEY=YOUR_DOKU_SECRET_KEY
DOKU_IS_PRODUCTION=false # Set true jika di server produksi
```

---

## 🔒 Konfigurasi Webhook / Callback DOKU

Untuk menerima notifikasi status pembayaran dari DOKU secara otomatis:

1. Daftarkan URL Notification Callback pada Dashboard DOKU Merchant kamu:
   * **URL Callback:** `https://domain-anda.com/api/doku/notification`
2. Pastikan rute API tersebut sudah dikecualikan dari verifikasi CSRF di `app/Http/Middleware/VerifyCsrfToken.php` (Laravel <= 10) atau di `bootstrap/app.php` (Laravel 11+).

---

## 🤝 Kontribusi

1. *Fork* repositori ini.
2. Buat *feature branch* baru (`git checkout -b feature/FiturBaru`).
3. *Commit* perubahan kamu (`git commit -m 'Menambahkan fitur baru'`).
4. *Push* ke branch (`git push origin feature/FiturBaru`).
5. Buat **Pull Request**.

---

## 👤 Pembuat & Pengembang

* **Pengembang Utama:** Muhammad Bahrul Ilmi
* **Email:** mdbahrulilmi@gmail.com
* **GitHub:** [@mdbahrulilmi](https://github.com/mdbahrulilmi)