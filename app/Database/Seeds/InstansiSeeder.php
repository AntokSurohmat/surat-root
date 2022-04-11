<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class InstansiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'kode'           => "99999999",
            'kode_kecamatan' => '9999999',
            'kode_kabupaten' => '9999',
            'kode_provinsi'  => '99',
            'nama_instansi'  => 'Test Instansi',
            'created_at'     => Time::now(),
        ];
        $this->db->table('instansi')->insert($data);
    }
}
