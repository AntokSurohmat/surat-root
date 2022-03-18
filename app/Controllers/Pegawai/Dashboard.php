<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\Admin\PegawaiModel;
use CodeIgniter\HTTP\IncomingRequest;


/**
 * @property IncomingRequest $request
*/
class Dashboard extends BaseController
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
        if (session()->get('level') != "Pegawai") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $this->pegawai = new PegawaiModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        $profile = $this->pegawai->select(['foto', 'nama'])->where('id', $this->session->id)->first();
        $data = array(
            'title' => 'DASHBOARD',
            'parent' => 1,
            'pmenu' => 1.1,
            'session' => $this->session->username,
            'photo' => $profile['foto'],
            'nama'  => $profile['nama']
        );
        return view('pegawai/index', $data);
    }
}
