<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\JabatanModel;
use App\Models\Admin\PangolModel;
use App\Models\Admin\PegawaiModel;

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Files\File;


/**
 * @property IncomingRequest $request
 */


class Pegawai extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
        $this->jabatan = new JabatanModel();
        $this->pangol = new PangolModel();
        $this->pegawai = new PegawaiModel();
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
            'title' => 'PEGAWAI',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('admin/pegawai/v-pegawai', $data);
    }

    function load_data() {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }
        $jabatan = $this->db->table('jabatan')->get();
        $pangol = $this->db->table('pangol')->get();
        $list = $this->pegawai->get_datatables();
        $count_all = $this->pegawai->count_all();
        $count_filter = $this->pegawai->count_filter();

        // d($list);print_r($list);die();
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->nip;
            $row[] = $key->nama;
            $row[] = $key->foto;
            foreach ($jabatan->getResult() as $jbt ) {
				if ($jbt->kode == $key->kode_jabatan) {
					$row[] =  $jbt->nama_jabatan;
				}
			};
            foreach ($pangol->getResult() as $pang ) {
				if ($pang->kode == $key->kode_pangol) {
					$row[] =  $pang->nama_pangol;
				}
			};
            $row[] = $key->username;
            $row[] = $key->level;
            $row[] = '
            <a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="/Admin/Instansi/edit/' . $key->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
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

    public function getJabatan()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $jabatanlist = $this->jabatan->select('kode,nama_jabatan') // Fetch record
                ->where('deleted_at', NULL)
                ->orderBy('nama_jabatan')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $jabatanlist = $this->jabatan->select('kode,nama_jabatan') // Fetch record
                ->where('deleted_at', NULL)
                ->like('nama_jabatan', $this->request->getPost('searchTerm'))
                ->orderBy('nama_jabatan')
                ->findAll(10);
        }

        $data = array();
        foreach ($jabatanlist as $jabatan) {
            $data[] = array(
                "id" => $jabatan['kode'],
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
            $pangollist = $this->pangol->select('kode,nama_pangol') // Fetch record
                ->where('deleted_at', NULL)
                ->orderBy('nama_pangol')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $pangollist = $this->jabatan->select('kode,nama_pangol') // Fetch record
                ->where('deleted_at', NULL)
                ->like('nama_pangol', $this->request->getPost('searchTerm'))
                ->orderBy('nama_pangol')
                ->findAll(10);
        }

        $data = array();
        foreach ($pangollist as $pangol) {
            $data[] = array(
                "id" => $pangol['kode'],
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
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'nipAddEditForm' => [
                'label'     => 'Nomer NIP',
                'rules'     => 'required|numeric|max_length[25]|is_unique[etbl_pegawai.nip]',
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 25 Karakter',
                    'is_unique' => '{field} NIP Yang Anda masukkan sudah dipakai',
                ],
            ],
            'namaAddEditForm' => [
                'label'     => 'Nama Lengkap',
                'rules'     => 'required|max_length[50]',
                'errors' => [
                    'max_length' => '{field} Maksimal 50 Karakter',
                ],
            ],
            'lahirAddEditForm' => [
                'label'     => 'Tanggal lahir',
                'rules'     => 'required|',
            ],
            'jabatanAddEditForm' => [
                'label' => 'Nama Jabatan',
                'rules'  => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'pangolAddEditForm' => [
                'label'     => 'Nama Pangkat & Golongan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'pelaksanaAddEditForm' => [
                'label' => 'Pilih Pelaksana',
                'rules'     => 'required',
            ],
            "fotoAddEditForm" => [
                'rules' => 'uploaded[fotoAddEditForm]|mime_in[fotoAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[fotoAddEditForm,2048]',
				'errors' => [
					'uploaded' => 'Harus Ada File yang diupload',
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'

                ]
            ],
            'usernameAddEditForm' => [
                'label'     => 'Username',
                'rules'     => 'required|max_length[20]|is_unique[etbl_pegawai.username]',
                'errors' => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'passwordAddEditForm' => [
                'label'     => 'Password',
                'rules'     => 'required|min_length[3]',
                'errors' => [
                    'max_length' => '{field} Minimal 3 Karakter',
                ],
            ],
            'levelAddEditForm' => [
                'label' => 'Pilih Level Access',
                'rules'     => 'required',
            ],
        ]);

        // // d($this->request->getEnv());print_r($this->request->getEnv());
        // d($this->request->getFile('fotoAddEditForm'));print_r($this->request->getFile('fotoAddEditForm'));die();

        if (!$valid) {
            /**
             *'kode' => $validation->getError('kodeAddEdit'),
             * 'kode' -> id or class to display error
             * 'kodeAddEdit' -> name field that ajax send
             */
            $data = [
                'error' => [
                    'nip' => $validation->getError('nipAddEditForm'),
                    'nama' => $validation->getError('namaAddEditForm'),
                    'lahir' => $validation->getError('lahirAddEditForm'),
                    'jabatan' => $validation->getError('jabatanAddEditForm'),
                    'pangol' => $validation->getError('pangolAddEditForm'),
                    'pelaksana' => $validation->getError('pelaksanaAddEditForm'),
                    'foto' => $validation->getError('fotoAddEditForm'),
                    'username' => $validation->getError('usernameAddEditForm'),
                    'password' => $validation->getError('passwordAddEditForm'),
                    'level' => $validation->getError('levelAddEditForm'),
                ]
            ];
        } else {

            $dataBerkas = $this->request->getFile('fotoAddEditForm');
            $fileName = $dataBerkas->getRandomName();
            $dataBerkas->move('public/foto/', $fileName);

            d($dataBerkas);print_r($dataBerkas);die();

            $data = [
                'nip' => $this->db->escapeString($this->request->getVar('nipAddEditForm')),
                'nama' => $this->db->escapeString($this->request->getVar('namaAddEditForm')),
                'tgl_lahir' => $this->db->escapeString($this->request->getVar('lahirAddEditForm')),
                'kode_jabatan' => $this->db->escapeString($this->request->getVar('jabatanAddEditForm')),
                'kode_pangol' => $this->db->escapeString($this->request->getVar('pangolAddEditForm')),
                'pelaksana' => $this->db->escapeString($this->request->getVar('pelaksanaAddEditForm')),
                'foto' => $fileName,
                'username' => $this->db->escapeString($this->request->getVar('usernameAddEditForm')),
                'password' => password_hash($this->request->getVar('passwordAddEditForm'), PASSWORD_BCRYPT),
                'level' => $this->db->escapeString($this->request->getVar('levelAddEditForm')),

            ];

            // return view('upload_success', $data);
            if ($this->pegawai->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/sbuh'));
            } else {
                $data = array('success' => false, 'msg' => $this->pegawai->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }

        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
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
