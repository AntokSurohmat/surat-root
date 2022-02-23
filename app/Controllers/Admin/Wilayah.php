<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Admin\WilayahModel;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */

class Wilayah extends ResourcePresenter
{

    protected $helpers = ['form', 'url'];
    public function __construct()
    {
        $this->provinsi = new ProvinsiModel();
        $this->kabupaten = new KabupatenModel();
        $this->kecamatan = new KecamatanModel();
        $this->wilayah = new WilayahModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
    }
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        $data = array(
            'title' => 'WILAYAH',
            'parent' => 2,
            'pmenu' => 2.4
        );
        return view('admin/wilayah/v-wilayah', $data);
    }

    public function getProvinsi()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $provinsilist = $this->provinsi->select('id,nama_provinsi') // Fetch record
                ->orderBy('nama_provinsi')
                ->findAll(10);
        } else {
            $provinsilist = $this->provinsi->select('id,nama_provinsi') // Fetch record
                ->like('nama_provinsi', $this->request->getPost('searchTerm'))
                ->orderBy('nama_provinsi')
                ->findAll(10);
        }

        $data = array();
        foreach ($provinsilist as $provinsi) {
            $data[] = array(
                "id" => $provinsi['id'],
                "text" => $provinsi['nama_provinsi'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    public function getKabupaten()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        if ($this->request->getPost('searchTerm') == NULL) {            
            $kabupatenlist = $this->kabupaten->select('id,nama_kabupaten') // Fetch record
                ->where('id_provinsi', $this->request->getPost('provinsi'))
                ->orderBy('nama_kabupaten')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kabupaten->select('id,nama_kabupaten') // Fetch record
                ->like('nama_kabupaten', $this->request->getPost('searchTerm'))
                ->where('id_provinsi', $this->request->getPost('provinsi'))
                ->orderBy('nama_kabupaten')
                ->findAll(10);
        }

        $data = array();
        foreach ($kabupatenlist as $kabupaten) {
            $data[] = array(
                "id" => $kabupaten['id'],
                "text" => $kabupaten['nama_kabupaten'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getKecamatan()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        if ($this->request->getPost('searchTerm') == NULL) {            
            $kabupatenlist = $this->kecamatan->select('id,nama_kecamatan') // Fetch record
                ->where('id_kabupaten', $this->request->getPost('kabupaten'))
                ->orderBy('nama_kecamatan')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kecamatan->select('id,nama_kecamatan') // Fetch record
                ->like('nama_kecamatan', $this->request->getPost('searchTerm'))
                ->where('id_kabupaten', $this->request->getPost('kabupaten'))
                ->orderBy('nama_kecamatan')
                ->findAll(10);
        }

        $data = array();
        foreach ($kabupatenlist as $kabupaten) {
            $data[] = array(
                "id" => $kabupaten['id'],
                "text" => $kabupaten['nama_kecamatan'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    function savemodal(){
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        helper(['form', 'url']);

        $validation = \Config\Services::validation();
        // d($this->request->getVar('nama_provAdd'));
        // dd($this->request->getVar('method'));
        if ($this->request->getVar('method') == 'Prov') {
            $valid = $this->validate([
                'nama_provAdd' => [
                    'label' => 'Nama Provinsi',
                    'rules' => 'required|max_length[40]',
                    'errors' => [
                        'required' =>  '{field} harus diisi',
                        'max_length' => 'Maksimal 40 Karakter'
                    ]
                ]
            ]);

            if(!$valid){
                $data = [
                    'error' => [
                        'nama_provinsi' => $validation->getError('nama_provAdd')
                        ]
                    ];
            }else{ 
                $data = [
                    'nama_provinsi' => $this->request->getVar('nama_provAdd')
                ];
            }

            if($this->provinsi->insert($data)){
                $data = array('success'=> true, 'msg'=> 'Data berhasil disimpan');
            }else{
                $data = array('success'=> false, 'msg'=> 'Terjadi kesalahan dalam memilah data');
            }

        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
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
            'title' => 'WILAYAH',
            'parent' => 2,
            'pmenu' => 2.4
        );
        return view('admin/wilayah/v-wilayahAddEdit', $data);
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        //
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
        $data = array(
            'title' => 'WILAYAH Edit',
            'parent' => 2,
            'pmenu' => 2.4
        );
        return view('admin/wilayah/v-wilayahAddEdit', $data);
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
