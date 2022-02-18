<?php

namespace App\Controllers\Bendahara;

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
        return view('bendahara/index', $data);
    }
}
