<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'DASHBOARD',
            'parent' => 1,
            'pmenu' => 1.1
        );
        return view('pegawai/index', $data);
    }
}
