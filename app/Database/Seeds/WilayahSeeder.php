<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'kode'               => "99999999",
            'kode_kecamatan'     => '9999999',
            'kode_kabupaten'     => '9999',
            'kode_provinsi'      => '99',
            'kode_jenis_wilayah' => '99999999',
            'kode_zonasi'        => '99999999',
            'created_at'         => Time::now(),
        ];
        $this->db->table('wilayah')->insert($data);
    }
}
