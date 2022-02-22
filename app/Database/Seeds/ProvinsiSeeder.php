<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ProvinsiSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $data = [
                'nama_provinsi' => $faker->name,
                'created_at' => Time::now()
            ];
            $this->db->table('provinsi')->insert($data);
        }
    }
}
