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

        $revisi = $this->db->table('spt')->like('status', 'Revisi');
        $disetujui = $this->db->table('spt')->like('status', 'Disetujui');
        $pending = $this->db->table('spt')->like('status', 'Pending');


        $data = array(
            'title' => 'DASHBOARD',
            'parent' => 1,
            'pmenu' => 1.1,
            'username' => $this->session->get('username'),
            'revisi' => $revisi->countAllResults(),
            'disetujui' => $disetujui->countAllResults(),
            'pending' => $pending->countAllResults(),

        );
        return view('kepala/index', $data);
    }
}
