<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Admin\SptModel;

use CodeIgniter\HTTP\IncomingRequest;


/**
 * @property IncomingRequest $request
*/

class Spt extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
        if (session()->get('level') != "Admin") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $this->pegawai = new PegawaiModel();
        $this->instansi = new instansiModel();
        $this->provinsi = new ProvinsiModel();
        $this->kabupaten = new KabupatenModel();
        $this->kecamatan = new KecamatanModel();
        $this->spt = new SptModel();
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
            'title' => 'Surat Perintah Tugas',
            'parent' => 3,
            'pmenu' => 3.1
        );
        return view('admin/spt/v-spt', $data);
    }
    function load_data() {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }
        $pegawai = $this->db->table('pegawai')->get();
        $list = $this->spt->get_datatables();
        $count_all = $this->spt->count_all();
        $count_filter = $this->spt->count_filter();

        // d($list);print_r($list);die();
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->kodes;
            $row[] = $key->pegawai_all;
            $row[] = $key->dasar;
            $row[] = $key->untuk;
            foreach ($pegawai->getResult() as $pega ) {
				if ($pega->nip == $key->pejabat) {
					$row[] =  $pega->nama;
				}
			};
            
            if($key->status == 'Disetujui'){
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="javascript:void(0)" name="print" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
                $button .= '<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>';
            }else{
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                $button .='<a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="/Admin/spt/edit/' . $key->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>';
                $button .= '<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>';
            }

            $row[] = $button;
            $row[] = $key->status;
            $row[] = $key->keterangan;
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

    public function getPegawai()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('level', 'Pegawai')
                ->orderBy('nama')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('level', 'Pegawai')
                ->like('nama', $this->request->getPost('searchTerm'))
                ->orderBy('nama')
                ->findAll(10);
        }

        $data = array();
        foreach ($pegawailist as $pegawai) {
            $data[] = array(
                "id" => $pegawai['nip'],
                "text" => $pegawai['nama'],
            );
        }

        // $response['count'] = $count;
        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getInstansi()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $instansilist = $this->instansi->select('kode,nama_instansi') // Fetch record
                ->orderBy('nama_instansi')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $instansilist = $this->instansi->select('kode,nama_instansi') // Fetch record
                ->like('nama_instansi', $this->request->getPost('searchTerm'))
                ->orderBy('nama_instansi')
                ->findAll(10);
        }

        $data = array();
        foreach ($instansilist as $instansi) {
            $data[] = array(
                "id" => $instansi['kode'],
                "text" => $instansi['nama_instansi'],
            );
        }

        // $response['count'] = $count;
        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    function getAlamatInstansi()
    {

        if ($this->request->getVar('instansi')) {
            $data = $this->instansi->where('kode', $this->request->getVar('instansi'))->first();

            $provinsi = $this->provinsi->where('kode', $data['kode_provinsi'])->first();
            $kabupaten = $this->kabupaten->where('kode', $data['kode_kabupaten'])->first();
            $kecamatan = $this->kecamatan->where('kode', $data['kode_kecamatan'])->first();

            $data['alamat'] = $kecamatan['nama_kecamatan'].', '.$kabupaten['nama_kabupaten'].', '.$provinsi['nama_provinsi'];
            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    public function getDiperintah()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->orderBy('nama')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->like('nama', $this->request->getPost('searchTerm'))
                ->orderBy('nama')
                ->findAll(10);
        }

        $data = array();
        foreach ($pegawailist as $pegawai) {
            $data[] = array(
                "id" => $pegawai['nip'],
                "text" => $pegawai['nama'],
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
            'title' => 'Tambah Data Surat Perintah Tugas',
            'parent' => 3,
            'pmenu' => 3.1,
            'method' => 'New',
            'hiddenID' => '',
        );
        return view('admin/spt/v-sptAddEdit', $data);
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

        if($this->request->getVar('pegawaiAddEditForm[]') == NULL){
            $valid = $this->validate([

                'pegawaiAddEditForm[]' => [
                    'label' => 'Nama Pegawai',
                    'rules' => 'required',
                ],
            ]);
        }
        $valid = $this->validate([
            'kodeAddEditForm' => [
                'label'     => 'No SPT',
                'rules'     => 'required|numeric|max_length[3]|is_unique[etbl_spt.kode]',
                'errors' => [
                    'numeric'       => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length'    => '{field} Maksimal 3 Karakter',
                    'is_unique'     => '{field} NIP Yang Anda masukkan sudah dipakai',
                ],
            ],
            'dasarAddEditForm' => [
                'label'     => 'Dasar Pengajuan SPT',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'untukAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'instansiAddEditForm' => [
                'label'     => 'Nama Instansi',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'alamatAddEditForm' => [
                'label'     => 'Alamat Instansi',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'startAddEditForm' => [
                'label'     => 'Tanggal Pergi',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'endAddEditForm'   => [
                'label'     => 'Tanggal Kembali',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'lamaAddEditForm'  => [
                'label'     => 'Lama Perjalanan',
                'rules'     => 'required|numeric|max_length[2]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 2 Karakter',
                ] 
            ],
            'diperintahAddEditForm' => [
                'label'     => 'Pejabat Yang Memberikan Perintah',
                'rules'     => 'required|numeric|max_length[25]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 25 Karakter',
                ]
            ]
        ]);

        // dd($valid);

        if (!$valid) {
            /**
             *'kode' => $validation->getError('kodeAddEdit'),
             * 'kode' -> id or class to display error
             * 'kodeAddEdit' -> name field that ajax send
             */
            $data = [
                'error' => [
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'pegawai' => $validation->getError('pegawaiAddEditForm[]'),
                    'dasar' => $validation->getError('dasarAddEditForm'),
                    'untuk' => $validation->getError('untukAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                    'alamat' => $validation->getError('alamatAddEditForm'),
                    'start' => $validation->getError('startAddEditForm'),
                    'end' => $validation->getError('endAddEditForm'),
                    'lama' => $validation->getError('lamaAddEditForm'),
                    'diperintah' => $validation->getError('diperintahAddEditForm'),
                ],
                'msg' => '',
            ];
        }else{

            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'pegawai_all' => json_encode($this->request->getVar('pegawaiAddEditForm[]')),
                'dasar' => $this->db->escapeString($this->request->getVar('dasarAddEditForm')),
                'untuk' => $this->db->escapeString($this->request->getVar('untukAddEditForm')),
                'kode_instansi' => $this->db->escapeString($this->request->getVar('instansiAddEditForm')),
                'alamat_instansi' => $this->db->escapeString($this->request->getVar('alamatAddEditForm')),
                'awal' => date("Y-m-d", strtotime(str_replace('/', '-', $this->request->getVar('startAddEditForm')))),
                'akhir' => date("Y-m-d", strtotime(str_replace('/', '-', $this->request->getVar('endAddEditForm')))),
                'lama' => $this->db->escapeString($this->request->getVar('lamaAddEditForm')),
                'pejabat' => $this->db->escapeString($this->request->getVar('diperintahAddEditForm')),
                'status' => 'Pending',
            ];

            if ($this->spt->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/spt'));
            } else {
                $data = array('success' => false, 'msg' => $this->spt->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }

        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($data);
    }

    function view_data()
    {

        if ($this->request->getVar('id')) {
            $data = $this->spt->where('id', $this->request->getVar('id'))->first();

            $builder = $this->db->table('pegawai');
            $query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->whereIn('pegawai.nip', json_decode($data['pegawai_all']))->get();

            $data['looping'] = $query->getResult();
            $data['pegawai'] = $this->pegawai->where('nip', $data['pejabat'])->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function single_data()
    {
        if ($this->request->getVar('id')) {
            $data = $this->spt->where('id', $this->request->getVar('id'))->first();

            $builder = $this->db->table('pegawai');
            $query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->whereIn('pegawai.nip', json_decode($data['pegawai_all']))->get();

            $data['pegawai'] = $query->getResult();
            $data['pejabat'] = $this->pegawai->where('nip', $data['pejabat'])->first();
            $data['instansi'] = $this->instansi->where('kode', $data['kode_instansi'])->first();

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
            return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = array(
            'title' => 'Edit Surat Perintah Tugas',
            'parent' => 3,
            'pmenu' => 3.1,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('admin/spt/v-sptAddEdit', $data);
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
            exit('No direct script is allowed');
        }
        
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodeAddEditForm' => [
                'label'     => 'No SPT',
                'rules'     => 'required|numeric|max_length[3]',
                'errors' => [
                    'numeric'       => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length'    => '{field} Maksimal 3 Karakter',
                ],
            ],
            'dasarAddEditForm' => [
                'label'     => 'Dasar Pengajuan SPT',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'untukAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'instansiAddEditForm' => [
                'label'     => 'Nama Instansi',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'alamatAddEditForm' => [
                'label'     => 'Alamat Instansi',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'startAddEditForm' => [
                'label'     => 'Tanggal Pergi',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'endAddEditForm'   => [
                'label'     => 'Tanggal Kembali',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'lamaAddEditForm'  => [
                'label'     => 'Lama Perjalanan',
                'rules'     => 'required|numeric|max_length[2]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 2 Karakter',
                ] 
            ],
            'diperintahAddEditForm' => [
                'label'     => 'Pejabat Yang Memberikan Perintah',
                'rules'     => 'required|numeric|max_length[25]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 25 Karakter',
                ]
            ]
        ]);

        // dd($valid);

        if (!$valid) {
            /**
             *'kode' => $validation->getError('kodeAddEdit'),
             * 'kode' -> id or class to display error
             * 'kodeAddEdit' -> name field that ajax send
             */
            $data = [
                'error' => [
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'pegawai' => $validation->getError('pegawaiAddEditForm[]'),
                    'dasar' => $validation->getError('dasarAddEditForm'),
                    'untuk' => $validation->getError('untukAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                    'alamat' => $validation->getError('alamatAddEditForm'),
                    'start' => $validation->getError('startAddEditForm'),
                    'end' => $validation->getError('endAddEditForm'),
                    'lama' => $validation->getError('lamaAddEditForm'),
                    'diperintah' => $validation->getError('diperintahAddEditForm'),
                    'keterangan' => $validation->getError('diperintahAddEditForm'),
                ],
                'msg' => '',
            ];
        }else{

            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'pegawai_all' => json_encode($this->request->getVar('pegawaiAddEditForm[]')),
                'dasar' => $this->db->escapeString($this->request->getVar('dasarAddEditForm')),
                'untuk' => $this->db->escapeString($this->request->getVar('untukAddEditForm')),
                'kode_instansi' => $this->db->escapeString($this->request->getVar('instansiAddEditForm')),
                'alamat_instansi' => $this->db->escapeString($this->request->getVar('alamatAddEditForm')),
                'awal' => date("Y-m-d", strtotime(str_replace('/', '-', $this->request->getVar('startAddEditForm')))),
                'akhir' => date("Y-m-d", strtotime(str_replace('/', '-', $this->request->getVar('endAddEditForm')))),
                'lama' => $this->db->escapeString($this->request->getVar('lamaAddEditForm')),
                'pejabat' => $this->db->escapeString($this->request->getVar('diperintahAddEditForm')),
                'status' => 'Pending',

            ];
            $id = $this->request->getVar('hiddenID');
            if ($this->spt->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/spt'));
            } else {
                $data = array('success' => false, 'msg' => $this->spt->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
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
            exit('No direct script is allowed');
        }

        if ($this->request->getVar('id')) {
            $id = $this->request->getVar('id');

            if ($this->spt->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
}
