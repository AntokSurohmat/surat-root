<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;

class VerifikasiController extends BaseController
{
    public function index()
    {
        $data = array(
            'title' => 'VERIFIKASI',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('kepala/verifikasi/v-verifikasi', $data);
    }
}
