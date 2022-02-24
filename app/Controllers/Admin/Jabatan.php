<?php

namespace App\Controllers\Admin;
date_default_timezone_set('Asia/Jakarta');
use App\Controllers\BaseController;
use App\Models\Admin\JabatanModel;

class Jabatan extends BaseController
{
    public function __construct()
    {
        $this->jabatan = new JabatanModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
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
            exit('No direct script is allowed');
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
            <a class="btn btn-xs btn-warning mr-1 mb-1 edit" href="javascript:void(0)" name="edit" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
            <a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>
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

    function single_data() {
        if(!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }
        if($this->request->getVar('id')) {
            $data = $this->jabatan->where('id', $this->request->getVar('id'))->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function save()
    {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }

        $validation = \Config\Services::validation();

        if ($this->request->getVar('method') == 'New') {

            $valid = $this->validate([
                'kodeAddEdit' => [
                    'label'     => 'Kode Jabatan',
                    'rules'     => 'required|numeric|max_length[10]|is_unique[etbl_jabatan.kode]',
                    'errors' => [
                        'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                        'max_length' => '{field} Maksimal 10 Karakter',
                        'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                    ],
                ],
                'nama_jabatanAddEdit' => [
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
                        'kode' => $validation->getError('kodeAddEdit'),
                        'nama_jabatan' => $validation->getError('nama_jabatanAddEdit'),
                    ]
                ];
            } else {

                $data = [
                    'kode' => $this->request->getVar('kodeAddEdit'),
                    'nama_jabatan' => $this->request->getVar('nama_jabatanAddEdit')
                ];

                if ($this->jabatan->insert($data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil disimpan');
                } else {
                    $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
                }
            }
        }

        if ($this->request->getVar('method') == 'Edit') {
            $valid = $this->validate([
                'kodeAddEdit' => [
                    'label'     => 'Kode Jabatan',
                    'rules'     => 'required|numeric|max_length[10]',
                    'errors' => [
                        'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                        'max_length' => '{field} Maksimal 10 Karakter',
                    ],
                ],
                'nama_jabatanAddEdit' => [
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
                        'kode' => $validation->getError('kodeAddEdit'),
                        'nama_jabatan' => $validation->getError('nama_jabatanAddEdit'),
                    ]
                ];
            } else {
                $id = $this->request->getVar('hidden_id');
                $data = [
                    'kode' => $this->request->getVar('kodeAddEdit'),
                    'nama_jabatan' => $this->request->getVar('nama_jabatanAddEdit')
                ];

                if ($this->jabatan->update($id, $data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil disimpan');
                } else {
                    $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
                }
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    function delete(){
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
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