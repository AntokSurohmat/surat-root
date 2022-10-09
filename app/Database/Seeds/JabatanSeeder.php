<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use CodeIgniter\I18n\Time;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode' =>  '99999999',
                'nama_jabatan' => "Pegawai",
                'created_at' => Time::now(),
            ],
            [
                'kode' =>  '88888888',
                'nama_jabatan' => "Kepala",
                'created_at' => Time::now(),
            ],
            [
                'kode' =>  '77777777',
                'nama_jabatan' => "Bendahara",
                'created_at' => Time::now(),
            ],
        ];
        $this->db->table('jabatan')->insertBatch($data);
    }
}
