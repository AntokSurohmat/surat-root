<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppSeeder extends Seeder
{
    public function run()
    {
        $this->call('PangolSeeder');
        $this->call('JabatanSeeder');
        $this->call('ProvinsiSeeder');
        $this->call('KabupatenSeeder');
        $this->call('KabupatenSeeder');
        $this->call('KecamatanSeeder');
        $this->call('JenisWilayahSeeder');
        $this->call('ZonasiSeeder');
        $this->call('WilayahSeeder');
        $this->call('InstansiSeeder');
        $this->call('SbuhSeeder');
        $this->call('RekeningSeeder');
        $this->call('PegawaiSeeder');
    }
}
