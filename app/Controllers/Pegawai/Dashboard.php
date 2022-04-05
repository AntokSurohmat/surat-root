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
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
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
        $spt = $this->db->table('spt')->like('pegawai_all', $this->session->nip );
        $spd = $this->db->table('spd')->like('pegawai_all', $this->session->nip );

        $data = array(
            'title' => 'DASHBOARD',
            'parent' => 1,
            'pmenu' => 1.1,
            'level' =>  $this->session->get('level'),
            'username' => $this->session->get('username'),
            'spt' => $spt->countAll(),
            'spd' => $spd->countAll(),
            'photo' => $profile['foto'],
            'nama'  => $profile['nama']
        );
        return view('pegawai/index', $data);
    }
}
