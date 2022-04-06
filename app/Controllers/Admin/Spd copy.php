<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\WilayahModel;
use App\Models\Admin\RekeningModel;
use App\Models\Admin\SpdModel;
use \Hermawan\DataTables\DataTable;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
*/

class Spd extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
    public function __construct()
    {
        if (session()->get('level') != "Admin") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $this->pegawai = new PegawaiModel();
        $this->instansi = new instansiModel();
        $this->wilayah = new WilayahModel();
        $this->rekening = new RekeningModel();
        $this->spd = new SpdModel();
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
            'title' => 'SURAT PERJALAN DINAS',
            'parent' => 3,
            'pmenu' => 3.2
        );
        return view('admin/spd/v-spd', $data);
    }

    public function load_data() {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $builder = $this->db->table('spd')
                  ->select('spd.id, spd.kode, pegawai_diperintah, pegawai_all, instansi.nama_instansi, awal, akhir, pegawai.nama, status')
                  ->join('pegawai', 'pegawai.nip = spd.pejabat')
                  ->join('instansi', 'instansi.kode = spd.kode_instansi');

        return DataTable::of($builder)
            ->postQuery(function($builder){$builder->orderBy('kode', 'desc');})
            ->format('pegawai_diperintah', function($value){
                if($value == null){
                    return $value;
                }else{
                    $pegawai = $this->pegawai->select('nama')->where('nip', $value)->first();return $pegawai['nama'];
                }
            })
            ->format('pegawai_all', function($value){                
                $query = $this->pegawai->whereIn('nip', json_decode($value))->get();
                foreach($query->getResult() as $row){$pegawai[] = $row->nama;}return $pegawai;
            })
            ->format('awal', function($value){return date_indo(date('Y-m-d', strtotime($value)));})
            ->format('akhir', function($value){return date_indo(date('Y-m-d', strtotime($value)));})
            ->format('status', function($value){if($value == 'false'){$status = 'SPD Belum Dibuat';}else{$status = 'SPD Sudah Dibuat';}return $status;})
            ->filter(function ($builder, $request) {
                if ($request->noSpd)
                    $builder->where('spd.kode', $request->noSpd);
                if ($request->pejabat)
                    $builder->where('pejabat', $request->pejabat);
                if ($request->pegawai)
                    $builder->where('pegawai_diperintah', $request->pegawai);
                if ($request->pengikut)
                    $builder->like('pegawai_all', $request->pengikut);
                if($request->awal)
                    $builder->where('awal', date("Y-m-d", strtotime(str_replace('/', '-',$request->awal))));
                if($request->akhir)
                    $builder->where('akhir', date("Y-m-d", strtotime(str_replace('/', '-',$request->akhir))));
                if ($request->instansi)
                    $builder->where('instansi.nama_instansi', $request->instansi);
            })
            ->add(null, function($row){
                if($row->status == 'false'){
                    $button = '<a class="btn btn-xs btn-primary mr-1 mb-1 print" href="/Admin/Spd/new/' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Create Data ]"><i class="fas fa-plus text-white"></i></a>';
                    $button .= '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>';
                }else{
                    $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Page One ]"><i class="fas fa-eye text-white"></i></a>';
                    $button .='<a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="/Admin/Spd/edit/' . $row->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Halaman Depan ]"><i class="fas fa-edit text-white"></i></a>';
                    $button .='<a type="button" class="btn btn-xs btn-secondary mr-1 mb-1" href="/Admin/Spd/edit/' . $row->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Halaman Belakang ]"><i class="fas fa-edit text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a><br>';
                    $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="/Admin/Spd/print_one/'.$row->id.'" target="_blank" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Halaman Depan ]"><i class="fas fa-print  text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-secondary mr-1 mb-1 print" href="/Admin/Spd/print_two/'.$row->id.'" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Halaman Belakang ]"><i class="fas fa-print text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-info mr-1 mb-1 print" href="/Admin/Spd/print_two/'.$row->id.'" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Template Detail ]"><i class="fas fa-print text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-primary mr-1 mb-1 print" href="/Admin/Spd/print/'.$row->id.'" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
                }
                return $button;
            }, 'last')
            ->hide('id')
            ->addNumbering()
            ->toJson();
    }
    public function getNoSpdTable() {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->orderBy('kode')
                ->findAll(10);

        } else {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->like('kode', $this->request->getPost('searchTerm'))
                ->orderBy('kode')
                ->findAll(10);
        }

        $data = array();
        foreach ($spdlist as $pegawai) {
            $data[] = array(
                "id" => $pegawai['kode'],
                "text" => $pegawai['kode'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getPegawaiTable() {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->orderBy('nama')
                ->findAll(10);
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

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getInstansiTable() {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $instansilist = $this->instansi->select('kode,nama_instansi') // Fetch record
                ->orderBy('nama_instansi')
                ->findAll(10);;
        } else {
            $instansilist = $this->instansi->select('kode,nama_instansi') // Fetch record
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

    public function getPegawai()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        $pegawailist = $this->spd->select('pegawai_all')->where('id', $this->request->getVar('id'))->first();

        $data = array();
        $nama = $this->pegawai->whereIn('nip', json_decode($pegawailist['pegawai_all']))->get();
        foreach (array_combine(json_decode($pegawailist['pegawai_all']), $nama->getResultArray())  as $pegawai => $nama) {
            $data[] = array(
                "id" => $pegawai,
                "text" => $nama['nama'],
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
    public function new($id = null)
    {
        if (!$id) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $data = array(
            'title' => 'Tambah Data Surat Perjalanan Dinas',
            'parent' => 3,
            'pmenu' => 3.2,
            'method' => 'New',
            'hiddenID' => $id,
        );
        return view('admin/spd/v-spdAddEdit', $data);
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

        // d($this->request->getVar('pegawaiAddEditForm'));print_r($this->request->getVar('pegawaiAddEditForm'));die();

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
            'diperintahAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'pegawaiAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'tingkatBiayaAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[10]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 10 Karakter'
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
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 20 Karakter'
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
            'rekeningAddEditForm'  => [
                'label'     => 'Lama Perjalanan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'keteranganAddEditForm'  => [
                'label'     => 'keterangan',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'kendaraanAddEditForm'  => [
                'label'     => 'Jenis Kendaraan',
                'rules'     => 'required',
            ],
            'berangkatAddEditForm[]' => [
                'label'     => 'Berangkat Dari',
                'rules'     => 'permit_empty',
            ],
            'tujuanAddEditForm[]' => [
                'label'     => 'Tujuan',
                'rules'     => 'permit_empty'
            ],
            'tanggalBerangkatAddEditForm[]' => [
                'label'     => 'Tanggal Berangkat',
                'rules'     => 'permit_empty|valid_date[d/m/Y]'
            ],
            'kepalaBerangkatAddEditForm[]' => [
                'label'     => 'Kepala Berangkat',
                'rules'     => 'permit_empty'
            ],
            'tibadiAddEditForm[]' => [
                'label'     => 'Tiba di',
                'rules'     => 'permit_empty'
            ],
            'tanggalTibaAddEditForm[]' => [
                'label'     => 'Tanggal Tiba',
                'rules'     => 'permit_empty|valid_date[d/m/Y]'
            ],
            'kepalaTibaAddEditForm[]' => [
                'label'     => 'Kepala Tiba',
                'rules'     => 'permit_empty'
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
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'diperintah' => $validation->getError('diperintahAddEditForm[]'),
                    'pegawai' => $validation->getError('pegawaiAddEditForm'),
                    'tingkatBiaya' => $validation->getError('tingkatBiayaAddEditForm'),
                    'untuk' => $validation->getError('untukAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                    'start' => $validation->getError('startAddEditForm'),
                    'end' => $validation->getError('endAddEditForm'),
                    'lama' => $validation->getError('lamaAddEditForm'),
                    'rekening' => $validation->getError('rekeningAddEditForm'),
                    'keterangan' => $validation->getError('keteranganAddEditForm'),
                    'kendaraan' => $validation->getError('kendaraanAddEditForm'),
                    'berangkatdariFormfirst' => $validation->getError('berangkatAddEditForm[]'),
                    'tujuanFormfirst' => $validation->getError('tujuanAddEditForm[]'),
                    'tanggalberangkatFormfirst' => $validation->getError('tanggalBerangkatAddEditForm[]'),
                    'kepalaberangkatFormfirst' => $validation->getError('kepalaBerangkatAddEditForm[]'),
                    'tibadiFormfirst' => $validation->getError('tibadiAddEditForm[]'),
                    'tanggaltibaFormfirst' => $validation->getError('tanggalTibaAddEditForm[]'),
                    'kepalatibaFormfirst' => $validation->getError('kepalaTibaAddEditForm[]'),
                ],
                'msg' => '',
            ];
        }else{


            $a = $this->request->getVar('tibadiAddEditForm[]');
            $b = $this->request->getVar('tanggalTibaAddEditForm[]');
            $c = $this->request->getVar('kepalaTibaAddEditForm[]');
            $d = $this->request->getVar('berangkatAddEditForm[]');
            $e = $this->request->getVar('tujuanAddEditForm[]');
            $f = $this->request->getVar('tanggalBerangkatAddEditForm[]');
            $g = $this->request->getVar('kepalaBerangkatAddEditForm[]');

            for($i=0;$i<count($a);$i++){
                $detail_array[$i]["tibadi"]=$a[$i];
                $detail_array[$i]["tanggaltiba"]=$b[$i];
                $detail_array[$i]["kepalatiba"]=$c[$i];
                $detail_array[$i]["berangkatdari"]=$d[$i];
                $detail_array[$i]["tujuan"]=$e[$i];
                $detail_array[$i]["tanggalberangkat"]=$f[$i];
                $detail_array[$i]["kepalaberangkat"]=$g[$i];
            }

            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'pejabat' => $this->pegawai->select('nip')->where('nama', $this->request->getVar('diperintahAddEditForm'))->first(),
                'pegawai_diperintah' => $this->db->escapeString($this->request->getVar('pegawaiAddEditForm')),
                'untuk' => $this->db->escapeString($this->request->getVar('untukAddEditForm')),
                'kode_instansi' => $this->instansi->select('kode')->where('nama_instansi', $this->request->getVar('instansiAddEditForm'))->first(),
                'awal' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('startAddEditForm')))),
                'akhir' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('endAddEditForm')))),
                'kode_rekening' => $this->rekening->select('kode')->where('nomer_rekening', $this->request->getVar('rekeningAddEditForm'))->first(),
                'lama' => $this->db->escapeString($this->request->getVar('lamaAddEditForm')),
                'keterangan' => $this->db->escapeString($this->request->getVar('keteranganAddEditForm')),
                'jenis_kendaraan' => $this->db->escapeString($this->request->getVar('kendaraanAddEditForm')),
                'detail' => json_encode($detail_array, JSON_UNESCAPED_SLASHES),
                'status' => 'true',

            ];
            $id = $this->request->getVar('hiddenID');
            if ($this->spd->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/spd'));
            } else {
                $data = array('success' => false, 'msg' => $this->spt->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }

        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($data);

    }

    function view_data() {

        if ($this->request->getVar('id')) {
            $data = $this->spd->where('id', $this->request->getVar('id'))->first();

            $builder = $this->db->table('pegawai');
            $query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->where('pegawai.nip', $data['pegawai_diperintah'])->get();

            $data['pegawai'] = $query->getResult();

            $query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->whereIn('pegawai.nip', json_decode($data['pegawai_all']))->get();

            $data['looping'] = $query->getResult();
            $data['json'] = json_decode($data['detail'], true);
            $data['diperintah'] = $this->pegawai->where('nip', $data['pejabat'])->first();
            $data['instansi'] = $this->instansi->select('nama_instansi')->where('kode', $data['kode_instansi'])->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function new_update() {
        if ($this->request->getVar('id')) {
            $data = $this->spd->where('id', $this->request->getVar('id'))->first();

            $data['pegawai'] = $this->pegawai->where('nip', $data['pejabat'])->first();
            $instansi = $this->instansi->where('kode', $data['kode_instansi'])->first();

            $wilayah = $this->wilayah->select('kode_jenis_wilayah')->where(['kode_provinsi' => $instansi['kode_provinsi'], 'kode_kabupaten' => $instansi['kode_kabupaten']])->first();

            $data['rekening'] = $this->rekening->select('nomer_rekening')->where('kode_jenis_wilayah', $wilayah)->first();

            $data['instansi'] = $instansi;
            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function real_update() {
        if ($this->request->getVar('id')) {
            $data = $this->spd->where('id', $this->request->getVar('id'))->first();

            $data['diperintah'] = $this->pegawai->where('nip', $data['pejabat'])->first();
            $data['pegawai'] = $this->pegawai->where('nip', $data['pegawai_diperintah'])->first();
            $data['instansi'] = $this->instansi->select('nama_instansi')->where('kode', $data['kode_instansi'])->first();
            $data['rekening'] = $this->rekening->select('nomer_rekening')->where('kode', $data['kode_rekening'])->first();
            $data['json'] = json_decode($data['detail']);

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    public function edit_depan($id = null){
        if (!$id) {
            return redirect()->to(site_url('admin/spd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = array(
            'title' => 'Edit Data Surat Perjalanan Dinas',
            'parent' => 3,
            'pmenu' => 3.2,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('admin/spd/v-spdUpdateDepan', $data);
    }

    public function update_depan($id = null){
        if (!$id) {
            return redirect()->to(site_url('admin/spd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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
            'diperintahAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'pegawaiAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'tingkatBiayaAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[10]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 10 Karakter'
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
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 20 Karakter'
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
            'rekeningAddEditForm'  => [
                'label'     => 'Lama Perjalanan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'keteranganAddEditForm'  => [
                'label'     => 'keterangan',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'kendaraanAddEditForm'  => [
                'label'     => 'Jenis Kendaraan',
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
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'diperintah' => $validation->getError('diperintahAddEditForm[]'),
                    'pegawai' => $validation->getError('pegawaiAddEditForm'),
                    'tingkatBiaya' => $validation->getError('tingkatBiayaAddEditForm'),
                    'untuk' => $validation->getError('untukAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                    'start' => $validation->getError('startAddEditForm'),
                    'end' => $validation->getError('endAddEditForm'),
                    'lama' => $validation->getError('lamaAddEditForm'),
                    'rekening' => $validation->getError('rekeningAddEditForm'),
                    'keterangan' => $validation->getError('keteranganAddEditForm'),
                    'kendaraan' => $validation->getError('kendaraanAddEditForm'),
                ],
                'msg' => '',
            ];
        }else{

            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'pejabat' => $this->pegawai->select('nip')->where('nama', $this->request->getVar('diperintahAddEditForm'))->first(),
                'pegawai_diperintah' => $this->db->escapeString($this->request->getVar('pegawaiAddEditForm')),
                'untuk' => $this->db->escapeString($this->request->getVar('untukAddEditForm')),
                'kode_instansi' => $this->instansi->select('kode')->where('nama_instansi', $this->request->getVar('instansiAddEditForm'))->first(),
                'awal' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('startAddEditForm')))),
                'akhir' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('endAddEditForm')))),
                'kode_rekening' => $this->rekening->select('kode')->where('nomer_rekening', $this->request->getVar('rekeningAddEditForm'))->first(),
                'lama' => $this->db->escapeString($this->request->getVar('lamaAddEditForm')),
                'keterangan' => $this->db->escapeString($this->request->getVar('keteranganAddEditForm')),
                'jenis_kendaraan' => $this->db->escapeString($this->request->getVar('kendaraanAddEditForm')),
                'status' => 'true',

            ];
            $id = $this->request->getVar('hiddenID');
            if ($this->spd->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/spd'));
            } else {
                $data = array('success' => false, 'msg' => $this->spt->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }

        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($data);
    }

    public function edit_belakang($id = null){
        if (!$id) {
            return redirect()->to(site_url('admin/spd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = array(
            'title' => 'Edit Data Surat Perjalanan Dinas',
            'parent' => 3,
            'pmenu' => 3.2,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('admin/spd/v-spdUpdateBelakang', $data);
    }

    public function update_belakang($id = null){
        if (!$id) {
            return redirect()->to(site_url('admin/spd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'berangkatAddEditForm[]' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty',
            ],
            'tujuanAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty'
            ],
            'tanggalBerangkatAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|valid_date[d/m/Y]'
            ],
            'kepalaBerangkatAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty'
            ],
            'tibadiAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty'
            ],
            'tanggalTibaAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|valid_date[d/m/Y]'
            ],
            'kepalaTibaAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty'
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
                    'berangkatdariFormfirst' => $this->validation->getError('berangkatAddEditForm[]'),
                    'tujuanFormfirst' => $this->validation->getError('tujuanAddEditForm[]'),
                    'tanggalberangkatFormfirst' => $this->validation->getError('tanggalBerangkatAddEditForm[]'),
                    'kepalaberangkatFormfirst' => $this->validation->getError('kepalaBerangkatAddEditForm[]'),
                    'tibadiFormfirst' => $this->validation->getError('tibadiAddEditForm[]'),
                    'tanggaltibaFormfirst' => $this->validation->getError('tanggalTibaAddEditForm[]'),
                    'kepalatibaFormfirst' => $this->validation->getError('kepalaTibaAddEditForm[]'),
                ],
                'msg' => '',
            ];
        }else{

            $a = $this->request->getVar('tibadiAddEditForm[]');
            $b = $this->request->getVar('tanggalTibaAddEditForm[]');
            $c = $this->request->getVar('kepalaTibaAddEditForm[]');
            $d = $this->request->getVar('berangkatAddEditForm[]');
            $e = $this->request->getVar('tujuanAddEditForm[]');
            $f = $this->request->getVar('tanggalBerangkatAddEditForm[]');
            $g = $this->request->getVar('kepalaBerangkatAddEditForm[]');

            for($i=0;$i<count($a);$i++){
                $detail_array[$i]["tibadi"]=$a[$i];
                $detail_array[$i]["tanggaltiba"]=$b[$i];
                $detail_array[$i]["kepalatiba"]=$c[$i];
                $detail_array[$i]["berangkatdari"]=$d[$i];
                $detail_array[$i]["tujuan"]=$e[$i];
                $detail_array[$i]["tanggalberangkat"]=$f[$i];
                $detail_array[$i]["kepalaberangkat"]=$g[$i];
            }

            $data = [
                'detail' => json_encode($detail_array, JSON_UNESCAPED_SLASHES),

            ];
            $id = $this->request->getVar('hiddenID');
            if ($this->spd->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/spd'));
            } else {
                $data = array('success' => false, 'msg' => $this->spt->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }

        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($data);
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
            return redirect()->to(site_url('admin/spd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = array(
            'title' => 'Edit Data Surat Perjalanan Dinas',
            'parent' => 3,
            'pmenu' => 3.2,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('admin/spd/v-spdAddEdit', $data);
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

        $valid = $this->validate([
            'kodeAddEditForm' => [
                'label'     => 'No SPT',
                'rules'     => 'required|numeric|max_length[3]',
                'errors' => [
                    'numeric'       => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length'    => '{field} Maksimal 3 Karakter',
                ],
            ],
            'diperintahAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'pegawaiAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'tingkatBiayaAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[10]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 10 Karakter'
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
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 20 Karakter'
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
            'rekeningAddEditForm'  => [
                'label'     => 'Lama Perjalanan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'keteranganAddEditForm'  => [
                'label'     => 'keterangan',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'kendaraanAddEditForm'  => [
                'label'     => 'Jenis Kendaraan',
                'rules'     => 'required',
            ],
            'berangkatAddEditForm[]' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty',
            ],
            'tujuanAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty'
            ],
            'tanggalBerangkatAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|valid_date[d/m/Y]'
            ],
            'kepalaBerangkatAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty'
            ],
            'tibadiAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty'
            ],
            'tanggalTibaAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|valid_date[d/m/Y]'
            ],
            'kepalaTibaAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty'
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
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'diperintah' => $validation->getError('diperintahAddEditForm[]'),
                    'pegawai' => $validation->getError('pegawaiAddEditForm'),
                    'tingkatBiaya' => $validation->getError('tingkatBiayaAddEditForm'),
                    'untuk' => $validation->getError('untukAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                    'start' => $validation->getError('startAddEditForm'),
                    'end' => $validation->getError('endAddEditForm'),
                    'lama' => $validation->getError('lamaAddEditForm'),
                    'rekening' => $validation->getError('rekeningAddEditForm'),
                    'keterangan' => $validation->getError('keteranganAddEditForm'),
                    'kendaraan' => $validation->getError('kendaraanAddEditForm'),
                    'berangkatdariFormfirst' => $this->validation->getError('berangkatAddEditForm[]'),
                    'tujuanFormfirst' => $this->validation->getError('tujuanAddEditForm[]'),
                    'tanggalberangkatFormfirst' => $this->validation->getError('tanggalBerangkatAddEditForm[]'),
                    'kepalaberangkatFormfirst' => $this->validation->getError('kepalaBerangkatAddEditForm[]'),
                    'tibadiFormfirst' => $this->validation->getError('tibadiAddEditForm[]'),
                    'tanggaltibaFormfirst' => $this->validation->getError('tanggalTibaAddEditForm[]'),
                    'kepalatibaFormfirst' => $this->validation->getError('kepalaTibaAddEditForm[]'),
                ],
                'msg' => '',
            ];
        }else{

            $a = $this->request->getVar('tibadiAddEditForm[]');
            $b = $this->request->getVar('tanggalTibaAddEditForm[]');
            $c = $this->request->getVar('kepalaTibaAddEditForm[]');
            $d = $this->request->getVar('berangkatAddEditForm[]');
            $e = $this->request->getVar('tujuanAddEditForm[]');
            $f = $this->request->getVar('tanggalBerangkatAddEditForm[]');
            $g = $this->request->getVar('kepalaBerangkatAddEditForm[]');

            for($i=0;$i<count($a);$i++){
                $detail_array[$i]["tibadi"]=$a[$i];
                $detail_array[$i]["tanggaltiba"]=$b[$i];
                $detail_array[$i]["kepalatiba"]=$c[$i];
                $detail_array[$i]["berangkatdari"]=$d[$i];
                $detail_array[$i]["tujuan"]=$e[$i];
                $detail_array[$i]["tanggalberangkat"]=$f[$i];
                $detail_array[$i]["kepalaberangkat"]=$g[$i];
            }

            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'pejabat' => $this->pegawai->select('nip')->where('nama', $this->request->getVar('diperintahAddEditForm'))->first(),
                'pegawai_diperintah' => $this->db->escapeString($this->request->getVar('pegawaiAddEditForm')),
                'untuk' => $this->db->escapeString($this->request->getVar('untukAddEditForm')),
                'kode_instansi' => $this->instansi->select('kode')->where('nama_instansi', $this->request->getVar('instansiAddEditForm'))->first(),
                'awal' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('startAddEditForm')))),
                'akhir' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('endAddEditForm')))),
                'kode_rekening' => $this->rekening->select('kode')->where('nomer_rekening', $this->request->getVar('rekeningAddEditForm'))->first(),
                'lama' => $this->db->escapeString($this->request->getVar('lamaAddEditForm')),
                'keterangan' => $this->db->escapeString($this->request->getVar('keteranganAddEditForm')),
                'jenis_kendaraan' => $this->db->escapeString($this->request->getVar('kendaraanAddEditForm')),
                'detail' => json_encode($detail_array, JSON_UNESCAPED_SLASHES),
                'status' => 'true',

            ];
            $id = $this->request->getVar('hiddenID');
            if ($this->spd->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/spd'));
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

        if ($this->request->getVar('id')) {
            $id = $this->request->getVar('id');

            if ($this->spd->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }


    public function print_one($id = null){

        if (!$id) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $data = $this->spd->where('id', $id)->first();

        $builder = $this->db->table('pegawai');
        $query = $builder->select('pegawai.*')
        ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
        ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
        ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
        ->where('pegawai.nip', $data['pegawai_diperintah'])->get();

        $data['pegawai'] = $query->getResult();

        $query = $builder->select('pegawai.*')
        ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
        ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
        ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
        ->whereIn('pegawai.nip', json_decode($data['pegawai_all']))->get();

        $data['looping'] = $query->getResult();
        $data['json'] = json_decode($data['detail'], true);
        $data['diperintah'] = $this->pegawai->where('nip', $data['pejabat'])->first();
        $data['instansi'] = $this->instansi->select('nama_instansi')->where('kode', $data['kode_instansi'])->first();

        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();

        $filename = 'Spd_No_'.$data['kode'] ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot("C:\\www\\surat\\public");
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/spd/p-spdone', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }

    public function print_two($id = null){

        if (!$id) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $data = $this->spd->where('id', $id)->first();

        $builder = $this->db->table('pegawai');
        $query = $builder->select('pegawai.*')
        ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
        ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
        ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
        ->where('pegawai.nip', $data['pegawai_diperintah'])->get();

        $data['pegawai'] = $query->getResult();

        $query = $builder->select('pegawai.*')
        ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
        ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
        ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
        ->whereIn('pegawai.nip', json_decode($data['pegawai_all']))->get();

        $data['looping'] = $query->getResult();
        $data['json'] = json_decode($data['detail'], true);
        $data['diperintah'] = $this->pegawai->where('nip', $data['pejabat'])->first();
        $data['instansi'] = $this->instansi->select('nama_instansi')->where('kode', $data['kode_instansi'])->first();

        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();

        $filename = 'Spd_No_'.$data['kode'] ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot("C:\\www\\surat\\public");
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/spd/p-spdtwo', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }

    public function print($id = null){

        if (!$id) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $data = $this->spd->where('id', $id)->first();

        $builder = $this->db->table('pegawai');
        $query = $builder->select('pegawai.*')
        ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
        ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
        ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
        ->where('pegawai.nip', $data['pegawai_diperintah'])->get();

        $data['pegawai'] = $query->getResult();

        $query = $builder->select('pegawai.*')
        ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
        ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
        ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
        ->whereIn('pegawai.nip', json_decode($data['pegawai_all']))->get();

        $data['looping'] = $query->getResult();
        $data['json'] = json_decode($data['detail'], true);
        $data['diperintah'] = $this->pegawai->where('nip', $data['pejabat'])->first();
        $data['instansi'] = $this->instansi->select('nama_instansi')->where('kode', $data['kode_instansi'])->first();

        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();

        $filename = 'Spd_No_'.$data['kode'] ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot("C:\\www\\surat\\public");
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/spd/p-spd', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }
}