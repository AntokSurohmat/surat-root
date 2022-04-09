<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class KecamatanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'kode_kabupaten' =>  '9999',
            'kode' => '9999999',
            'nama_kecamatan' => "Ini Test Kecamatan",
            'created_at' => Time::now(),
            'update_at' => Time::now(),
        ];
        $this->db->table('kecamatan')->insert($data);
    }
}
