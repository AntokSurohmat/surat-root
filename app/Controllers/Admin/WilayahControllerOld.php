<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class WilayahController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'WILAYAH',
            'parent' => 2,
            'pmenu' => 2.4
        );
        return view('admin/wilayah/v-wilayah', $data);
    }
}
