<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;


class ZonasiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'kode'           => "99999999",
            'kode_kabupaten' => '9999',
            'kode_provinsi'  => '99',
            'kode_kecamatan' => '9999999',
            'nama_zonasi'    => 'Zonasi Test',
            'created_at'     => Time::now(),
        ];
        $this->db->table('zonasi')->insert($data);
    }
}
