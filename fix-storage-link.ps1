# Script untuk memperbaiki storage link
# Jalankan dengan: .\fix-storage-link.ps1

Write-Host "Menghapus symlink lama (jika ada)..." -ForegroundColor Yellow
Remove-Item "public\storage" -Force -ErrorAction SilentlyContinue

Write-Host "Membuat symlink baru..." -ForegroundColor Yellow
php artisan storage:link

Write-Host "Selesai! Silakan refresh halaman." -ForegroundColor Green

