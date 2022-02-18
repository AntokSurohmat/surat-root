<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PegawaiController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'PEGAWAI',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('admin/pegawai/v-pegawai', $data);
    }
}
