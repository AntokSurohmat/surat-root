<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use CodeIgniter\I18n\Time;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'kode' =>  '99999999',
            'nama_jabatan' => "Ini Test jabatan",
            'created_at' => Time::now(),
        ];
        $this->db->table('jabatan')->insert($data);
    }
}
