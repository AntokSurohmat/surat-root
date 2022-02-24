<?php

namespace App\Controllers\Admin;

use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Admin\InstansiModel;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */


use CodeIgniter\RESTful\ResourcePresenter;

class Instansi extends ResourcePresenter
{
    protected $helpers = ['form', 'url'];
    public function __construct()
    {
        $this->provinsi = new ProvinsiModel();
        $this->kabupaten = new KabupatenModel();
        $this->kecamatan = new KecamatanModel();
        $this->instansi = new InstansiModel();
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
            'title' => 'INSTANSI',
            'parent' => 2,
            'pmenu' => 2.5
        );
        return view('admin/instansi/v-instansi', $data);
    }

    function load_data() {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }
        $db      = \Config\Database::connect();
        $provinsi = $db->table('provinsi')->get();
        $kabupaten = $db->table('kabupaten')->get();
        $kecamatan = $db->table('kecamatan')->get();
        $list = $this->instansi->get_datatables();
        $count_all = $this->instansi->count_all();
        $count_filter = $this->instansi->count_filter();

        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->kode;
            $row[] = $key->nama_instansi;
            foreach ($provinsi->getResult() as $prov ) {
				if ($prov->id == $key->id_provinsi) {
					$row[] =  $prov->nama_provinsi;
				}
			};
            foreach ($kabupaten->getResult() as $kab ) {
				if ($kab->id == $key->id_kabupaten) {
					$row[] =  $kab->nama_kabupaten;
				}
			};
            foreach ($kecamatan->getResult() as $kec ) {
				if ($kec->id == $key->id_kecamatan) {
					$row[] =  $kec->nama_kecamatan;
				}
			};
            $row[] = '
            <a class="btn btn-xs btn-warning mr-1 mb-1" href="/Admin/Instansi/edit/'.$key->id.'"  data-rel="tooltip" data-placement="top" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
            <a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>
            ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->request->getPost('draw'),
            "recordsTotal" => $count_all->total,
            "recordsFiltered" => $count_filter->total,
            "data" => $data
        );

        $output[$this->csrfToken] = $this->csrfHash;
        echo json_encode($output);
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
            'pmenu' => 2.5,
            'method' => 'New',
            'hiddenID' => '',
        );
        return view('admin/instansi/v-instansiAddEdit', $data);
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
