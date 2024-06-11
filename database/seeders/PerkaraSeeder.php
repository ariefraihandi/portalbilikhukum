<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerkaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('legal_cases')->insert([
            ['name' => 'Perceraian', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pembunuhan', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Korupsi', 'kategori' => 'Hukum Pidana Khusus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sengketa Tanah dan Properti', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sengketa Kontrak', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tuntutan Ganti Rugi', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Warisan', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hibah', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wasiat', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hak Asuh Anak', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pemeliharaan dan Pendidikan Anak', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kekerasan Dalam Rumah Tangga', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penipuan', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pencurian', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Narkotika', 'kategori' => 'Hukum Pidana Khusus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perampokan', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penganiayaan', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kecelakaan Lalu Lintas', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pembunuhan Berencana', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Percobaan Pembunuhan', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perdagangan Manusia', 'kategori' => 'Hukum Pidana Khusus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kekerasan Seksual', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pemalsuan Dokumen', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pencucian Uang', 'kategori' => 'Hukum Pidana Khusus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Terorisme', 'kategori' => 'Hukum Pidana Khusus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penyalahgunaan Kekuasaan', 'kategori' => 'Hukum Pidana Khusus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sengketa Ketenagakerjaan', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pelanggaran HAM', 'kategori' => 'Hukum Pidana Khusus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sengketa Bisnis', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pengelolaan Zakat', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wakaf', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Infaq dan Shadaqah', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ijin Poligami', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pembatalan Perkawinan', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penyelesaian Harta Bersama', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pemeliharaan dan Pendidikan Anak', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hak Asuh Anak (Hadhanah)', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pengesahan Anak', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pencabutan Kekuasaan Orang Tua', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perwalian', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sengketa Ekonomi Syariah', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kepailitan', 'kategori' => 'Hukum Niaga', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penundaan Kewajiban Pembayaran Utang (PKPU)', 'kategori' => 'Hukum Niaga', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sengketa Hak Kekayaan Intelektual', 'kategori' => 'Hukum Niaga', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sengketa Pajak', 'kategori' => 'Hukum Pajak', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sengketa Lingkungan Hidup', 'kategori' => 'Hukum Lingkungan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penetapan Asal Usul Anak', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penyelesaian Harta Peninggalan', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pencabutan Kekuasaan Wali', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penunjukan Wali', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ganti Rugi Terhadap Wali', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penetapan Pengangkatan Anak', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Itsbat Nikah', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dispensasi Kawin', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wali Adhal', 'kategori' => 'Hukum Islam', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penipuan Investasi', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pelanggaran Hak Cipta', 'kategori' => 'Hukum Niaga', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kebakaran Hutan', 'kategori' => 'Hukum Lingkungan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perjanjian Kerja', 'kategori' => 'Hukum Ketenagakerjaan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pemutusan Hubungan Kerja', 'kategori' => 'Hukum Ketenagakerjaan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pengelolaan Sampah', 'kategori' => 'Hukum Lingkungan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pelanggaran Keimigrasian', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penyerobotan Lahan', 'kategori' => 'Hukum Perdata', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penganiayaan Anak', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pelanggaran Kesehatan', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penggelapan Pajak', 'kategori' => 'Hukum Pidana Khusus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Penjualan Organ Tubuh', 'kategori' => 'Hukum Pidana Khusus', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kekerasan Terhadap Hewan', 'kategori' => 'Hukum Pidana', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Perdagangan Satwa Liar', 'kategori' => 'Hukum Pidana Khusus', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
