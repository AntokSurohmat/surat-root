<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class JabatanController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'JABATAN',
            'parent' => 2,
            'pmenu' => 2.3
        );
        return view('admin/jabatan/v-jabatan', $data);
    }
}
