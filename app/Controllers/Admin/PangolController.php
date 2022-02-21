<?php

namespace App\Controllers\Admin;
// date_default_timezone_set('Asia/Jakarta');
use App\Models\Admin\PangolModel;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class PangolController extends BaseController
{

    public function __construct()
    {
        $this->group = new PangolModel();
    }
    public function index()
    {

        $data = array(
            'title' => 'PANGKAT & GOLONGAN',
            'parent' => 2,
            'pmenu' => 2.2,
        );
        return view('admin/pangol/v-pangol', $data);
    }

    function load_data()
    {

        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }
        // $model = new PangolModel();

        $csrfToken = csrf_token();
        $csrfHash = csrf_hash();

        $list = $this->group->get_datatables();
        $count_all = $this->group->count_all();
        $count_filter = $this->group->count_filter();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->kode;
            $row[] = $key->nama_pangol;
            $row[] = '
            <a class="btn btn-xs btn-warning mr-1 mb-1 edit" style="margin-right:5px;" href="javascript:void(0)" name="edit" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
            <a class="btn btn-xs btn-danger mr-1 mb-1 delete" style="margin-right:5px;" href="javascript:void(0)" name="edit" data-id="' . $key->id . '" data-id="" data-rel="tooltip" data-placement="top" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>
            ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $count_all->total,
            "recordsFiltered" => $count_filter->total,
            "data" => $data
        );

        $output[$csrfToken] = $csrfHash;
        echo json_encode($output);
    }

    function single_data()
    {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }

        $csrfToken = csrf_token();
        $csrfHash = csrf_hash();

        if ($this->request->getVar('id')) {
            $data = $this->group->where('id', $this->request->getVar('id'))->first();

            $data[$csrfToken] = $csrfHash;
            echo json_encode($data);
        }
    }

    function save()
    {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }

        $csrfToken = csrf_token();
        $csrfHash = csrf_hash();

        $validation = \Config\Services::validation();

        if ($this->request->getVar('method') == 'New') {

            $valid = $this->validate([
                'kode' => [
                    'label'     => 'Kode Pangkat & Golongan',
                    'rules'     => 'required|numeric|max_length[10]|is_unique[etbl_pangol.kode]',
                    'errors' => [
                        'numeric' => 'Hanya Bisa Memasukkan Angka',
                        'max_length' => 'Maksimal 10 Karakter',
                        'is_unique' => 'Kode Yang Anda masukkan sudah dipakai',
                    ],
                ],
                'nama_pangol' => [
                    'label' => 'Nama Pangkat & Golongan',
                    'rules' => 'required|max_length[20]',
                    'errors' => [
                        'max_length' => 'Maksimal 20 Karakter',
                    ],
                ]
            ]);

            if (!$valid) {
                $data = [
                    'error' => [
                        'kode' => $validation->getError('kode'),
                        'nama_pangol' => $validation->getError('nama_pangol'),
                    ]
                ];
            } else {

                $data = [
                    'kode' => $this->request->getVar('kode'),
                    'nama_pangol' => $this->request->getVar('nama_pangol')
                ];

                if ($this->group->insert($data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil disimpan');
                } else {
                    $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
                }
            }
        }

        if ($this->request->getVar('method') == 'Edit') {
            $valid = $this->validate([
                'kode' => [
                    'label'     => 'Kode Pangkat & Golongan',
                    'rules'     => 'required|numeric|max_length[10]',
                    'errors' => [
                        'numeric' => 'Hanya Boleh Memasukkan Angka',
                        'max_length' => 'Maksimal 10 Karakter',
                    ],
                ],
                'nama_pangol' => [
                    'label' => 'Nama Pangkat & Golongan',
                    'rules' => 'required|max_length[20]',
                    'errors' => [
                        'max_length' => 'Maksimal 20 Karakter',
                    ],
                ]
            ]);

            if (!$valid) {
                $data = [
                    'error' => [
                        'kode' => $validation->getError('kode'),
                        'nama_pangol' => $validation->getError('nama_pangol'),
                    ]
                ];
            } else {
                $id = $this->request->getVar('hidden_id');
                $data = [
                    'kode' => $this->request->getVar('kode'),
                    'nama_pangol' => $this->request->getVar('nama_pangol')
                ];

                if ($this->group->update($id, $data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil disimpan');
                } else {
                    $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
                }
            }
        }

        $data[$csrfToken] = $csrfHash;
        echo json_encode($data);
    }

    function delete(){
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }

        $csrfToken = csrf_token();
        $csrfHash = csrf_hash();

        if ($this->request->getVar('id')){
            $id = $this->request->getVar('id');

            if ($this->group->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$csrfToken] = $csrfHash;
        echo json_encode($data);
    }
}
