<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\JabatanModel;
use App\Models\Admin\PangolModel;
use App\Models\Admin\PegawaiModel;

use CodeIgniter\HTTP\IncomingRequest;


/**
 * @property IncomingRequest $request
*/


class Pegawai extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
        if (session()->get('level') != "Admin") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
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
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
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
            $row[] = '<img alt="Avatar" class="table-avatar" src="'.base_url('/uploads/foto/'.$key->foto).'">';
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
            <a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="/Admin/Pegawai/edit/' . $key->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
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
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $jabatanlist = $this->jabatan->select('kode,nama_jabatan') // Fetch record
                ->orderBy('nama_jabatan')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $jabatanlist = $this->jabatan->select('kode,nama_jabatan') // Fetch record
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
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pangollist = $this->pangol->select('kode,nama_pangol') // Fetch record
                ->orderBy('nama_pangol')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $pangollist = $this->pangol->select('kode,nama_pangol') // Fetch record
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
            'title' => 'Tambah Pegawai',
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
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'nipAddEditForm' => [
                'label'     => 'Nomer NIP',
                'rules'     => 'required|numeric|max_length[25]|is_unique[etbl_pegawai.nip]',
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 25 Karakter',
                    'is_unique' => '{field} Yang Anda masukkan sudah dipakai',
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
                'rules'     => 'required|valid_date[d/m/Y]',
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
                    'uploaded' => 'Harus Ada File Foto',
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
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
                ],
                'msg' => '',
            ];
        } else {

            $file = $this->request->getFile('fotoAddEditForm');
            if($file->isValid() && !$file->hasMoved()){
                $imageName = $file->getRandomName();
                $file->move('uploads/foto/', $imageName);
            }

            $data = [
                'nip' => $this->db->escapeString($this->request->getPost('nipAddEditForm')),
                'nama' => $this->db->escapeString($this->request->getPost('namaAddEditForm')),
                'tgl_lahir' => $this->db->escapeString(date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('lahirAddEditForm'))))),
                'kode_jabatan' => $this->db->escapeString($this->request->getPost('jabatanAddEditForm')),
                'kode_pangol' => $this->db->escapeString($this->request->getPost('pangolAddEditForm')),
                'pelaksana' => $this->db->escapeString($this->request->getPost('pelaksanaAddEditForm')),
                'foto' => $imageName,
                'username' => $this->db->escapeString($this->request->getPost('usernameAddEditForm')),
                'password' => password_hash($this->request->getPost('passwordAddEditForm'), PASSWORD_BCRYPT),
                'level' => $this->db->escapeString($this->request->getPost('levelAddEditForm')),

            ];

            // d($data);print_r($data);die();

            if ($this->pegawai->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/pegawai'));
            } else {
                $data = array('success' => false, 'msg' => $this->pegawai->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }
        }
        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($data);
    }

    function single_data()
    {

        if ($this->request->getVar('id')) {
            $data = $this->pegawai->where('id', $this->request->getVar('id'))->first();

            $data['jabatan'] = $this->jabatan->where('kode', $data['kode_jabatan'])->first();
            $data['pangol'] = $this->pangol->where('kode', $data['kode_pangol'])->first();

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
        if (!$id) {
            // throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            return redirect()->to(site_url('admin/pegawai/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = array(
            'title' => 'Edit Pegawai',
            'parent' => 2,
            'pmenu' => 2.1,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('admin/pegawai/v-pegawaiAddEdit', $data);
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

        $validation = \Config\Services::validation();
        $prop_item = $this->pegawai->where('id', $this->request->getVar('hiddenID'))->first();
        $ids =  $prop_item['id'];
        $valid = $this->validate([
            'nipAddEditForm' => [
                'label'     => 'Nomer NIP',
                'rules'     => "trim|required|numeric|max_length[25]",
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 25 Karakter',
                ],
            ],
            'namaAddEditForm' => [
                'label'     => 'Nama Lengkap',
                'rules'     => "required|max_length[50]",
                'errors' => [
                    'max_length' => '{field} Maksimal 50 Karakter',
                ],
            ],
            'lahirAddEditForm' => [
                'label'     => 'Tanggal lahir',
                'rules'     => 'trim|required',
            ],
            'jabatanAddEditForm' => [
                'label' => 'Nama Jabatan',
                'rules'  => "trim|required|numeric|max_length[20]",
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => "{field} Maksimal 20 Karakter",
                ],
            ],
            'pangolAddEditForm' => [
                'label'     => 'Nama Pangkat & Golongan',
                'rules'     => "trim|required|numeric|max_length[20]",
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'pelaksanaAddEditForm' => [
                'label' => 'Pilih Pelaksana',
                'rules'     => "required",
            ],
            "fotoAddEditForm" => [
                'rules' => "mime_in[fotoAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[fotoAddEditForm,2048]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
            ],
            'usernameAddEditForm' => [
                'label'     => 'Username',
                'rules'     => "required|max_length[20]|is_unique[etbl_pegawai.username,id,$ids]",
                'errors' => [
                    'is_unique' => '{field} Yang Anda masukkan sudah dipakai',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'levelAddEditForm' => [
                'label' => "Pilih Level Access",
                'rules'     => "required",
            ],
        ]);

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
                ],
                'msg' => '',
            ];
        } else {

            $old_image = $prop_item['foto'];
            $file = $this->request->getFile('fotoAddEditForm');
            if($file->isValid() && !$file->hasMoved()){
                if(file_exists("uploads/foto/".$old_image)){
                    unlink("uploads/foto/".$old_image);
                }
                $imageName = $file->getRandomName();
                $file->move('uploads/foto/', $imageName);
            }else{
                $imageName = $old_image;
            }

            $data = [
                'nip' => $this->db->escapeString($this->request->getPost('nipAddEditForm')),
                'nama' => $this->db->escapeString($this->request->getPost('namaAddEditForm')),
                'tgl_lahir' => $this->db->escapeString(date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('lahirAddEditForm'))))),
                'kode_jabatan' => $this->db->escapeString($this->request->getPost('jabatanAddEditForm')),
                'kode_pangol' => $this->db->escapeString($this->request->getPost('pangolAddEditForm')),
                'pelaksana' => $this->db->escapeString($this->request->getPost('pelaksanaAddEditForm')),
                'foto' => $imageName,
                'username' => $this->db->escapeString($this->request->getPost('usernameAddEditForm')),
                'password' => password_hash($this->request->getPost('passwordAddEditForm'), PASSWORD_BCRYPT),
                'level' => $this->db->escapeString($this->request->getPost('levelAddEditForm')),

            ];
            $id = $this->request->getVar('hiddenID');
            if ($this->pegawai->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/pegawai'));
            } else {
                $data = array('success' => false, 'msg' => $this->pegawai->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }

        }
        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($data);
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
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        if ($this->request->getVar('id')) {
            
            $id = $this->request->getVar('id');

            $prop_item = $this->pegawai->where('id', $id)->first();
            $imageName = $prop_item['foto'];

            if(file_exists("uploads/foto/".$imageName)){
                unlink("uploads/foto/".$imageName);
            }
            if ($this->pegawai->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
}
