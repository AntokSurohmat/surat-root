<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SptController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'SURAT PERINTAH TUGAS',
            'parent' => 3,
            'pmenu' => 3.1
        );
        return view('admin/spt/v-spt', $data);
    }
}
