<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Lapspt extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'LAPORAN SURAT PERINTAH TUGAS',
            'parent' => 4,
            'pmenu' => 4.1
        );
        return view('admin/lapspt/v-lapspt', $data);
    }
}
