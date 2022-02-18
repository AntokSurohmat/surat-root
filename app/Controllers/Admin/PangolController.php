<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PangolController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'PANGKAT & GOLONGAN',
            'parent' => 2,
            'pmenu' => 2.2
        );
        return view('admin/pangol/v-pangol', $data);
    }
}
