<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\Admin\SptModel;
use App\Models\Admin\SpdModel;
use App\Models\Admin\PegawaiModel;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */
class Dashboard extends BaseController
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];  // Helper

    public function __construct() // function _construct is to call the model class or library that we will use in each function.
    {
        if (session()->get('level') != "Admin") { // checking if session level == admin, if not throw forbidden
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        // shorthand
        $this->spt = new SptModel(); // get data from Model SPT
        $this->spd = new SpdModel(); // get data from Model SPD
        $this->pegawai = new PegawaiModel(); // get data from Model Pegawai
        $this->csrfToken = csrf_token(); // generate csrf token
        $this->csrfHash = csrf_hash(); // generate csrf hash
        $this->session = \Config\Services::session(); // use library session
        $this->session->start(); // starting session
        $this->db = \Config\Database::connect(); // use library database
    }

    public function index() // function 
    {

        $spd = $this->spd->countAll(); // count all spd data
        $spt = $this->spt->countAll(); // count all spt data
        $pegawai = $this->pegawai->countAll(); // count all pegawai data

        $data = array(
            'title' => 'DASHBOARD',
            'parent' => 1,
            'pmenu' => 1.1,
            'level' =>  $this->session->get('level'), // session level
            'username' => $this->session->get('username'), // session username
            'spt' => $spt,
            'spd' => $spd,
            'pegawai' => $pegawai
        );

        return view('admin/index', $data);
    }

}
