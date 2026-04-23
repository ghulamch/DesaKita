<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Budget;
use App\Models\User;
use App\Models\Agenda;
use App\Models\Apparatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VillageSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin Desa',
            'email' => 'admin@desa.id',
            'password' => Hash::make('password123'),
        ]);

        // Sample News
        $news = [
            [
                'title' => 'Pembangunan Jalan Desa Tahap 1 Selesai',
                'content' => 'Pembangunan jalan di Dusun Krajan telah selesai 100%. Ini merupakan upaya pemerintah desa untuk meningkatkan aksesibilitas warga.',
                'category' => 'Infrastruktur',
            ],
            [
                'title' => 'Penyaluran BLT Dana Desa Bulan April',
                'content' => 'Pemerintah Desa menyalurkan Bantuan Langsung Tunai (BLT) kepada 150 Keluarga Penerima Manfaat (KPM) untuk meringankan beban ekonomi.',
                'category' => 'Sosial',
            ],
            [
                'title' => 'Pelatihan UMKM Kerajinan Bambu',
                'content' => 'Guna meningkatkan ekonomi kreatif, desa mengadakan pelatihan kerajinan bambu bagi pemuda karang taruna.',
                'category' => 'Ekonomi',
            ],
        ];

        foreach ($news as $item) {
            News::create([
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'content' => $item['content'],
                'category' => $item['category'],
            ]);
        }

        // Sample Budgets (APBDes 2024)
        $budgets = [
            // Pendapatan
            ['year' => 2024, 'type' => 'Pendapatan', 'category' => 'Dana Desa (DD)', 'amount' => 1200000000],
            ['year' => 2024, 'type' => 'Pendapatan', 'category' => 'Alokasi Dana Desa (ADD)', 'amount' => 800000000],
            ['year' => 2024, 'type' => 'Pendapatan', 'category' => 'Pendapatan Asli Desa (PADes)', 'amount' => 150000000],
            ['year' => 2024, 'type' => 'Pendapatan', 'category' => 'Bantuan Keuangan Provinsi', 'amount' => 200000000],
            
            // Belanja
            ['year' => 2024, 'type' => 'Belanja', 'category' => 'Bidang Penyelenggaraan Pemerintahan', 'amount' => 750000000],
            ['year' => 2024, 'type' => 'Belanja', 'category' => 'Bidang Pembangunan Desa', 'amount' => 1100000000],
            ['year' => 2024, 'type' => 'Belanja', 'category' => 'Bidang Pembinaan Kemasyarakatan', 'amount' => 250000000],
            ['year' => 2024, 'type' => 'Belanja', 'category' => 'Bidang Pemberdayaan Masyarakat', 'amount' => 200000000],
            ['year' => 2024, 'type' => 'Belanja', 'category' => 'Penanggulangan Bencana/Darurat', 'amount' => 50000000],
        ];

        foreach ($budgets as $budget) {
            Budget::create($budget);
        }

        // Sample Agendas
        $agendas = [
            ['title' => 'Rapat Kerja Bakti Desa', 'date' => now()->addDays(2), 'location' => 'Balai Desa'],
            ['title' => 'Pelatihan Digital Marketing UMKM', 'date' => now()->addDays(5), 'location' => 'Ruang Pertemuan'],
            ['title' => 'Posyandu Balita & Lansia', 'date' => now()->addDays(8), 'location' => 'Posyandu Dusun 1'],
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }

        // Sample Apparatus
        $apparatus = [
            ['name' => 'Budi Santoso, S.T.', 'role' => 'Kepala Desa', 'image' => null],
            ['name' => 'Siti Aminah', 'role' => 'Sekretaris Desa', 'image' => null],
            ['name' => 'Agus Prayitno', 'role' => 'Bendahara Desa', 'image' => null],
            ['name' => 'Lutfi Hakim', 'role' => 'Kaur Perencanaan', 'image' => null],
        ];

        foreach ($apparatus as $staff) {
            Apparatus::create($staff);
        }

        // Sample SiteMeta
        $metas = [
            ['meta_key' => 'kades_name', 'meta_value' => 'Budi Santoso, S.T.'],
            ['meta_key' => 'kades_greeting', 'meta_value' => '<p>Assalamu\'alaikum Warahmatullahi Wabarakatuh,</p><p>Selamat datang di portal resmi Pemerintahan Desa. Melalui media digital ini, kami berupaya mewujudkan transparansi tata kelola yang terpercaya serta pelayanan publik yang cepat untuk seluruh warga masyarakat.</p><p>Mari bahu-membahu membangun desa menuju kemandirian ekonomi.</p>'],
            ['meta_key' => 'village_vision', 'meta_value' => 'Mewujudkan Desa yang Maju, Mandiri, Sejahtera, dan Berbudaya Berlandaskan Keimanan dan Ketaqwaan.'],
            ['meta_key' => 'village_mission', 'meta_value' => '<ol><li>Meningkatkan kualitas tata kelola pemerintahan yang bersih dan transparan.</li><li>Memberdayakan ekonomi warga melalui UMKM.</li><li>Meningkatkan kualitas sarana fisik dan SDA.</li></ol>'],
            ['meta_key' => 'village_map_url', 'meta_value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9798.662937324989!2d112.65502424492412!3d-7.403329281001376!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e24e15eae73d%3A0x99b12dafd9e49dc0!2sPademonegoro%2C%20Kec.%20Sukodono%2C%20Kabupaten%20Sidoarjo%2C%20Jawa%20Timur!5e1!3m2!1sid!2sid!4v1776689008752!5m2!1sid!2sid'],
        ];
        
        foreach ($metas as $meta) {
            \App\Models\SiteMeta::updateOrCreate(['meta_key' => $meta['meta_key']], $meta);
        }

        // Sample Products (UMKM)
        $products = [
            [
                'name' => 'Kopi Robusta Asli Desa',
                'seller_name' => 'Pak Yanto',
                'phone' => '081234567890',
                'price' => 25000,
                'description' => 'Kopi robusta dijemur dan diolah tradisional. Harum dan mantap untuk teman begadang.',
            ],
            [
                'name' => 'Kerajinan Tas Bambu',
                'seller_name' => 'Bu Siti Karang Taruna',
                'phone' => '085678901234',
                'price' => 75000,
                'description' => 'Tas anyaman bambu kokoh untuk hampers atau jalan-jalan santai. Dibuat dengan cinta oleh ibu-ibu PKK.',
            ]
        ];

        foreach ($products as $prod) {
            \App\Models\Product::create($prod);
        }
    }
}
