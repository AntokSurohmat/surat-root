<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class JenisWilayahSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'kode'           => "99999999",
            'kode_kabupaten' => '9999',
            'kode_provinsi'  => '99',
            'jenis_wilayah'  => 'Wilayah Test',
            'created_at'     => Time::now(),
        ];
        $this->db->table('jenis_wilayah')->insert($data);
    }
}
