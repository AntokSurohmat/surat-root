<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class RekeningSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'kode'               => "99999999",
            'kode_jenis_wilayah' => '99999999',
            'nomer_rekening'     => '1234567890',
            'created_at'         => Time::now(),
        ];
        $this->db->table('rekening')->insert($data);
    }
}
