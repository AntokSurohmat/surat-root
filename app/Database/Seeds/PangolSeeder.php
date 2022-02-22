<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PangolSeeder extends Seeder
{
    public function run()
    {

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $data = [
                'kode' => $faker->unique()->randomNumber($nbDigits = NULL, $strict = false) ,
                'nama_pangol' => $faker->name,
                'created_at' => Time::now()
            ];
            $this->db->table('pangol')->insert($data);
        }
    }
}
