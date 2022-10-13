<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ProvinsiSeeder extends Seeder
{
    public function run()
    {

        $data = [
            'kode' => '99',
            'nama_provinsi' => 'Ini Provinsi',
            'created_at' => Time::now()
        ];
        $this->db->table('provinsi')->insert($data);

    }
}
