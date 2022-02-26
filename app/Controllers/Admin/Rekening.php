<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\JenisWilayahModel;
use App\Models\Admin\RekeningModel;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */


class Rekening extends BaseController
{
    public function __construct()
    {
        $this->rekening = new RekeningModel();
        $this->jenis = new JenisWilayahModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
    }
    public function index()
    {
        $data = array(
            'title' => 'KODE REKENING',
            'parent' => 2,
            'pmenu' => 2.7
        );
        return view('admin/rekening/v-rekening', $data);
    }

    function load_data()
    {

        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }
        $db    = \Config\Database::connect();
        $jenis = $db->table('jenis_wilayah')->get();
        $list = $this->rekening->get_datatables();
        $count_all = $this->rekening->count_all();
        $count_filter = $this->rekening->count_filter();

        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->kode;
            foreach ($jenis->getResult() as $jen) {
                if ($jen->id == $key->id_jenis_wilayah) {
                    $row[] =  $jen->nama_provinsi;
                }
            };
            $row[] = $key->nomer_rekening;
            $row[] = '
            <a class="btn btn-xs btn-warning mr-1 mb-1 edit" href="javascript:void(0)" name="edit" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
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

    public function getJenis()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $provinsilist = $this->jenis->select('id,jenis_wilayah') // Fetch record
                ->where('deleted_at', NULL)
                ->orderBy('jenis_wilayah')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $provinsilist = $this->provinsi->select('id,jenis_wilayah') // Fetch record
                ->where('deleted_at', NULL)
                ->like('nama_provinsi', $this->request->getPost('searchTerm'))
                ->orderBy('jenis_wilayah')
                ->findAll(10);
        }

        $data = array();
        foreach ($provinsilist as $provinsi) {
            $data[] = array(
                "id" => $provinsi['id'],
                "text" => $provinsi['jenis_wilayah'],
            );
        }

        // $response['count'] = $count;
        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    function single_data()
    {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }

        if ($this->request->getVar('id')) {
            $data = $this->jenis->where('id', $this->request->getVar('id'))->first();

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
                'kodeAddEditForm' => [
                    'label'     => 'Kode Pangkat & Golongan',
                    'rules'     => 'required|numeric|max_length[10]|is_unique[etbl_rekening.kode]',
                    'errors' => [
                        'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                        'max_length' => '{field} Maksimal 10 Karakter',
                        'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                    ],
                ],
                'jenisWilayahAddEditForm' => [
                    'label'     => 'Jenis Wilayah',
                    'rules'     => 'required|numeric|max_length[20]',
                    'errors' => [
                        'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                        'max_length' => '{field} Maksimal 20 Karakter',
                    ],
                ],
                'rekeningAddEditForm' => [
                    'label' => 'Nomer Rekening',
                    'rules' => 'required|numeric|max_length[12]',
                    'errors' => [
                        'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                        'max_length' => '{field} Maksimal 12 Karakter',
                    ],
                ]
            ]);

            if (!$valid) {
                $data = [
                    'error' => [
                        'kode' => $validation->getError('kodeAddEditForm'),
                        'jenisWilayah' => $validation->getError('jenisWilayahAddEditForm'),
                        'rekening' => $validation->getError('rekeningAddEditForm'),
                    ]
                ];
            } else {

                $data = [
                    'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                    'id_jenis_wilayah' => $this->db->escapeString($this->request->getVar('jenisWilayahAddEditForm')),
                    'nomer_rekening' => $this->db->escapeString($this->request->getVar('jenisWilayahAddEditForm')),
                ];

                if ($this->rekening->insert($data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil disimpan');
                } else {
                    $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
                }
            }
        }

        if ($this->request->getVar('method') == 'Edit') {
            $valid = $this->validate([
                'kodeAddEditForm' => [
                    'label'     => 'Kode Pangkat & Golongan',
                    'rules'     => 'required|numeric|max_length[10]',
                    'errors' => [
                        'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                        'max_length' => '{field} Maksimal 10 Karakter',
                    ],
                ],
                'jenisWilayahAddEditForm' => [
                    'label'     => 'Jenis Wilayah',
                    'rules'     => 'required|numeric|max_length[20]',
                    'errors' => [
                        'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                        'max_length' => '{field} Maksimal 20 Karakter',
                    ],
                ],
                'rekeningAddEditForm' => [
                    'label' => 'Nomer Rekening',
                    'rules' => 'required|numeric|max_length[12]',
                    'errors' => [
                        'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                        'max_length' => '{field} Maksimal 12 Karakter',
                    ],
                ]
            ]);

            if (!$valid) {
                $data = [
                    'error' => [
                        'kode' => $validation->getError('kodeAddEditForm'),
                        'jenisWilayah' => $validation->getError('jenisWilayahAddEditForm'),
                        'rekening' => $validation->getError('rekeningAddEditForm'),
                    ]
                ];
            } else {
                $id = $this->request->getVar('hidden_id');
                $data = [
                    'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                    'id_jenis_wilayah' => $this->db->escapeString($this->request->getVar('jenisWilayahAddEditForm')),
                    'nomer_rekening' => $this->db->escapeString($this->request->getVar('jenisWilayahAddEditForm')),
                ];
                if ($this->rekening->update($id, $data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil diupdate');
                } else {
                    $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
                }
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
}
