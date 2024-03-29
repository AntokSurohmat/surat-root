<?php

namespace App\Controllers\Admin;
date_default_timezone_set('Asia/Jakarta');
use App\Controllers\BaseController;
use App\Models\Admin\JabatanModel;

class Jabatan extends BaseController
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
        if (session()->get('level') != "Admin") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $this->jabatan = new JabatanModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
        $this->session = \Config\Services::session();
        $this->session->start();
    }
    public function index()
    {
        $data = array(
            'title' => 'JABATAN',
            'parent' => 2,
            'pmenu' => 2.3
        );
        return view('admin/jabatan/v-jabatan', $data);
    }

    function load_data(){
        if(!$this->request->isAJAX()){
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $list = $this->jabatan->get_datatables();
        $count_all = $this->jabatan->count_all();
        $count_filter = $this->jabatan->count_filter();

        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->kode;
            $row[] = $key->nama_jabatan;
            $row[] = '
            <a class="btn btn-xs btn-warning mr-1 mb-1 edit" href="javascript:void(0)" name="edit" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
            <a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>
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

    function single_data() { // display single data from page show 
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
         }
         $jabatan_id = $this->jabatan->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
         if($jabatan_id->getRow() == null){
              return redirect()->to(site_url('admin/jabatan/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }
         if (!$this->request->getVar('id')) {
              return redirect()->to(site_url('admin/jabatan/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }
        if($this->request->getVar('id')) {
            $data = $this->jabatan->where('id', $this->request->getVar('id'))->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function generator(){ // generate code for Jabatan
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $data['kode'] = random_string('numeric');
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    function save() // because using modal better use one function
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
         }

        $validation = \Config\Services::validation();

        if ($this->request->getVar('method') == 'New') { // if data == insert / process new

            $valid = $this->validate([
                'kodeAddEditForm' => [
                    'label'     => 'Kode Jabatan',
                    'rules'     => 'required|numeric|max_length[20]|is_unique[jabatan.kode]',
                    'errors' => [
                        'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                        'max_length' => '{field} Maksimal 20 Karakter',
                        'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                    ],
                ],
                'jabatanAddEditForm' => [
                    'label' => 'Nama Jabatan',
                    'rules' => 'required|max_length[20]',
                    'errors' => [
                        'max_length' => '{field} Maksimal 20 Karakter',
                    ],
                ]
            ]);

            if (!$valid) {
                $data = [
                    'error' => [
                        'kode' => $validation->getError('kodeAddEditForm'),
                        'jabatan' => $validation->getError('jabatanAddEditForm'),
                    ],
                    'msg' => '',
                ];
            } else {

                $data = [
                    'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                    'nama_jabatan' => $this->db->escapeString($this->request->getVar('jabatanAddEditForm')),
                ];

                if ($this->jabatan->insert($data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil disimpan');
                } else {
                    $data = array('success' => false, 'msg' => $this->jabatan->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                }
            }
        }

        if ($this->request->getVar('method') == 'Edit') { // if data == update / process

            $jabatan_id = $this->jabatan->where('id', $this->request->getVar('hidden_id'))->where('deleted_at', null)->get();
            if($jabatan_id->getRow() == null){
                 return redirect()->to(site_url('admin/jabatan/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
            }
            if (!$this->request->getVar('hidden_id')) {
                 return redirect()->to(site_url('admin/jabatan/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
            }
   
            $valid = $this->validate([
                'kodeAddEditForm' => [
                    'label'     => 'Kode Jabatan',
                    'rules'     => 'required|numeric|max_length[20]',
                    'errors' => [
                        'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                        'max_length' => '{field} Maksimal 20 Karakter',
                    ],
                ],
                'jabatanAddEditForm' => [
                    'label' => 'Nama Jabatan',
                    'rules' => 'required|max_length[20]',
                    'errors' => [
                        'max_length' => '{field} Maksimal 20 Karakter',
                    ],
                ]
            ]);

            if (!$valid) {
                $data = [
                    'error' => [
                        'kode' => $validation->getError('kodeAddEditForm'),
                        'jabatan' => $validation->getError('jabatanAddEditForm'),
                    ],
                    'msg' => '',
                ];
            } else {
                $id = $this->request->getVar('hidden_id');
                $data = [
                    'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                    'nama_jabatan' => $this->db->escapeString($this->request->getVar('jabatanAddEditForm')),
                ];

                if ($this->jabatan->update($id, $data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil disimpan');
                } else {
                    $data = array('success' => false, 'msg' => $this->jabatan->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                }
            }
        }
        
        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    function delete(){ // process delete
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $jabatan_id = $this->jabatan->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
        if($jabatan_id->getRow() == null){
             return redirect()->to(site_url('admin/jabatan/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
             return redirect()->to(site_url('admin/jabatan/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')){
            $id = $this->request->getVar('id');

            if ($this->jabatan->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
}
