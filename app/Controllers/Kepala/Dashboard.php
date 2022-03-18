<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function __construct()
    {
        if (session()->get('level') != "Kepala Bidang") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
    }
    public function index()
    {
        $data = array(
            'title' => 'DASHBOARD',
            'parent' => 1,
            'pmenu' => 1.1,
            'session' => $this->session->username
        );
        return view('kepala/index', $data);
    }
}
