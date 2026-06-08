<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingPageContent;

class LandingPageContentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // ==================== HERO SECTION ====================
            ['key' => 'hero_badge',        'label' => 'Badge Text (atas)',        'value' => 'Professional Technology Solutions · Since 2014', 'type' => 'text',     'group' => 'hero',    'order' => 1],
            ['key' => 'hero_title',        'label' => 'Judul Utama (NUSTECH)',    'value' => 'NUSTECH',                                        'type' => 'text',     'group' => 'hero',    'order' => 2],
            ['key' => 'hero_subtitle',     'label' => 'Sub Judul (lokasi)',       'value' => 'Nusa Tenggara Barat',                            'type' => 'text',     'group' => 'hero',    'order' => 3],
            ['key' => 'hero_description',  'label' => 'Deskripsi Hero',           'value' => 'Solusi Teknologi Informasi, Komunikasi, dan Pengadaan Barang Terpercaya & Handal.', 'type' => 'textarea', 'group' => 'hero', 'order' => 4],
            ['key' => 'hero_keywords',     'label' => 'Kata Kunci (bawah desc)', 'value' => 'Jaringan · VSAT · Kelistrikan · Reklame · Aplikasi', 'type' => 'text',  'group' => 'hero',    'order' => 5],
            ['key' => 'hero_stat1_count',  'label' => 'Statistik 1 - Angka',     'value' => '50',                                             'type' => 'number',   'group' => 'hero',    'order' => 6],
            ['key' => 'hero_stat1_label',  'label' => 'Statistik 1 - Label',     'value' => 'Proyek Selesai',                                 'type' => 'text',     'group' => 'hero',    'order' => 7],
            ['key' => 'hero_stat2_count',  'label' => 'Statistik 2 - Angka',     'value' => '30',                                             'type' => 'number',   'group' => 'hero',    'order' => 8],
            ['key' => 'hero_stat2_label',  'label' => 'Statistik 2 - Label',     'value' => 'Klien Puas',                                     'type' => 'text',     'group' => 'hero',    'order' => 9],
            ['key' => 'hero_stat3_count',  'label' => 'Statistik 3 - Angka',     'value' => '8',                                              'type' => 'number',   'group' => 'hero',    'order' => 10],
            ['key' => 'hero_stat3_label',  'label' => 'Statistik 3 - Label',     'value' => 'Bidang Layanan',                                 'type' => 'text',     'group' => 'hero',    'order' => 11],
            ['key' => 'hero_whatsapp',     'label' => 'Nomor WhatsApp',          'value' => '6281332809923',                                  'type' => 'text',     'group' => 'hero',    'order' => 12],

            // ==================== TENTANG KAMI ====================
            ['key' => 'about_heading',     'label' => 'Judul Section Tentang',   'value' => 'Menghadirkan Solusi Teknologi Terintegrasi',      'type' => 'text',     'group' => 'tentang', 'order' => 1],
            ['key' => 'about_desc1',       'label' => 'Paragraf Deskripsi 1',    'value' => 'CV. NUSTECH adalah perusahaan yang bergerak di bidang pengadaan barang dan jasa, khususnya sektor teknologi informasi, kelistrikan, dan rekayasa teknik. Berbasis di Lombok, Nusa Tenggara Barat, kami melayani kemitraan profesional dengan instansi pemerintah, pendidikan, dan sektor swasta.', 'type' => 'textarea', 'group' => 'tentang', 'order' => 2],
            ['key' => 'about_desc2',       'label' => 'Paragraf Deskripsi 2',    'value' => 'Komitmen kami adalah memberikan hasil yang presisi dan pelayanan prima. Kami dipercaya menangani infrastruktur jaringan fiber optik, perangkat pemancar satelit VSAT, hingga pengadaan perangkat perkantoran secara menyeluruh.', 'type' => 'textarea', 'group' => 'tentang', 'order' => 3],

            // ==================== MODAL PROFIL PERUSAHAAN ====================
            ['key' => 'modal_about_p1',    'label' => 'Modal Profil - Paragraf 1', 'value' => 'CV. NUSTECH didirikan sebagai respon atas cepatnya kemajuan teknologi informasi dan kelistrikan di Indonesia, khususnya kawasan Nusa Tenggara Barat. Kami merancang arsitektur sistem informasi yang modern dan efisien.', 'type' => 'textarea', 'group' => 'modal_tentang', 'order' => 1],
            ['key' => 'modal_about_p2',    'label' => 'Modal Profil - Paragraf 2', 'value' => 'Berpengalaman memelihara jaringan nirkabel serta pengadaan server kantor, kami selalu memprioritaskan kepuasan klien. Kepercayaan yang diberikan oleh mitra kami adalah modal terbesar perusahaan untuk tumbuh semakin profesional.', 'type' => 'textarea', 'group' => 'modal_tentang', 'order' => 2],
            ['key' => 'modal_strategy_1',  'label' => 'Strategi 1',              'value' => 'Kualitas Terjamin: Pengerjaan infrastruktur sesuai standard industri.',  'type' => 'text', 'group' => 'modal_tentang', 'order' => 3],
            ['key' => 'modal_strategy_2',  'label' => 'Strategi 2',              'value' => 'Inovasi Kontinu: Memakai modul hardware & software versi terkini.',       'type' => 'text', 'group' => 'modal_tentang', 'order' => 4],
            ['key' => 'modal_strategy_3',  'label' => 'Strategi 3',              'value' => 'Sinergi Kemitraan: Menjalin kerja sama transparan jangka panjang.',       'type' => 'text', 'group' => 'modal_tentang', 'order' => 5],
            ['key' => 'modal_strategy_4',  'label' => 'Strategi 4',              'value' => 'Kompetensi SDM: Teknisi lapangan dibekali sertifikasi keahlian.',         'type' => 'text', 'group' => 'modal_tentang', 'order' => 6],

            // ==================== VISI & MISI ====================
            ['key' => 'visimisi_title',    'label' => 'Judul Section Visi Misi', 'value' => 'Komitmen & Arah Masa Depan',                     'type' => 'text',     'group' => 'visimisi', 'order' => 1],
            ['key' => 'visimisi_subtitle', 'label' => 'Sub Judul Visi Misi',    'value' => 'Landasan nilai yang membimbing setiap langkah CV. NUSTECH menuju profesionalisme dan kepercayaan nasional.', 'type' => 'textarea', 'group' => 'visimisi', 'order' => 2],
            ['key' => 'visi_text',         'label' => 'Isi Teks VISI',          'value' => 'Menjadi perusahaan penyedia barang dan jasa di bidang teknologi informasi, elektronik, percetakan/reklame, meubel, dan alat-alat kantor yang profesional, memiliki daya saing tinggi, serta terpercaya di tingkat lokal maupun nasional.', 'type' => 'textarea', 'group' => 'visimisi', 'order' => 3],
            ['key' => 'misi_1',            'label' => 'Misi Poin 1',            'value' => 'Memberikan pelayanan prima dan solusi inovatif tepat guna bagi instansi.',   'type' => 'text', 'group' => 'visimisi', 'order' => 4],
            ['key' => 'misi_2',            'label' => 'Misi Poin 2',            'value' => 'Menjamin mutu produk dan pengadaan barang berkualitas tinggi.',               'type' => 'text', 'group' => 'visimisi', 'order' => 5],
            ['key' => 'misi_3',            'label' => 'Misi Poin 3',            'value' => 'Membangun hubungan kemitraan profesional berlandaskan keterbukaan bisnis.',   'type' => 'text', 'group' => 'visimisi', 'order' => 6],
            ['key' => 'misi_4',            'label' => 'Misi Poin 4',            'value' => 'Meningkatkan kompetensi tim kerja secara terstruktur demi menjamin kualitas.','type' => 'text', 'group' => 'visimisi', 'order' => 7],

            // ==================== LAYANAN ====================
            ['key' => 'layanan_title',          'label' => 'Judul Section Layanan',  'value' => 'Solusi Layanan Komprehensif',  'type' => 'text', 'group' => 'layanan', 'order' => 1],
            ['key' => 'layanan_subtitle',        'label' => 'Sub Judul Layanan',     'value' => 'Klik kategori di bawah untuk melihat detail layanan yang kami sediakan.', 'type' => 'text', 'group' => 'layanan', 'order' => 2],
            // Networking
            ['key' => 'layanan_networking_title', 'label' => 'Networking - Judul',  'value' => 'Networking',                  'type' => 'text', 'group' => 'layanan', 'order' => 3],
            ['key' => 'layanan_networking_sub',   'label' => 'Networking - Sub',    'value' => 'Infrastruktur & Konektivitas', 'type' => 'text', 'group' => 'layanan', 'order' => 4],
            ['key' => 'layanan_networking_desc',  'label' => 'Networking - Deskripsi', 'value' => 'Solusi infrastruktur jaringan internet lokal, inter-koneksi antar kantor, hingga maintenance periodik perangkat jaringan.', 'type' => 'textarea', 'group' => 'layanan', 'order' => 5],
            // Aplikasi
            ['key' => 'layanan_aplikasi_title',   'label' => 'Aplikasi - Judul',   'value' => 'Jasa Pengembangan Aplikasi & Program Komputer', 'type' => 'text', 'group' => 'layanan', 'order' => 6],
            ['key' => 'layanan_aplikasi_sub',     'label' => 'Aplikasi - Sub',     'value' => 'Aplikasi & Program Komputer', 'type' => 'text', 'group' => 'layanan', 'order' => 7],
            ['key' => 'layanan_aplikasi_desc',    'label' => 'Aplikasi - Deskripsi', 'value' => 'Merancang software kustom sesuai alur bisnis instansi, mulai dari program kasir, inventory, hingga sistem manajemen.', 'type' => 'textarea', 'group' => 'layanan', 'order' => 8],
            // Reklame
            ['key' => 'layanan_reklame_title',    'label' => 'Reklame - Judul',    'value' => 'Jasa Reklame dan Percetakan', 'type' => 'text', 'group' => 'layanan', 'order' => 9],
            ['key' => 'layanan_reklame_sub',      'label' => 'Reklame - Sub',      'value' => 'Branding & Promosi',          'type' => 'text', 'group' => 'layanan', 'order' => 10],
            ['key' => 'layanan_reklame_desc',     'label' => 'Reklame - Deskripsi', 'value' => 'Produksi material branding promosi fisik berkualitas untuk keperluan reklame luar ruangan maupun cetak massal.', 'type' => 'textarea', 'group' => 'layanan', 'order' => 11],
            // Kelistrikan
            ['key' => 'layanan_kelistrikan_title','label' => 'Kelistrikan - Judul', 'value' => 'Jasa Kelistrikan', 'type' => 'text', 'group' => 'layanan', 'order' => 12],
            ['key' => 'layanan_kelistrikan_sub',  'label' => 'Kelistrikan - Sub',  'value' => 'Kelistrikan Bangunan', 'type' => 'text', 'group' => 'layanan', 'order' => 13],
            ['key' => 'layanan_kelistrikan_desc', 'label' => 'Kelistrikan - Deskripsi', 'value' => 'Perancangan kelistrikan terpusat untuk keamanan operasional server data center, perkantoran, dan gedung.', 'type' => 'textarea', 'group' => 'layanan', 'order' => 14],
            // AC
            ['key' => 'layanan_ac_title',         'label' => 'AC - Judul',         'value' => 'Instalasi & Pemeliharaan Sistem Pendingin (AC)', 'type' => 'text', 'group' => 'layanan', 'order' => 15],
            ['key' => 'layanan_ac_sub',           'label' => 'AC - Sub',           'value' => 'Sistem Pendingin (AC)', 'type' => 'text', 'group' => 'layanan', 'order' => 16],
            ['key' => 'layanan_ac_desc',          'label' => 'AC - Deskripsi',     'value' => 'Maintenance pendingin ruangan secara rutin demi menjaga kestabilan suhu ruangan kerja maupun mesin server.', 'type' => 'textarea', 'group' => 'layanan', 'order' => 17],
            // Komputer
            ['key' => 'layanan_komputer_title',   'label' => 'Komputer - Judul',   'value' => 'Pengadaan & Maintenance Perangkat Komputer dan Printer', 'type' => 'text', 'group' => 'layanan', 'order' => 18],
            ['key' => 'layanan_komputer_sub',     'label' => 'Komputer - Sub',     'value' => 'Komputer & Printer', 'type' => 'text', 'group' => 'layanan', 'order' => 19],
            ['key' => 'layanan_komputer_desc',    'label' => 'Komputer - Deskripsi', 'value' => 'Penyediaan unit komputer client, laptop, server lokal, serta perbaikan berkala pada unit pencetak printer.', 'type' => 'textarea', 'group' => 'layanan', 'order' => 20],
            // Elektronik
            ['key' => 'layanan_elektronik_title', 'label' => 'Elektronik - Judul', 'value' => 'Pengadaan Peralatan Elektronik', 'type' => 'text', 'group' => 'layanan', 'order' => 21],
            ['key' => 'layanan_elektronik_sub',   'label' => 'Elektronik - Sub',   'value' => 'Peralatan Elektronik', 'type' => 'text', 'group' => 'layanan', 'order' => 22],
            ['key' => 'layanan_elektronik_desc',  'label' => 'Elektronik - Deskripsi', 'value' => 'Pengadaan berbagai peralatan elektronik operasional seperti TV display informasi, speaker pro, hingga proyektor.', 'type' => 'textarea', 'group' => 'layanan', 'order' => 23],
            // Kantor
            ['key' => 'layanan_kantor_title',     'label' => 'Kantor - Judul',     'value' => 'Pengadaan & Perawatan Alat-Alat Kantor', 'type' => 'text', 'group' => 'layanan', 'order' => 24],
            ['key' => 'layanan_kantor_sub',       'label' => 'Kantor - Sub',       'value' => 'Alat-Alat Kantor', 'type' => 'text', 'group' => 'layanan', 'order' => 25],
            ['key' => 'layanan_kantor_desc',      'label' => 'Kantor - Deskripsi', 'value' => 'Penyediaan meja kerja, kursi ergonomis, lemari berkas baja, serta furniture custom pendukung kenyamanan kantor.', 'type' => 'textarea', 'group' => 'layanan', 'order' => 26],

            // ==================== KONTAK / FOOTER ====================
            ['key' => 'contact_address',   'label' => 'Alamat Kantor',           'value' => 'Jl. Semangka No.2, Mataram – NTB',               'type' => 'text',     'group' => 'kontak', 'order' => 1],
            ['key' => 'contact_phone',     'label' => 'Nomor Telepon',           'value' => '+62 813 3280 9923',                              'type' => 'text',     'group' => 'kontak', 'order' => 2],
            ['key' => 'contact_email',     'label' => 'Alamat Email',            'value' => 'info@nustech.co.id',                             'type' => 'text',     'group' => 'kontak', 'order' => 3],
            ['key' => 'contact_instagram', 'label' => 'Username Instagram',      'value' => 'nustech.co.id',                                  'type' => 'text',     'group' => 'kontak', 'order' => 4],
            ['key' => 'footer_desc',       'label' => 'Deskripsi Footer',        'value' => 'Penyedia solusi IT infrastruktur, pengadaan barang, percetakan/reklame, kelistrikan, dan sistem pendingin ruangan bergaransi tepercaya di Nusa Tenggara Barat.', 'type' => 'textarea', 'group' => 'kontak', 'order' => 5],
            ['key' => 'cta_title',         'label' => 'Judul CTA Banner',        'value' => 'Siap Bermitra Bersama Kami?',                    'type' => 'text',     'group' => 'kontak', 'order' => 6],
            ['key' => 'cta_subtitle',      'label' => 'Sub CTA Banner',          'value' => 'Konsultasikan kebutuhan IT, pengadaan, dan engineering Anda langsung dengan tim ahli kami. Gratis konsultasi!', 'type' => 'textarea', 'group' => 'kontak', 'order' => 7],
            ['key' => 'maps_embed_url',    'label' => 'URL Embed Google Maps',   'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.143719001391!2d116.1084288!3d-8.5835905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdbf5c5cfc2c43%3A0xe1db0920404470d0!2sJl.%20Semangka%2C%20Mataram%20Bar.%2C%20Kec.%20Selaparang%2C%20Kota%20Mataram%2C%20Nusa%20Tenggara%20Bar.!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid', 'type' => 'url', 'group' => 'kontak', 'order' => 8],
        ];

        foreach ($items as $item) {
            LandingPageContent::updateOrCreate(
                ['key' => $item['key']],
                $item
            );
        }
    }
}
