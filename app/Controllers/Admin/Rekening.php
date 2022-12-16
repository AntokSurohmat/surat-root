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
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
        if (session()->get('level') != "Admin") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $this->rekening = new RekeningModel();
        $this->jenis = new JenisWilayahModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->db = \Config\Database::connect();
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

    function load_data() // load data
    { 

        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $jenis = $this->db->table('jenis_wilayah')->get();
        $list = $this->rekening->get_datatables();
        $count_all = $this->rekening->count_all();
        $count_filter = $this->rekening->count_filter();

        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->kodes;
            foreach ($jenis->getResult() as $jen) {
                if ($jen->kode == $key->kode_jenis_wilayah) {
                    $row[] =  $jen->jenis_wilayah;
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

    function generator(){ // genearate code rekening
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $data['kode'] = random_string('numeric');
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    public function getJenis() // get jenis wilayah using select2
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $provinsilist = $this->jenis->select('kode,jenis_wilayah') // Fetch record
                ->where('deleted_at', null)
                ->orderBy('jenis_wilayah')
                ->findAll(10);
        } else {
            $provinsilist = $this->provinsi->select('kode,jenis_wilayah') // Fetch record
                ->where('deleted_at', null)
                ->like('nama_provinsi', $this->request->getPost('searchTerm'))
                ->orderBy('jenis_wilayah')
                ->findAll(10);
        }

        $data = array();
        foreach ($provinsilist as $provinsi) {
            $data[] = array(
                "id" => $provinsi['kode'],
                "text" => $provinsi['jenis_wilayah'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    function single_data() // display single data in page show
    {
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $rekening_id = $this->rekening->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
        if($rekening_id->getRow() == null){
            return redirect()->to(site_url('admin/rekening/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('admin/rekening/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $data = $this->rekening->where('id', $this->request->getVar('id'))->first();

            $data['jenis'] = $this->jenis->where('kode', $data['kode_jenis_wilayah'])->first();
            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function save() // because using modal insert and update one function
    {
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $validation = \Config\Services::validation();

        if ($this->request->getVar('method') == 'New') { // if insert

            $valid = $this->validate([
                'kodeAddEditForm' => [
                    'label'     => 'Kode',
                    'rules'     => 'required|numeric|max_length[20]|is_unique[rekening.kode]',
                    'errors' => [
                        'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                        'max_length' => '{field} Maksimal 20 Karakter',
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
                    ],
                    'msg' => '',
                ];
            } else {

                $data = [
                    'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                    'kode_jenis_wilayah' => $this->db->escapeString($this->request->getVar('jenisWilayahAddEditForm')),
                    'nomer_rekening' => $this->db->escapeString($this->request->getVar('rekeningAddEditForm')),
                ];

                if ($this->rekening->insert($data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil disimpan');
                } else {
                    $data = array('success' => false, 'msg' => $this->rekening->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                }
            }
        }

        if ($this->request->getVar('method') == 'Edit') { // if edit
            if (!$this->request->isAJAX()) {
                throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
             }
             $rekening_id = $this->rekening->where('id', $this->request->getVar('hidden_id'))->where('deleted_at', null)->get();
             if($rekening_id->getRow() == null){
                 return redirect()->to(site_url('admin/rekening/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
             }
             if (!$this->request->getVar('hidden_id')) {
                 return redirect()->to(site_url('admin/rekening/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
             }

            $valid = $this->validate([
                'kodeAddEditForm' => [
                    'label'     => 'Kode',
                    'rules'     => 'required|numeric|max_length[20]',
                    'errors' => [
                        'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                        'max_length' => '{field} Maksimal 20 Karakter',
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
                    ],
                    'msg' => '',
                ];
            } else {
                $id = $this->request->getVar('hidden_id');
                $data = [
                    'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                    'kode_jenis_wilayah' => $this->db->escapeString($this->request->getVar('jenisWilayahAddEditForm')),
                    'nomer_rekening' => $this->db->escapeString($this->request->getVar('rekeningAddEditForm')),
                ];
                if ($this->rekening->update($id, $data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil diupdate');
                } else {
                    $data = array('success' => false, 'msg' => $this->rekening->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                }
            }
        }
        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data); return false; 
    }

    function delete(){
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $rekening_id = $this->rekening->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
        if($rekening_id->getRow() == null){
            return redirect()->to(site_url('admin/rekening/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('admin/rekening/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')){
            $id = $this->request->getVar('id');

            if ($this->rekening ->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
}
