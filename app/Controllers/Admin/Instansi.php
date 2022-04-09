<?php

namespace App\Controllers\Admin;

use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Admin\InstansiModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */


use CodeIgniter\RESTful\ResourcePresenter;

class Instansi extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
        if (session()->get('level') != "Admin") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $this->provinsi = new ProvinsiModel();
        $this->kabupaten = new KabupatenModel();
        $this->kecamatan = new KecamatanModel();
        $this->instansi = new InstansiModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->db = \Config\Database::connect();
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
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $provinsi = $this->db->table('provinsi')->get();
        $kabupaten = $this->db->table('kabupaten')->get();
        $kecamatan = $this->db->table('kecamatan')->get();
        $list = $this->instansi->get_datatables();
        $count_all = $this->instansi->count_all();
        $count_filter = $this->instansi->count_filter();

        // d($list);print_r($list);die();
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->instansi_kode;
            $row[] = $key->nama_instansi;
            foreach ($provinsi->getResult() as $prov ) {
				if ($prov->kode == $key->kode_provinsi) {
					$row[] =  $prov->nama_provinsi;
				}
			};
            foreach ($kabupaten->getResult() as $kab ) {
				if ($kab->kode == $key->kode_kabupaten) {
					$row[] =  $kab->nama_kabupaten;
				}
			};
            foreach ($kecamatan->getResult() as $kec ) {
				if ($kec->kode == $key->kode_kecamatan) {
					$row[] =  $kec->nama_kecamatan;
				}
			};
            $row[] = '
            <a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="'. base_url('admin/Instansi/edit/'.$key->id).'"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
            <a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>
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

    function generator(){
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $data['kode'] = random_string('numeric');
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    public function getProvinsi(){
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $provinsilist = $this->provinsi->select('kode,nama_provinsi') // Fetch record
                ->orderBy('nama_provinsi')
                ->findAll(10);
        } else {
            $provinsilist = $this->provinsi->select('kode,nama_provinsi') // Fetch record
                ->like('nama_provinsi', $this->request->getPost('searchTerm'))
                ->orderBy('nama_provinsi')
                ->findAll(10);
        }

        $data = array();
        foreach ($provinsilist as $provinsi) {
            $data[] = array(
                "id" => $provinsi['kode'],
                "text" => $provinsi['nama_provinsi'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    public function getKabupaten(){
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if ($this->request->getPost('searchTerm') == NULL) {
            $kabupatenlist = $this->kabupaten->select('kode,nama_kabupaten') // Fetch record
                ->where('kode_provinsi', $this->request->getPost('provinsi'))
                ->orderBy('nama_kabupaten')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kabupaten->select('kode,nama_kabupaten') // Fetch record
                ->like('nama_kabupaten', $this->request->getPost('searchTerm'))
                ->where('kode_provinsi', $this->request->getPost('provinsi'))
                ->orderBy('nama_kabupaten')
                ->findAll(10);
        }

        $data = array();
        foreach ($kabupatenlist as $kabupaten) {
            $data[] = array(
                "id" => $kabupaten['kode'],
                "text" => $kabupaten['nama_kabupaten'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getKecamatan(){
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if ($this->request->getPost('searchTerm') == NULL) {
            $kabupatenlist = $this->kecamatan->select('kode,nama_kecamatan') // Fetch record
                ->where('kode_kabupaten', $this->request->getPost('kabupaten'))
                ->orderBy('nama_kecamatan')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kecamatan->select('kode,nama_kecamatan') // Fetch record
                ->like('nama_kecamatan', $this->request->getPost('searchTerm'))
                ->where('kode_kabupaten', $this->request->getPost('kabupaten'))
                ->orderBy('nama_kecamatan')
                ->findAll(10);
        }

        $data = array();
        foreach ($kabupatenlist as $kabupaten) {
            $data[] = array(
                "id" => $kabupaten['kode'],
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
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
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
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'provinsiAddEditForm' => [
                'label'     => 'Nama Provinsi',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kabupatenAddEditForm' => [
                'label'     => 'Nama Kabupaten',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kecamatanAddEditForm' => [
                'label'     => 'Kecamatan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kodeAddEditForm' => [
                'label'     => 'Kode Instansi',
                'rules'     => 'required|numeric|max_length[10]|is_unique[etbl_instansi.kode]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 10 Karakter',
                    'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                ],
            ],
            'instansiAddEditForm' => [
                'label' => 'Nama Instansi',
                'rules' => 'required|max_length[40]',
                'errors' => [
                    'max_length' => '{field} Maksimal 40 Karakter',
                ],
            ],
        ]);

        if (!$valid) {
            $data = [
                'error' => [
                    'provinsi' => $validation->getError('provinsiAddEditForm'),
                    'kabupaten' => $validation->getError('kabupatenAddEditForm'),
                    'kecamatan' => $validation->getError('kecamatanAddEditForm'),
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                ],
                'msg' => '',
            ];
        } else {

            $data = [
                'kode_provinsi' => $this->db->escapeString($this->request->getVar('provinsiAddEditForm')),
                'kode_kabupaten' => $this->db->escapeString($this->request->getVar('kabupatenAddEditForm')),
                'kode_kecamatan' => $this->db->escapeString($this->request->getVar('kecamatanAddEditForm')),
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'nama_instansi' => $this->db->escapeString($this->request->getVar('instansiAddEditForm')),
            ];
            if ($this->instansi->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/instansi'));
            } else {
                $data = array('success' => false, 'msg' => $this->instansi->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }
        }
        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    function single_data(){

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $instansi_id = $this->instansi->where('id', $this->request->getVar('id'))->get();
        if($instansi_id->getRow() == null){
            return redirect()->to(site_url('admin/instansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('admin/instansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $data = $this->instansi->where('id', $this->request->getVar('id'))->first();

            $data['provinsi'] = $this->provinsi->where('kode', $data['kode_provinsi'])->first();
            $data['kabupaten'] = $this->kabupaten->where('kode', $data['kode_kabupaten'])->first();
            $data['kecamatan'] = $this->kecamatan->where('kode', $data['kode_kecamatan'])->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
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
        $instansi_id = $this->instansi->where('id', $id)->get();
        if($instansi_id->getRow() == null){
            return redirect()->to(site_url('admin/instansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
            return redirect()->to(site_url('admin/instansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = array(
            'title' => 'Edit Intansi',
            'parent' => 2,
            'pmenu' => 2.4,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('admin/instansi/v-instansiAddEdit', $data);
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
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $instansi_id = $this->instansi->where('id', $this->request->getVar('hiddenID'))->get();
        if($instansi_id->getRow() == null){
            return redirect()->to(site_url('admin/instansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('hiddenID')) {
            return redirect()->to(site_url('admin/instansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodeAddEditForm' => [
                'label'     => 'Kode Instansi',
                'rules'     => 'required|numeric|max_length[10]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 10 Karakter',
                ],
            ],
            'provinsiAddEditForm' => [
                'label'     => 'Nama Provinsi',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kabupatenAddEditForm' => [
                'label'     => 'Nama Kabupaten',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kecamatanAddEditForm' => [
                'label'     => 'Kecamatan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'instansiAddEditForm' => [
                'label' => 'Nama Instansi',
                'rules' => 'required|max_length[40]',
                'errors' => [
                    'max_length' => '{field} Maksimal 40 Karakter',
                ],
            ],
        ]);

        if (!$valid) {
            $data = [
                'error' => [
                    'provinsi' => $validation->getError('provinsiAddEditForm'),
                    'kabupaten' => $validation->getError('kabupatenAddEditForm'),
                    'kecamatan' => $validation->getError('kecamatanAddEditForm'),
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                ],
                'msg' => '',
            ];
        } else {
            $id = $this->request->getVar('hiddenID');
            $data = [
                'kode_provinsi' => $this->db->escapeString($this->request->getVar('provinsiAddEditForm')),
                'kode_kabupaten' => $this->db->escapeString($this->request->getVar('kabupatenAddEditForm')),
                'kode_kecamatan' => $this->db->escapeString($this->request->getVar('kecamatanAddEditForm')),
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'nama_instansi' => $this->db->escapeString($this->request->getVar('instansiAddEditForm')),
            ];
            if ($this->instansi->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/instansi'));
            } else {
                $data = array('success' => false, 'msg' => $this->instansi->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }
        }
        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
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
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
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
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $instansi_id = $this->instansi->where('id', $this->request->getVar('id'))->get();
        if($instansi_id->getRow() == null){
            return redirect()->to(site_url('admin/instansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('admin/instansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $id = $this->request->getVar('id');

            if ($this->instansi->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
}
