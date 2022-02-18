<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SbuhController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'STANDAR BIAYA UANG HARIAN',
            'parent' => 2,
            'pmenu' => 2.6
        );
        return view('admin/sbuh/v-sbuh', $data);
    }
}
