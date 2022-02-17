<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class InstansiController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'Instansi',
            'parent' => 2,
            'pmenu' => 2.5
        );
        return view('admin/instansi/instansi', $data);
    }
}
