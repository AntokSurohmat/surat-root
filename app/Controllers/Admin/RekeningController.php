<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class RekeningController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'Kode Rekening',
            'parent' => 2,
            'pmenu' => 2.4
        );
        return view('admin/rekening/rekening', $data);
    }
}
