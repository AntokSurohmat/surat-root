<?php

namespace App\Controllers\Bendahara;

use App\Controllers\BaseController;
use App\Models\Bendahara\KuitansiModel;
use App\Models\Bendahara\RincianModel;

class Dashboard extends BaseController
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
    public function __construct()
    {
        if (session()->get('level') != "Bendahara") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $this->kuitansi = new KuitansiModel();
        $this->rincian = new RincianModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {

        $data = array(
            'title' => 'DASHBOARD',
            'parent' => 1,
            'pmenu' => 1.1,
            'username' => $this->session->get('username'),
            'kuitansi' => $this->kuitansi->countAll(),
            'rincian' => $this->rincian->countAll(),
        );
        return view('bendahara/index', $data);
    }
}
