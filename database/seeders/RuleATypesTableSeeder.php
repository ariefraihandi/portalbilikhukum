<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleATypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('rule_a_types')->insert([
            ['name' => 'Undang-Undang Dasar Negara Republik Indonesia Tahun 1945', 'type' => 'UUD_1945'],
            ['name' => 'Ketetapan Majelis Permusyawaratan Rakyat', 'type' => 'TAP_MPR'],
            ['name' => 'Undang-Undang/Peraturan Pemerintah Pengganti Undang-Undang', 'type' => 'UU_PERPU'],
            ['name' => 'Peraturan Pemerintah', 'type' => 'PP'],
            ['name' => 'Peraturan Presiden', 'type' => 'PERPRES'],
            ['name' => 'Peraturan Daerah Provinsi', 'type' => 'PERDA_PROV'],
            ['name' => 'Peraturan Daerah Kabupaten/Kota', 'type' => 'PERDA_KAB_KOTA']
        ]);
    }
}
