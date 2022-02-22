<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use CodeIgniter\I18n\Time;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $data = [
                'kode' => $faker->unique()->randomNumber($nbDigits = NULL, $strict = false) ,
                'nama_jabatan' => $faker->name,
                'created_at' => Time::now()
            ];
            $this->db->table('jabatan')->insert($data);
        }
    }
}
