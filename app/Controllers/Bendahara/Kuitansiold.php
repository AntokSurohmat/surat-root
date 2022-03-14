<?php

namespace App\Controllers\Bendahara;

use App\Controllers\BaseController;

class Kuitansi extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'KUITANSI',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('bendahara/kuitansi/v-kuitansi', $data);
    }
}
