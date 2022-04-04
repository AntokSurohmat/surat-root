<?php

namespace App\Controllers\Bendahara;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\JabatanModel;
use App\Models\Admin\PangolModel;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\SpdModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\SbuhModel;
use App\Models\Admin\RekeningModel;
use App\Models\Admin\JenisWilayahModel;
use App\Models\Bendahara\KuitansiModel;
use \Hermawan\DataTables\DataTable;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
*/

class Kuitansi extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
    public function __construct()
    {
        if (session()->get('level') != "Bendahara") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $this->jabatan = new JabatanModel();
        $this->pangol = new PangolModel();
        $this->pegawai = new PegawaiModel();
        $this->spd = new SpdModel();
        $this->instansi = new InstansiModel();
        $this->sbuh = new SbuhModel();
        $this->rekening = new RekeningModel();
        $this->wilayah = new JenisWilayahModel();
        $this->kuitansi = new KuitansiModel();
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
            'title' => 'KUITANSI',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('bendahara/kuitansi/v-kuitansi', $data);
    }

    public function load_data() {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $builder = $this->db->table('kuitansi')
                  ->select('kuitansi.id,kode_spd, pegawai.nama, instansi.nama_instansi, awal, akhir, jumlah_uang')
                  ->join('pegawai', 'pegawai.nip = kuitansi.pegawai_diperintah')
                  ->join('instansi', 'instansi.kode = kuitansi.kode_instansi');

        return DataTable::of($builder)
            ->postQuery(function($builder){$builder->orderBy('kode_spd', 'desc');})
            ->format('awal', function($value){return date_indo(date('Y-m-d', strtotime($value)));})
            ->format('akhir', function($value){return date_indo(date('Y-m-d', strtotime($value)));})
            ->format('jumlah_uang', function($value){return 'Rp. '.number_format($value, 0,'','.');})
            ->setSearchableColumns(['kode_spd', 'nama', 'awal', 'akhir', 'nama_instansi'])
            ->filter(function ($builder, $request) {
                if ($request->noSpd)
                    $builder->where('kode_spd', $request->noSpd);
                if ($request->pegawai)
                    $builder->where('nama', $request->pegawai);
                if($request->awal)
                    $builder->where('awal', date("Y-m-d", strtotime(str_replace('/', '-',$request->awal))));
                if($request->akhir)
                    $builder->where('akhir', date("Y-m-d", strtotime(str_replace('/', '-',$request->akhir))));
                if ($request->instansi)
                    $builder->where('instansi.nama_instansi', $request->instansi);
            })
            ->add(null, function($row){
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                $button .= '<a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="/Bendahara/Kuitansi/edit/' . $row->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>' ;
                $button .='<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>';
                $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="/Bendahara/Kuitansi/Print/' . $row->id . '" name="print" target="_blank" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
                return $button;
            }, 'last')
            ->hide('id')->addNumbering()
            ->toJson();
    }

    public function getNoSpd() {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->orderBy('pegawai_diperintah')
                ->findAll(10);
        } else {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->like('kode', $this->request->getPost('searchTerm'))
                ->orderBy('pegawai_diperintah')
                ->findAll(10);
        }

        $data = array();
        foreach ($spdlist as $pegawai) {
            $data[] = array(
                "id" => $pegawai['id'],
                "text" => $pegawai['kode'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getPegawaiNoSpd(){
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        $pegawailist = $this->spd->select('pegawai_all')->where('id', $this->request->getPost('spd'))->first();

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
    function getDetailPegawaiNoSpd(){

        if ($this->request->getVar('kode') && $this->request->getVar('id')) {
            $data = $this->pegawai->where('nip', $this->request->getVar('kode'))->first();

            $data['pangol'] = $this->pangol->where('kode', $data['kode_pangol'])->first();
            $data['jabatan'] = $this->jabatan->where('kode', $data['kode_jabatan'])->first();

            $data['spd'] = $this->spd->where('id', $this->request->getVar('id'))->first();

            // d($spd['kode_instansi']);print_r( $spd['kode_instansi']);
            $data['instansi'] = $this->instansi->where('kode', $data['spd']['kode_instansi'])->first();
            $data['sbuh'] = $this->sbuh
                            ->where('kode_provinsi', $data['instansi']['kode_provinsi'])
                            ->where('kode_kabupaten', $data['instansi']['kode_kabupaten'])
                            ->where('kode_kecamatan', $data['instansi']['kode_kecamatan'])
                            ->first();
            //  d($data['instansi']);print_r($data['instansi']);die();
            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }
    public function getPelaksana() {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('nip !=', $this->request->getPost('bendahara'))
                ->orderBy('nama')
                ->findAll(10);
        } else {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('nip !=', $this->request->getPost('bendahara'))
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
    public function getNoSpdTable() {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->orderBy('pegawai_diperintah')
                ->findAll(10);
        } else {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->like('kode', $this->request->getPost('searchTerm'))
                ->orderBy('pegawai_diperintah')
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
                "id" => $pegawai['nama'],
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
                ->findAll(10);
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
            'title' => 'Input Kuitansi',
            'parent' => 2,
            'pmenu' => 2.1,
            'method' => 'New',
            'hiddenID' => '',
        );
        return view('bendahara/kuitansi/v-kuitansiAddEdit', $data);
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
            'noSpdAddEditForm' => [
                'label'     => 'No SPD',
                'rules'     => 'required|numeric|max_length[3]',
                'errors' => [
                    'numeric'       => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length'    => '{field} Maksimal 3 Karakter',
                ],
            ],
            'namaPegawaiAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'nipAddEditForm' => [
                'label'     => 'NIP Pegawai',
                'rules'     => 'required|numeric|max_length[25]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 25 Karakter',
                ]
            ],
            'namaAddEditForm' => [
                'label'     => 'Nama Pegawai',
                'rules'     => 'required|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'pangkatAddEditForm' => [
                'label'     => 'Pangkat & Golongan Pegawai',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'jabatanAddEditForm' => [
                'label'     => 'Jabatan Pegawai',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'tglBerangkatAddEditForm' => [
                'label'     => 'Tanggal Pergi',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'tglKembaliAddEditForm'   => [
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
                'label'     => 'Kode Rekening',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'instansiAddEditForm'  => [
                'label'     => 'Nama Instansi',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'untukAddEditForm'  => [
                'label'     => 'Nama Instansi',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'pejabatKuitansiAddEditForm' => [
                'label'     => 'Pejabat Pelaksanan Teknis',
                'rules'     => 'required|numeric|max_length[25]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahAddEditForm'  => [
                'label'     => 'Jumlah Uang',
                'rules'     => 'required|numeric|max_length[8]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 8 Karakter',
                ]
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
                    'noSpd' => $validation->getError('noSpdAddEditForm'),
                    'namaPegawai' => $validation->getError('namaPegawaiAddEditForm'),
                    'nip' => $validation->getError('nipAddEditForm'),
                    'nama' => $validation->getError('namaAddEditForm'),
                    'pangkat' => $validation->getError('pangkatAddEditForm'),
                    'jabatan' => $validation->getError('jabatanAddEditForm'),
                    'tglBerangkat' => $validation->getError('tglBerangkatAddEditForm'),
                    'tglKembali' => $validation->getError('tglKembaliAddEditForm'),
                    'lama' => $validation->getError('lamaAddEditForm'),
                    'rekening' => $validation->getError('rekeningAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                    'untuk' => $validation->getError('untukAddEditForm'),
                    'pejabat' => $validation->getError('pejabatKuitansiAddEditForm'),
                    'jumlah' => $validation->getError('jumlahAddEditForm'),
                ],
                'msg' => '',
            ];
        }else{
            $kode_spd = $this->spd->select(['kode', 'yang_menyetujui'])->where('id', $this->request->getVar('noSpdAddEditForm'))->first();
            $pegawai_all =  $this->spd->select('pegawai_all')->where('id', $this->request->getVar('noSpdAddEditForm'))->first();
            $pangol = $this->pegawai->select('kode_pangol')->where('nip', $this->request->getVar('namaPegawaiAddEditForm'))->first();
            $jabatan = $this->pegawai->select('kode_jabatan')->where('nip', $this->request->getVar('namaPegawaiAddEditForm'))->first();
            $instansi = $this->spd->select('kode_instansi')->where('id', $this->request->getVar('noSpdAddEditForm'))->first();

            $data = [
                'kode_spd' => $kode_spd['kode'],
                'pegawai_all' => $pegawai_all['pegawai_all'],
                'pegawai_diperintah' => $this->db->escapeString($this->request->getVar('namaPegawaiAddEditForm')),
                'nip_pegawai' => $this->db->escapeString($this->request->getVar('nipAddEditForm')),
                'kode_pangol' => $pangol['kode_pangol'],
                'kode_jabatan' => $jabatan['kode_jabatan'],
                'awal' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tglBerangkatAddEditForm')))),
                'akhir' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tglKembaliAddEditForm')))),
                'lama' => $this->db->escapeString($this->request->getVar('lamaAddEditForm')),
                'kode_rekening' => $this->db->escapeString($this->request->getVar('rekeningAddEditForm')),
                'kode_instansi' => $instansi['kode_instansi'],
                'untuk' => $this->db->escapeString($this->request->getVar('untukAddEditForm')),
                'pejabat' => $this->db->escapeString($this->request->getVar('pejabatKuitansiAddEditForm')),
                'jumlah_uang' => $this->db->escapeString($this->request->getVar('jumlahAddEditForm')),
                'yang_menyetujui' => $kode_spd['yang_menyetujui'],
                'bendahara' => $this->session->get('nip'),
            ];

            if ($this->kuitansi->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('bendahara/kuitansi'));
            } else {
                $data = array('success' => false, 'msg' => $this->kuitansi->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($data);
    }

    function single_data() {

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        if ($this->request->getVar('id')) {
            $data = $this->kuitansi->where('id', $this->request->getVar('id'))->first();

            $data['spd'] = $this->spd->where('kode', $data['kode_spd'])->first();
            $data['pegawai'] = $this->pegawai->where('nip', $data['pegawai_diperintah'])->first();
            $data['pejabat'] = $this->pegawai->select(['nip', 'nama'])->where('nip', $data['pejabat'])->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function view_data() {

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        if ($this->request->getVar('id')) {
            $data = $this->kuitansi->where('id', $this->request->getVar('id'))->first();

            $data['instansi'] = $this->instansi->select(['kode', 'nama_instansi'])->where('kode', $data['kode_instansi'])->first();
            $data['pegawai'] = $this->pegawai->where('nip', $data['pegawai_diperintah'])->first();

            $wilayah = $this->rekening->select('kode_jenis_wilayah')->where('kode', $data['kode_rekening'])->first();
            $data['wilayah'] = $this->wilayah->where('kode', $wilayah['kode_jenis_wilayah'])->first();

            $data['pejabat'] = $this->pegawai->select(['nip', 'nama'])->where('nip', $data['pejabat'])->first();
            $data['bendahara'] = $this->pegawai->select(['nip', 'nama'])->where('nip', $data['bendahara'])->first();
            $data['kepala'] = $this->pegawai->select(['nip', 'nama', 'kode_jabatan'])->where('nip', $data['yang_menyetujui'])->first();
            $data['jabatan'] = $this->jabatan->where('kode', $data['kepala']['kode_jabatan'])->first();

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
            return redirect()->to(site_url('bendahara/kuitansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = array(
            'title' => 'Edit Data Surat Perjalanan Dinas',
            'parent' => 3,
            'pmenu' => 3.2,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('bendahara/kuitansi/v-kuitansiAddEdit', $data);
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
            'noSpdAddEditForm' => [
                'label'     => 'No SPT',
                'rules'     => 'required|numeric|max_length[3]',
                'errors' => [
                    'numeric'       => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length'    => '{field} Maksimal 3 Karakter',
                ],
            ],
            'namaPegawaiAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'nipAddEditForm' => [
                'label'     => 'NIP Pegawai',
                'rules'     => 'required|numeric|max_length[25]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 25 Karakter',
                ]
            ],
            'namaAddEditForm' => [
                'label'     => 'Nama Pegawai',
                'rules'     => 'required|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'pangkatAddEditForm' => [
                'label'     => 'Pangkat & Golongan Pegawai',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'jabatanAddEditForm' => [
                'label'     => 'Jabatan Pegawai',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'tglBerangkatAddEditForm' => [
                'label'     => 'Tanggal Pergi',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'tglKembaliAddEditForm'   => [
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
                'label'     => 'Kode Rekening',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'instansiAddEditForm'  => [
                'label'     => 'Nama Instansi',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'untukAddEditForm'  => [
                'label'     => 'Nama Instansi',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'pejabatKuitansiAddEditForm' => [
                'label'     => 'Pejabat Pelaksanan Teknis',
                'rules'     => 'required|numeric|max_length[25]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahAddEditForm'  => [
                'label'     => 'Jumlah Uang',
                'rules'     => 'required|numeric|max_length[8]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 8 Karakter',
                ]
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
                    'noSpd' => $validation->getError('noSpdAddEditForm'),
                    'namaPegawai' => $validation->getError('namaPegawaiAddEditForm'),
                    'nip' => $validation->getError('nipAddEditForm'),
                    'nama' => $validation->getError('namaAddEditForm'),
                    'pangkat' => $validation->getError('pangkatAddEditForm'),
                    'jabatan' => $validation->getError('jabatanAddEditForm'),
                    'tglBerangkat' => $validation->getError('tglBerangkatAddEditForm'),
                    'tglKembali' => $validation->getError('tglKembaliAddEditForm'),
                    'lama' => $validation->getError('lamaAddEditForm'),
                    'rekening' => $validation->getError('rekeningAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                    'untuk' => $validation->getError('untukAddEditForm'),
                    'pejabat' => $validation->getError('pejabatKuitansiAddEditForm'),
                    'jumlah' => $validation->getError('jumlahAddEditForm'),
                ],
                'msg' => '',
            ];
        }else{
            $kode_spd = $this->spd->select('kode')->where('id', $this->request->getVar('noSpdAddEditForm'))->first();
            $pegawai_all =  $this->spd->select('pegawai_all')->where('id', $this->request->getVar('noSpdAddEditForm'))->first();
            $pangol = $this->pegawai->select('kode_pangol')->where('nip', $this->request->getVar('namaPegawaiAddEditForm'))->first();
            $jabatan = $this->pegawai->select('kode_jabatan')->where('nip', $this->request->getVar('namaPegawaiAddEditForm'))->first();
            $instansi = $this->spd->select('kode_instansi')->where('id', $this->request->getVar('noSpdAddEditForm'))->first();

            $data = [
                'kode_spd' => $kode_spd['kode'],
                'pegawai_all' => $pegawai_all['pegawai_all'],
                'pegawai_diperintah' => $this->db->escapeString($this->request->getVar('namaPegawaiAddEditForm')),
                'nip_pegawai' => $this->db->escapeString($this->request->getVar('nipAddEditForm')),
                'kode_pangol' => $pangol['kode_pangol'],
                'kode_jabatan' => $jabatan['kode_jabatan'],
                'awal' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tglBerangkatAddEditForm')))),
                'akhir' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tglKembaliAddEditForm')))),
                'lama' => $this->db->escapeString($this->request->getVar('lamaAddEditForm')),
                'kode_rekening' => $this->db->escapeString($this->request->getVar('rekeningAddEditForm')),
                'kode_instansi' => $instansi['kode_instansi'],
                'untuk' => $this->db->escapeString($this->request->getVar('untukAddEditForm')),
                'pejabat' => $this->db->escapeString($this->request->getVar('pejabatKuitansiAddEditForm')),
                'jumlah_uang' => $this->db->escapeString($this->request->getVar('jumlahAddEditForm')),
            ];

            // d($data);print_r($data);die();

            $id = $this->request->getVar('hiddenID');
            if ($this->kuitansi->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('bendahara/kuitansi'));
            } else {
                $data = array('success' => false, 'msg' => $this->kuitansi->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
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

            if ($this->kuitansi->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    public function print($id = null){

        if (!$id) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $data = $this->kuitansi->where('id',$id)->first();

        $data['instansi'] = $this->instansi->select(['kode', 'nama_instansi'])->where('kode', $data['kode_instansi'])->first();
        $data['pegawai'] = $this->pegawai->where('nip', $data['pegawai_diperintah'])->first();

        $wilayah = $this->rekening->select('kode_jenis_wilayah')->where('kode', $data['kode_rekening'])->first();
        $data['wilayah'] = $this->wilayah->where('kode', $wilayah['kode_jenis_wilayah'])->first();

        $data['pejabat'] = $this->pegawai->select(['nip', 'nama'])->where('nip', $data['pejabat'])->first();
        $data['bendahara'] = $this->pegawai->select(['nip', 'nama'])->where('nip', $data['bendahara'])->first();
        $data['kepala'] = $this->pegawai->select(['nip', 'nama', 'kode_jabatan'])->where('nip', $data['yang_menyetujui'])->first();
        $data['jabatan'] = $this->jabatan->where('kode', $data['kepala']['kode_jabatan'])->first();

        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();

        $filename = 'Kuitansi_Spd_No_'.$data['kode_spd'] ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot("C:\\www\\surat\\public");
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('bendahara/kuitansi/p-kuitansi', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }
}
