<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;

class SptController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'SURAT PERINTAH TUGAS',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('pegawai/spd/v-spd', $data);
    }
}
