<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Rekening extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'KODE REKENING',
            'parent' => 2,
            'pmenu' => 2.7
        );
        return view('admin/rekening/v-rekening', $data);
    }
}
