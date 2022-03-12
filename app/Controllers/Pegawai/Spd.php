<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;

class Spd extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'SURAT PERJALANAN DINAS',
            'parent' => 2,
            'pmenu' => 2.2
        );
        return view('pegawai/spt/v-spt', $data);
    }
}
