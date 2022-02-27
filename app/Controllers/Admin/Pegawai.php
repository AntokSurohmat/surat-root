<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\JabatanModel;
use App\Models\Admin\PangolModel;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */


class Pegawai extends ResourcePresenter
{
    protected $helpers = ['form', 'url'];
    public function __construct()
    {
        $this->jabatan = new JabatanModel();
        $this->pangol = new PangolModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
        $this->session = \Config\Services::session();
        $this->session->start();
    }
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        $data = array(
            'title' => 'PEGAWAI',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('admin/pegawai/v-pegawai', $data);
    }

    public function getJabatan()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $jabatanlist = $this->jabatan->select('id,nama_jabatan') // Fetch record
                ->where('deleted_at', NULL)
                ->orderBy('nama_jabatan')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $jabatanlist = $this->jabatan->select('id,nama_jabatan') // Fetch record
                ->where('deleted_at', NULL)
                ->like('nama_jabatan', $this->request->getPost('searchTerm'))
                ->orderBy('nama_jabatan')
                ->findAll(10);
        }

        $data = array();
        foreach ($jabatanlist as $jabatan) {
            $data[] = array(
                "id" => $jabatan['id'],
                "text" => $jabatan['nama_jabatan'],
            );
        }

        // $response['count'] = $count;
        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getPangol()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pangollist = $this->pangol->select('id,nama_pangol') // Fetch record
                ->where('deleted_at', NULL)
                ->orderBy('nama_pangol')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $pangollist = $this->jabatan->select('id,nama_pangol') // Fetch record
                ->where('deleted_at', NULL)
                ->like('nama_pangol', $this->request->getPost('searchTerm'))
                ->orderBy('nama_pangol')
                ->findAll(10);
        }

        $data = array();
        foreach ($pangollist as $pangol) {
            $data[] = array(
                "id" => $pangol['id'],
                "text" => $pangol['nama_pangol'],
            );
        }

        // $response['count'] = $count;
        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    /**
     * Present a view to present a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        $data = array(
            'title' => 'Tambah Instansi',
            'parent' => 2,
            'pmenu' => 2.1,
            'method' => 'New',
            'hiddenID' => '',
        );
        return view('admin/pegawai/v-pegawaiAddEdit', $data);
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {

    }

    /**
     * Present a view to edit the properties of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Process the updating, full or partial, of a specific resource object.
     * This should be a POST.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Present a view to confirm the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function remove($id = null)
    {
        //
    }

    /**
     * Process the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
