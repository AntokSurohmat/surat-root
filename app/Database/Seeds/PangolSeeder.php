<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PangolSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'kode' => '9999999' ,
            'nama_pangol' => 'Ini Test Pangol',
            'created_at' => Time::now()
        ];
        $this->db->table('pangol')->insert($data);

    }
}
