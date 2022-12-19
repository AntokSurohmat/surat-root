<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Admin\SptModel;
use App\Models\Admin\TujuanModel;
use \Hermawan\DataTables\DataTable;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\HTTP\IncomingRequest;
/**
 * @property IncomingRequest $request
*/

class Spt extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text', 'my_helper']; // Helper
    public function __construct() { // function _construct is to call the model class or library that we will use in each function.
        if (session()->get('level') != "Admin") { // checking if session level == admin, if not throw forbidden
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        // shorthand
        $this->pegawai = new PegawaiModel();  // get data from Model Pegawai
        $this->instansi = new instansiModel(); // get data from Model Instansi
        $this->provinsi = new ProvinsiModel(); // get data from Model Provinsi
        $this->kabupaten = new KabupatenModel(); // get data from Model Kabupaten
        $this->kecamatan = new KecamatanModel(); // get data from Model Kecamatan
        $this->tujuan = new TujuanModel(); // get data from Model Tujuan
        $this->spt = new SptModel(); // get data from Model SPT
        $this->csrfToken = csrf_token(); // generate csrf token
        $this->csrfHash = csrf_hash(); // generate csrf Hash
        $this->session = \Config\Services::session();  // use library session
        $this->session->start(); // starting session
        $this->db = \Config\Database::connect(); // use library database
    }
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index() // function index
    {
        $data = array(
            'title' => 'Surat Perintah Tugas', // title
            'parent' => 3, // parent for menu
            'pmenu' => 3.1 // parent menu
        );
        return view('admin/spt/v-spt', $data); // display page
    }

    public function load_data() { // function load data from database
        if (!$this->request->isAJAX()) { // must be ajax
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $builder = $this->db->table('spt') // Use Library Datatables Hermawan // get data from table SPT
                  ->select('spt.id, spt.kode, spt.pegawai_all, instansi.nama_instansi, awal, akhir, pegawai.nama, status, keterangan') // data will display in page
                  ->join('pegawai', 'pegawai.nip = spt.pejabat')
                  ->join('instansi', 'instansi.kode = spt.kode_instansi')
                  ->where('spt.deleted_at', null);

        return DataTable::of($builder) // return data to the page
            ->postQuery(function($builder){ // fucntion will run before data display
                $builder->orderBy('id', 'desc');
                $builder->where('spt.deleted_at', null);
            })
            ->format('awal', function($value){return date_indo(date('Y-m-d', strtotime($value)));}) // change the format field awal
            ->format('akhir', function($value){return date_indo(date('Y-m-d', strtotime($value)));}) // change the format field akhir
            ->format('pegawai_all', function($value){ //change the format data field all pegawai
                $namas = array(); // data will display in array format
                foreach(json_decode($value) as $valu ) { // decode data
                    $okay = $this->pegawai->where('nip', $valu)->get();
                    $result = $okay->getResult();
                    $namas[] = $result[0]->nama;
                }
                return $namas;
            })
            ->filter(function ($builder, $request) { // for the filter data(select2) 
                if ($request->noSpt)
                    $builder->where('spt.kode', $request->noSpt);
                if ($request->pegawai)
                    $builder->like('pegawai_all', $request->pegawai);
                if($request->awal)
                    $builder->where('awal', date("Y-m-d", strtotime(str_replace('/', '-',$request->awal))));
                if($request->akhir)
                    $builder->where('akhir', date("Y-m-d", strtotime(str_replace('/', '-',$request->akhir))));
                if ($request->instansi)
                    $builder->where('instansi.nama_instansi', $request->instansi);
            })
            ->add(null, function($row){ // one of fitur DataTables Hermwan to add another field
                if($row->status == 'Disetujui'){
                    $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="'. base_url('admin/Spt/print/'.$row->id).'" target="_blank" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>';
                }else{
                    $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                    $button .='<a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="'. base_url('admin/Spt/edit/'.$row->id).'"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>';
                }
                return $button;
            }, 'last')
            ->hide('id') // hide id because we replace with "addNumbering"
            ->addNumbering()
            ->toJson(); // return it with format JSON
    }
    public function getNoSptTable() { // get data NO SPT from Model SPT for select2
        if (!$this->request->isAjax()) { // must ajax
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) { // if null 
            $spdlist = $this->spt->select('id,kode') // Fetch record from Model SPT
                ->where('deleted_at', null)
                ->orderBy('kode')
                ->findAll(10);  // max result 10

        } else { // if we search specifix data using query like
            $spdlist = $this->spd->select('id,kode') // Fetch record from Model SPT
                ->where('deleted_at', null)
                ->like('kode', $this->request->getPost('searchTerm')) // query like
                ->orderBy('kode')
                ->findAll(10); // max result 10
        }
        $data = array();
        foreach ($spdlist as $pegawai) {
            $data[] = array( // inside select have multiple option, every option have id or you can call value and text == text will display it, etc id = 1 text = kode pegawai
                "id" => $pegawai['kode'], // option have id == kode pegawai
                "text" => $pegawai['kode'], // option have text == kode pegawai 
            );
        }

        $response['data'] = $data; // return it to $data
        $response[$this->csrfToken] = $this->csrfHash; // send new Csrf Token to the page 
        return $this->response->setJSON($response); // return it to JSON
    }
    public function getPegawaiTable() { // get data NO SPT from Model SPT for select2
        if (!$this->request->isAjax()) { // must ajax
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) { // if null 
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record from Model Pegawai
                ->orderBy('nama')
                ->findAll(10);  // max result 10
        } else { // if we search specifix data using query like
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record from Model Pegawai
                ->like('nama', $this->request->getPost('searchTerm'))
                ->orderBy('nama')
                ->findAll(10);  // max result 10
        }

        $data = array();
        foreach ($pegawailist as $pegawai) {
            $data[] = array( // inside select have multiple option, every option have id or you can call value and text == text will display it, etc id = 1 text = nama pegawai
                "id" => $pegawai['nip'], // option have id == nip pegawai
                "text" => $pegawai['nama'], // option have text == nama_provinsi 
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash; // generate new crsftoken
        return $this->response->setJSON($response); // return it to instansi index page 
    }
    public function getInstansiTable() {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $instansilist = $this->instansi->select('kode,nama_instansi') // Fetch record
                ->where('deleted_at', null)
                ->orderBy('nama_instansi')
                ->findAll(10);;
        } else {
            $instansilist = $this->instansi->select('kode,nama_instansi') // Fetch record
                ->where('deleted_at', null)
                ->like('nama_instansi', $this->request->getPost('searchTerm'))
                ->orderBy('nama_instansi')
                ->findAll(10);
        }

        $data = array();
        foreach ($instansilist as $instansi) {
            $data[] = array(
                "id" => $instansi['nama_instansi'],
                "text" => $instansi['nama_instansi'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    public function nomer(){
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $nomer = $this->db->table('spt')->countAllResults();

        // Add Number if 0
        if($nomer == 0){$nomer = 1; }else{$nomer = $nomer+1;}
        switch (strlen($nomer)) {
            case '1':
                $kode = '00'.$nomer;
                break;
            case '2':
                $kode = '0'.$nomer;
                break;
            default:
            $kode = $nomer;
                break;
        }
        $data['kode'] =  $kode;
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    public function getPegawai()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('level', 'Pegawai')
                ->where('deleted_at', null)
                ->orderBy('nama')
                ->findAll(10);
        } else {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('level', 'Pegawai')
                ->where('deleted_at', null)
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

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getInstansi()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $instansilist = $this->instansi->select('kode,nama_instansi') // Fetch record
                ->where('deleted_at', null)
                ->orderBy('nama_instansi')
                ->findAll(10);
        } else {
            $instansilist = $this->instansi->select('kode,nama_instansi') // Fetch 
                ->where('deleted_at', null)
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

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    function getAlamatInstansi()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
         }

        if ($this->request->getVar('instansi')) {
            $data = $this->instansi->where('kode', $this->request->getVar('instansi'))->where('deleted_at', null)->first();

            $provinsi = $this->provinsi->where('kode', $data['kode_provinsi'])->first();
            $kabupaten = $this->kabupaten->where('kode', $data['kode_kabupaten'])->first();
            $kecamatan = $this->kecamatan->where('kode', $data['kode_kecamatan'])->first();

            $data['alamat'] = 'pada kecamatan '. $kecamatan['nama_kecamatan'].' pada kabupaten '.$kabupaten['nama_kabupaten'].' pada kabupaten '.$provinsi['nama_provinsi'];
            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    public function getDiperintah()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('deleted_at', null)
                ->orderBy('nama')
                ->findAll(10);
        } else {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('deleted_at', null)
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

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    public function getTujuan()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $tujuanlist = $this->tujuan->select('id,tujuan') // Fetch record
                ->where('deleted_at', null)
                ->orderBy('id')
                ->findAll(10);
        } else {
            $tujuanlist = $this->tujuan->select('id,tujuan') // Fetch record
                ->where('deleted_at', null)
                ->like('nama', $this->request->getPost('searchTerm'))
                ->orderBy('id')
                ->findAll(10);
        }

        $data = array();
        foreach ($tujuanlist as $tujuan) {
            $data[] = array(
                "id" => $tujuan['id'],
                "text" => $tujuan['tujuan'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    function savemodal()
    {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'tujuanAddEditModalTujuan' => [
                'label'     => 'Tujuan Perjalanan Dinas',
                'rules'     => 'required|alpha_numeric_punct|min_length[3]',
                'errors' => [
                    'alpha_numeric_punct' => '{field} Hanya Berisi Huruf dan Tanda Baca',
                    'min_length' => '{field} Minimal 3 Karakter',
                ],
            ],
            'pelaksanaAddEditModalTujuan' => [
                'label' => 'Pelaksana',
                'rules' => 'required|in_list[Kasi Pelayan,Kasi Pengawasan]',
            ]
        ]);

        if (!$valid) {
            $data = [
                'error' => [
                    'tujuan' => $validation->getError('tujuanAddEditModalTujuan'),
                    'pelaksana' => $validation->getError('pelaksanaAddEditModalTujuan')
                ],
                'msg' => 'Data yang anda salah silahkan dicek terlebih dahulu',
            ];
        } else {
            $data = [
                'tujuan' => $this->db->escapeString($this->request->getVar('tujuanAddEditModalTujuan')),
                'pelaksana' => $this->db->escapeString($this->request->getVar('pelaksanaAddEditModalTujuan')),
            ];
            if ($this->tujuan->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data berhasil disimpan');
            } else {
                $data = array('success' => false, 'msg' => $this->wilayah->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
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
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
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
                'rules'     => 'required|numeric|max_length[3]|is_unique[spt.kode]',
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
                'rules'     => 'required',
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
                'rules'     => 'required',
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
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
         }
         $spt_id = $this->spt->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
         if($spt_id->getRow() == null){
             return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }
         if (!$this->request->getVar('id')) {
             return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }

        if ($this->request->getVar('id')) {
            $data = $this->spt->where('id', $this->request->getVar('id'))->first();
            $pegawai = array();
            foreach(json_decode($data['pegawai_all']) as $value) {
                $builder = $this->db->table('pegawai');
                $query = $builder->select('pegawai.*')
                ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
                ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
                ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
                ->where('pegawai.nip', $value)->where('pegawai.deleted_at', null)->get();
                $pegawai[] = $query->getResult();
            }

            $data['looping'] = $pegawai;
            $data['pegawai'] = $this->pegawai->where('nip', $data['pejabat'])->first();
            $data['instansi'] = $this->instansi->where('kode', $data['kode_instansi'])->first();
            $data['untuk'] = $this->tujuan->where('id', $data['untuk'])->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function single_data()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
         }
         $spt_id = $this->spt->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
         if($spt_id->getRow() == null){
             return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }
         if (!$this->request->getVar('id')) {
             return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }

        if ($this->request->getVar('id')) {
            $data = $this->spt->where('id', $this->request->getVar('id'))->first();
            $pegawai = array();
            foreach(json_decode($data['pegawai_all']) as $value) {
                
                $builder = $this->db->table('pegawai');
                $query = $builder->select('nip,nama')
                // ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
                // ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
                // ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
                ->where('nip', $value)->where('deleted_at', null)->get();
                $pegawai[] = $query->getResult();
            }


            $data['pegawai'] = $pegawai;
            $data['pejabat'] = $this->pegawai->where('nip', $data['pejabat'])->first();
            $data['instansi'] = $this->instansi->where('kode', $data['kode_instansi'])->first();
            $data['untuk'] = $this->tujuan->where('id', $data['untuk'])->first();

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

         $spt_id = $this->spt->where('id', $id)->where('deleted_at', null)->get();
         if($spt_id->getRow() == null){
             return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }
         if (!$id) {
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
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
         $spt_id = $this->spt->where('id', $this->request->getVar('hiddenID'))->where('deleted_at', null)->get();
         if($spt_id->getRow() == null){
             return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }
         if (!$this->request->getVar('hiddenID')) {
             return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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
                'rules'     => 'required',
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
                'rules'     => 'required',
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
        $spt_id = $this->spt->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
        if($spt_id->getRow() == null){
            return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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

    public function print($id = null){

        $spt_id = $this->spt->where('id', $id)->where('deleted_at', null)->get();
        if($spt_id->getRow() == null){
            return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
            return redirect()->to(site_url('admin/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = $this->spt->where('id',$id)->first();
        $pegawai = array();
        foreach(json_decode($data['pegawai_all']) as $value) {
            $builder = $this->db->table('pegawai');
            $query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->where('pegawai.nip', $value)->where('pegawai.deleted_at', null)->get();
            $pegawai[] = $query->getResult();
        }

        $data['looping'] = $pegawai;
        $data['pegawai'] = $this->pegawai->where('nip', $data['pejabat'])->first();
        $data['instansi'] = $this->instansi->where('kode', $data['kode_instansi'])->first();
        $data['untuk'] = $this->tujuan->where('id', $data['untuk'])->first();

        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();

        $filename = 'Spt_No_'.$data['kode'] ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/spt/p-spt', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }
}
