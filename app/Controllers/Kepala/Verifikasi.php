<?php

namespace App\Controllers\Kepala;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Admin\SpdModel;
use App\Models\Admin\SptModel;
use App\Models\Admin\TujuanModel;
use App\Models\Admin\PegawaiModel;
use \Hermawan\DataTables\DataTable;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use CodeIgniter\HTTP\IncomingRequest;
use App\Models\Kepala\VerifikasiModel;
use CodeIgniter\RESTful\ResourcePresenter;


/**
 * @property IncomingRequest $request
*/


class Verifikasi extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
    public function __construct(){
        if (session()->get('level') != "Kepala Bidang") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $this->pegawai    = new PegawaiModel();
        $this->spt        = new SptModel();
        $this->spd        = new SpdModel();
        $this->instansi   = new InstansiModel();
        $this->tujuan     = new TujuanModel();
        $this->provinsi   = new ProvinsiModel();
        $this->kabupaten  = new KabupatenModel();
        $this->kecamatan  = new KecamatanModel();
        $this->verifikasi = new VerifikasiModel();
        $this->csrfToken  = csrf_token();
        $this->csrfHash   = csrf_hash();
        $this->db         = \Config\Database::connect();
        $this->session    = \Config\Services::session();
        $this->session->start();
    }
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        $data = array(
            'title' => 'VERIFIKASI',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('kepala/verifikasi/v-verifikasi', $data);
    }

    public function load_data() {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $builder = $this->db->table('spt')
                  ->select('spt.id, spt.kode, pegawai_all, instansi.nama_instansi, awal, akhir, pegawai.nama, status, keterangan',)
                  ->join('pegawai', 'pegawai.nip = spt.pejabat')
                  ->join('instansi', 'instansi.kode = spt.kode_instansi');

        return DataTable::of($builder)
            ->postQuery(function($builder){
                $builder->orderBy('id', 'desc');
                $builder->where('spt.deleted_at', null);
            })
            ->format('awal', function($value){return date_indo(date('Y-m-d', strtotime($value)));})
            ->format('akhir', function($value){return date_indo(date('Y-m-d', strtotime($value)));})
            ->format('pegawai_all', function($value){
                $query = $this->pegawai->whereIn('nip', json_decode($value))->get();
                foreach($query->getResult() as $row){$pegawai[] = $row->nama;}return $pegawai;
            })
            ->filter(function ($builder, $request) {
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
            ->add(null, function($row){
            if($row->status == "Revisi"){
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
            }elseif($row->status == 'Disetujui'){
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                $button .= '<a type="button"class="btn btn-xs btn-success mr-1 mb-1 print" href="/Kepala/Verifikasi/print/' .$row->id. '" target="_blank" name="delete" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
            }else{
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                $button .= '<a type="button" class="btn btn-xs btn-primary mr-1 mb-1 verifikasi" href="javascript:void(0)" name="verifikasi" data-id="'. $row->id .'"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Verifikasi Data ]"><i class="fas fa-check text-white"></i></a>' ;
            }
                return $button;
            }, 'last')
            ->hide('id')
            ->addNumbering()
            ->toJson();
    }
    public function getNoSptTable() {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $spdlist = $this->spt->select('id,kode') // Fetch record
                ->where('deleted_at', NULL)
                ->orderBy('kode')
                ->findAll(10);

        } else {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->where('deleted_at', NULL)
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
                ->where('deleted_at', NULL)
                ->orderBy('nama')
                ->findAll(10);
        } else {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('deleted_at', NULL)            
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
                ->where('deleted_at', NULL)
                ->orderBy('nama_instansi')
                ->findAll(10);;
        } else {
            $instansilist = $this->instansi->select('kode,nama_instansi') // Fetch record
                ->where('deleted_at', NULL)
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

    function view_data(){

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
         }
        $spt_id = $this->spt->where('id', $this->request->getVar('id'))->where('deleted_at', NULL)->get();
        if($spt_id->getRow() == null){
            return redirect()->to(site_url('kepala/verifikasi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('kepala/verifikasi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $data = $this->verifikasi->where('id', $this->request->getVar('id'))->first();

            $builder = $this->db->table('pegawai');
            $query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->whereIn('pegawai.nip', json_decode($data['pegawai_all']))->get();

            $data['looping'] = $query->getResult();
            $data['pegawai'] = $this->pegawai->where('nip', $data['pejabat'])->first();
            $data['instansi'] = $this->instansi->where('kode', $data['kode_instansi'])->first();
            $data['untuk'] = $this->tujuan->where('id', $data['untuk'])->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
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
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
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
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
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
        $verifikasi_id = $this->verifikasi->where('id', $this->request->getVar('hidden_id'))->where('deleted_at', NULL)->get();
        if($verifikasi_id->getRow() == null){
            return redirect()->to(site_url('kepala/verifikasi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('hidden_id')) {
            return redirect()->to(site_url('kepala/verifikasi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }


        $validation = \Config\Services::validation();

        if($this->request->getVar('radioAddEditModalVerifikasi') == 'Revisi'){
            $valid = $this->validate([
                'ketAddEditModalVerifikasi' => [
                    'label'     => 'Keterangan',
                    'rules'     => 'required|max_length[20]',
                    'errors' => [ 'max_length' => '{field} Maksimal 20 Karakter'],
                ],
            ]);
        }else{
            $valid = $this->validate([
                'ketAddEditModalVerifikasi' => [
                    'label'     => 'Keterangan',
                    'rules'     => 'max_length[20]',
                    'errors' => [ 'max_length' => '{field} Maksimal 20 Karakter'],
                ],
            ]);
        }
        $valid = $this->validate([
            'ketAddEditModalVerifikasi' => [
                'label'     => 'Keterangan',
                'rules'     => 'permit_empty|max_length[20]',
                'errors' => [ 'max_length' => '{field} Maksimal 20 Karakter'],
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
                    'ket' => $validation->getError('ketAddEditModalVerifikasi'),
                ],
                'msg' => '',
            ];
        }else{
            $data = [
                'status' => $this->db->escapeString($this->request->getVar('radioAddEditModalVerifikasi')),
                'keterangan' => $this->db->escapeString($this->request->getVar('ketAddEditModalVerifikasi')),
                'yang_menyetujui' => $this->db->escapeString($this->session->nip),
            ];

            $id = $this->request->getVar('hidden_id');
            if($this->request->getVar('radioAddEditModalVerifikasi') == 'Revisi') {

                if ($this->verifikasi->update($id, $data)) {
                    $data = array('success' => true, 'msg' => 'Data Berhasil disimpan' );
                } else {
                    $data = array('success' => false, 'msg' => $this->verifikasi->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                }
            }elseif('Disetujui'){

                if ($this->verifikasi->update($id, $data)) {
                    $spt = $this->spt->where('id', $id)->first();
                    $data = [
                        'kode_spt' => $spt['kode'],
                        'pejabat' => $spt['pejabat'],
                        'pegawai_all' => $spt['pegawai_all'],
                        'untuk' => $spt['untuk'],
                        'kode_instansi' => $spt['kode_instansi'],
                        'awal' => $spt['awal'],
                        'akhir' => $spt['akhir'],
                        'lama' => $spt['lama'],
                        'yang_menyetujui' => $spt['yang_menyetujui'],
                    ];
    
                    if($this->spd->insert($data)){
                        $data = array('success' => true, 'msg' => 'Data Berhasil disimpan' );
                    }else{
                        $data = array('success' => false, 'msg' => $this->verifikasi->errors(), 'error' => 'Terjadi kesalahan dalam memilah data spd');
                    }
                } else {
                    $data = array('success' => false, 'msg' => $this->verifikasi->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                }
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
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
    public function print($id = null){

        $spt_id = $this->spt->where('id', $id)->where('deleted_at', NULL)->get();
        if($spt_id->getRow() == null){
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        if (!$id) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $data = $this->spt->where('id',$id)->first();

        $builder = $this->db->table('pegawai');
        $query = $builder->select('pegawai.*')
        ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
        ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
        ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
        ->whereIn('pegawai.nip', json_decode($data['pegawai_all']))->get();

        $data['looping'] = $query->getResult();
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
        $dompdf->loadHtml(view('kepala/verifikasi/p-verifikasi', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }
}
