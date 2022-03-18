<?php

namespace App\Controllers\Kepala;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\SptModel;
use App\Models\Admin\SpdModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Kepala\VerifikasiModel;

use CodeIgniter\HTTP\IncomingRequest;


/**
 * @property IncomingRequest $request
*/


class Verifikasi extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct(){
        if (session()->get('level') != "Kepala Bidang") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $this->pegawai = new PegawaiModel();
        $this->spt = new SptModel();
        $this->spd = new SpdModel();
        $this->instansi = new instansiModel();
        $this->provinsi = new ProvinsiModel();
        $this->kabupaten = new KabupatenModel();
        $this->kecamatan = new KecamatanModel();
        $this->verifikasi = new VerifikasiModel();
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
            'title' => 'VERIFIKASI',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('kepala/verifikasi/v-verifikasi', $data);
    }

    function load_data() {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }
        $pegawai = $this->db->table('pegawai')->get();
        $list = $this->verifikasi->get_datatables();
        $count_all = $this->verifikasi->count_all();
        $count_filter = $this->verifikasi->count_filter();

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

            if($key->status == "Revisi"){
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="#" name="view" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
            }elseif($key->status == 'Disetujui'){
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="#" name="view" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                $button .= '<a type="button"class="btn btn-xs btn-success mr-1 mb-1 print" href="javascript:void(0)" name="delete" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
            }else{
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="#" name="view" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                $button .= '<a type="button" class="btn btn-xs btn-primary mr-1 mb-1 verifikasi" href="javascript:void(0)" name="verifikasi" data-id="'. $key->id .'"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Verifikasi Data ]"><i class="fas fa-check text-white"></i></a>' ;
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

    function view_data(){

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
        //
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        //
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
        //
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
        // $id = $this->request->getVar('hidden_id');
        // $builder = $this->db->table('spt');
        // $query = $builder->select('lama')->where('id', $id)->get();
        // $spt = $query->getResult();

        // d($spt);print_r($spt);die();

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
            ];

            $id = $this->request->getVar('hidden_id');
            if ($this->verifikasi->update($id, $data)) {

                $spt = $this->spt->where('id', $id)->first();
                $data = [
                    'pejabat' => $spt['pejabat'],'pegawai_all' => $spt['pegawai_all'],
                    'untuk' => $spt['untuk'],'kode_instansi' => $spt['kode_instansi'],
                    'awal' => $spt['awal'],'akhir' => $spt['akhir'],'lama' => $spt['lama'],
                ];

                if($this->spd->insert($data)){

                    $data = array('success' => true, 'msg' => 'Data Berhasil disimpan' );
                }else{
                    $data = array('success' => false, 'msg' => $this->verifikasi->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                }
            } else {
                $data = array('success' => false, 'msg' => $this->verifikasi->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
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
        //
    }
}
