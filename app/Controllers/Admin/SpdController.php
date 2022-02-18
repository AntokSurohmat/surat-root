<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SpdController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'SURAT PERJALAN DINAS',
            'parent' => 3,
            'pmenu' => 3.2
        );
        return view('admin/spd/v-spd', $data);
    }
}
