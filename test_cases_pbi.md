# Detailed Test Case Report: MindFlow Kelompok E

Laporan pengujian otomatis menggunakan Laravel Dusk untuk PBI 4, 13, dan 14.

| PBI ID | Case ID | Test Scenario | Type | Test Case | Pre Condition | Steps | Steps Description | Expected Result | Status (Pass/Fail) | Keterangan |
| :--- | :--- | :--- | :--- | :--- | :--- | :---: | :--- | :--- | :---: | :--- |
| **PBI 4** | **TC-4.1** | Login Sukses | Positive | Masuk ke sistem dengan data valid | User berada di halaman login | 1<br>2<br>3<br>4 | Masukkan email terdaftar<br>Masukkan password yang benar<br>Klik tombol "Masuk"<br>Periksa halaman tujuan | Diarahkan ke Dashboard (`/home`) | **PASS** | Berhasil login dan masuk ke home |
| **PBI 4** | **TC-4.2** | Login Gagal | Negative | Login menggunakan password salah | User berada di halaman login | 1<br>2<br>3 | Masukkan email terdaftar<br>Masukkan password yang salah<br>Klik tombol "Masuk" | Tetap di halaman Login + Error | **PASS** | Sistem menolak password salah |
| **PBI 4** | **TC-4.3** | Pendaftaran Akun | Positive | Mendaftar akun baru | User berada di halaman register | 1<br>2<br>3<br>4 | Isi form pendaftaran lengkap<br>Isi Password & Konfirmasi<br>Klik tombol "Buat Akun"<br>Periksa halaman tujuan | Akun terbuat dan masuk ke Dashboard | **PASS** | Registrasi berhasil 100% |
| **PBI 4** | **TC-4.4** | Akses Tanpa Auth | Negative | Mengakses home sebagai guest | User belum login (Guest) | 1 | Buka URL Dashboard secara langsung | Dialihkan ke halaman Login | **PASS** | Proteksi middleware berjalan |
| **PBI 13** | **TC-13.1** | Update Profil | Positive | Mengubah Nama & Nama Samaran | User di halaman Settings | 1<br>2<br>3 | Ubah Nama Asli & Nama Samaran<br>Klik "Simpan Perubahan"<br>Periksa notifikasi | Muncul pesan sukses update | **PASS** | Profil terupdate di DB |
| **PBI 13** | **TC-13.2** | Update Gagal | Negative | Nama Samaran duplikat | User di halaman Settings | 1<br>2<br>3 | Masukkan Nama Samaran milik user lain<br>Klik "Simpan Perubahan"<br>Periksa validasi | Muncul error Nama Samaran sudah ada | **PASS** | Validasi unique berfungsi |
| **PBI 13** | **TC-13.3** | Ubah Password | Positive | Mengganti password akun | User di halaman Settings | 1<br>2<br>3 | Masukkan Password Baru & Konfirmasi<br>Klik "Simpan Perubahan"<br>Periksa status | Password berubah (muncul sukses) | **PASS** | Ganti password berhasil |
| **PBI 13** | **TC-13.4** | Gagal Ganti Pass | Negative | Password konfirmasi beda | User di halaman Settings | 1<br>2<br>3 | Masukkan Password Baru<br>Masukkan Konfirmasi yang berbeda<br>Klik "Simpan Perubahan" | Muncul error konfirmasi tidak cocok | **PASS** | Validasi password match oke |
| **PBI 14** | **TC-14.1** | Akses FAQ | Positive | Membuka halaman bantuan | User sebagai Guest | 1<br>2 | Klik menu FAQ atau buka URL `/faq`<br>Lihat konten | Halaman FAQ terbuka sempurna | **PASS** | FAQ bisa diakses publik |
| **PBI 14** | **TC-14.2** | Akses Terlarang | Negative | Mencoba masuk area member | User sebagai Guest | 1 | Mencoba buka URL `/journals` | Dialihkan ke Login | **PASS** | Proteksi area member sukses |
| **PBI 14** | **TC-14.3** | Logout Sukses | Positive | Keluar dari sistem | User sudah login | 1<br>2<br>3 | Klik profil di sidebar<br>Klik tombol "Logout"<br>Periksa status sesi | Sesi berakhir dan kembali ke Beranda | **PASS** | Logout berhasil membersihkan sesi |
| **PBI 14** | **TC-14.4** | Back After Logout | Negative | Klik back setelah logout | User sudah logout | 1<br>2 | Klik tombol "Back" browser<br>Coba akses fitur Dashboard | Diminta login kembali | **PASS** | Sesi tidak bisa dipulihkan via back |

---
**Status Akhir Pengujian:** Seluruh skenario di atas telah diuji menggunakan **Laravel Dusk** dengan hasil **100% SUCCESS (PASSED)**.
