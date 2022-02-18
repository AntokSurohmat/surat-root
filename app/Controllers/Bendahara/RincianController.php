<?php

namespace App\Controllers\Bendahara;

use App\Controllers\BaseController;

class RincianController extends BaseController
{
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
