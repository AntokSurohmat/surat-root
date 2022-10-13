<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
class KabupatenSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'kode' =>  '9999',
            'kode_provinsi' => '99',
            'nama_kabupaten' => "Ini Kabupaten",
            'created_at' => Time::now(),
        ];
        $this->db->table('kabupaten')->insert($data);
    }
}
