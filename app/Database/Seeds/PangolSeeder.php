<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PangolSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode' => '9999999' ,
                'nama_pangol' => 'GOL I',
                'created_at' => Time::now()
            ],
            [
                'kode' => '8888888' ,
                'nama_pangol' => 'GOL II',
                'created_at' => Time::now()
            ],
            [
                'kode' => '7777777' ,
                'nama_pangol' => 'GOL III',
                'created_at' => Time::now()
            ]
        ];
        $this->db->table('pangol')->insertBatch($data);

    }
}
