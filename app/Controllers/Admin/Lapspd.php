<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Lapspd extends BaseController
{
    public function __construct()
    {
        if (session()->get('level') != "Admin") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
    }
    public function index()
    {
        $data = array(
            'title' => 'LAPORAN SURAT PERJALAN DINAS',
            'parent' => 4,
            'pmenu' => 4.2
        );
        return view('admin/lapspd/v-lapspd', $data);
    }
}
