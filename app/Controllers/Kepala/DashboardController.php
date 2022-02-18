<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'DASHBOARD',
            'parent' => 1,
            'pmenu' => 1.1
        );
        return view('kepala/index', $data);
    }
}
