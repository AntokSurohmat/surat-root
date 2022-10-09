<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nip'           => "999999999",
            'nama'          => 'Ini Test Pegawai',
            'tgl_lahir'     => '2022-02-02',
            'kode_jabatan'  =>  '99999999', // 8 Character
            'kode_pangol'  =>  '9999999', // 7 Character
            'pelaksana'     => '',
            'foto'          => 'default.png',
            'username'         => 'admin',
            'password'          => password_hash('admin', PASSWORD_DEFAULT),
            'level'         => 'admin', 
            'created_at'     => Time::now(),
        ];
        $this->db->table('pegawai')->insert($data);
    }
}
