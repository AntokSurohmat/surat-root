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
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
    public function __construct()
    {
        if (session()->get('level') != "Admin") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $this->spt = new SptModel();
        $this->spd = new SpdModel();
        $this->pegawai = new PegawaiModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {

        $spd = $this->spd->countAll();
        $spt = $this->spt->countAll();
        $pegawai = $this->pegawai->countAll();

        $data = array(
            'title' => 'DASHBOARD',
            'parent' => 1,
            'pmenu' => 1.1,
            'level' =>  $this->session->get('level'),
            'username' => $this->session->get('username'),
            'spt' => $spt,
            'spd' => $spd,
            'pegawai' => $pegawai
        );

        return view('admin/index', $data);
    }

}
