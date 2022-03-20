<?php

namespace App\Controllers\Bendahara;

use App\Controllers\BaseController;

class Rincian extends BaseController
{
    public function __construct()
    {
        if (session()->get('level') != "Bendahara") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
    }
    public function index()
    {
        $data = array(
            'title' => 'RINCIAN BIAYA',
            'parent' => 2,
            'pmenu' => 2.2
        );
        return view('bendahara/kuitansi/v-kuitansi', $data);
    }
}
