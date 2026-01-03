# Git Workflow Guide: Telyummy Project

## 1. Saat Mulai Fitur Baru
Jangan pernah coding langsung di branch `main`!

```bash
# 1. Pindah ke main dulu & update
git checkout main
git pull origin main

# 2. Bikin branch baru dari main
git checkout -b nama-fitur-baru
# Contoh: git checkout -b fitur-dashboard-penjual
```

## 2. Saat Mau Simpan Perubahan (Commit & Push)
Lakukan ini sesering mungkin saat coding di branch fitur.

```bash
# 1. Simpan perubahan lokal
git add .
git commit -m "pesan: sedang bikin apa"

# 2. Upload ke GitHub (pertama kali)
git push -u origin nama-fitur-baru

# 3. Upload selanjutnya (kalau sudah pernah push -u)
git push
```

## 3. Saat Pindah Perubahan 'Gantung' ke Branch Baru
Kalau terlanjur coding di `main` tapi belum di-commit:

```bash
# Pindah branch + bawa perubahan
git checkout -b nama-branch-baru
git add .
git commit -m "fix: pindahin codingan dari main"
git push -u origin nama-branch-baru
```

## 4. Cara Menggabungkan ke Main (Merge)

### Opsi A: Via GitHub (Pull Request) - RECOMMENDED
1. Push branch fitur kamu ke GitHub.
2. Buka GitHub Repo di browser.
3. Klik tab **Pull Requests** -> **New Pull Request**.
4. Base: `main` <- Compare: `nama-fitur-kamu`.
5. Klik **Create Pull Request**.
6. Minta teman review, lalu klik **Merge Pull Request**.

### Opsi B: Via Terminal (Manual)
Hanya lakukan jika yakin tidak ada konflik.

```bash
# 1. Balik ke main
git checkout main

# 2. Update main (penting!)
git pull origin main

# 3. Gabungkan branch fitur ke main
git merge nama-fitur-kamu

# 4. Upload main yang sudah terupdate
git push origin main
```

## 5. Cara Teman Mengetes Branch Kamu
Jika teman ingin mencoba hasil kerja kamu di laptop mereka:

```bash
# 1. Update list branch dari GitHub
git fetch origin

# 2. Pindah ke branch kamu (otomatis tracking)
git checkout rafie-safaraz

# 3. Update database (jika kamu ada nambah kolom/tabel baru)
php artisan migrate

# 4. Link Storage (PENTING: Agar gambar muncul)
php artisan storage:link

# 5. Jalankan aplikasi seperti biasa
npm run dev
php artisan serve
```
