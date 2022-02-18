<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {

        $builder = $this->db->table('blog');
        $query   = $builder->get()->getRow();
        $data = array(
            'title' => 'DASHBOARD',
            'parent' => 1,
            'pmenu' => 1.1,
            'isi' => $query
        );

        return view('admin/index', $data);
    }
}
