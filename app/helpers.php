<?php

/**
 * mediaUrl($path)
 *
 * Helper untuk menampilkan gambar yang kompatibel dengan Hostinger Shared Hosting.
 * Menangani dua format path:
 *   - Path baru: "uploads/portfolios/xxx.jpg" → dari public/uploads/
 *   - Path lama: "portfolios/xxx.jpg"          → dari storage/app/public/ (via symlink)
 *     Jika file sudah dipindah ke public/uploads/, akan otomatis menggunakan format baru.
 */
if (!function_exists('mediaUrl')) {
    function mediaUrl(?string $path): string
    {
        if (!$path) {
            return '';
        }

        // Sudah format baru (mulai dengan "uploads/")
        if (str_starts_with($path, 'uploads/')) {
            return asset($path);
        }

        // Format lama dari storage — cek apakah sudah ada di public/uploads/
        $newPath = 'uploads/' . $path;
        if (file_exists(public_path($newPath))) {
            return asset($newPath);
        }

        // Fallback: coba via storage symlink
        return asset('storage/' . $path);
    }
}
