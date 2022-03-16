<?php

namespace App\Controllers\Bendahara;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\JabatanModel;
use App\Models\Admin\PangolModel;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\SpdModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\SbuhModel;
use App\Models\Bendahara\KuitansiModel;

use CodeIgniter\HTTP\IncomingRequest;


/**
 * @property IncomingRequest $request
*/



class Kuitansi extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
        $this->jabatan = new JabatanModel();
        $this->pangol = new PangolModel();
        $this->pegawai = new PegawaiModel();
        $this->spd = new SpdModel();
        $this->instansi = new InstansiModel();
        $this->kuitansi = new KuitansiModel();
        $this->sbuh = new SbuhModel();
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

    function load_data() {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }
        $pegawai = $this->db->table('pegawai')->get();
        $list = $this->kuitansi->get_datatables();
        $count_all = $this->kuitansi->count_all();
        $count_filter = $this->kuitansi->count_filter();

        // d($list);print_r($list);die();
        $data = array();
        $no = $this->request->getPost('start');
        
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->kode_spd;
            foreach ($pegawai->getResult() as $pega ) {
                if ($pega->nip == $key->nip_pegawai) {
                    $row[] =  $pega->nama;
                }
            };
            $row[] = $key->untuk;
            $row[] = $key->lama;
            $row[] = $key->jumlah_uang;

            $button = $key->status == 'false' ? '<a class="btn btn-xs btn-primary mr-1 mb-1 print" href="/Admin/spd/new/' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Create Data ]"><i class="fas fa-plus text-white"></i></a>' : '' ;
            $button .= '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
            $button .= $key->status == 'true' ? '<a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="/Admin/spd/edit/' . $key->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>' : '' ;
            $button .='<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>';
            $button .= $key->status == 'true' ? '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="javascript:void(0)" name="print" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a><a class="btn btn-xs btn-secondary mr-1 mb-1 print" href="javascript:void(0)" name="print" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Detail Only ]"><i class="fas fa-file-alt text-white"></i></a>' : '' ;
            $row[] = $button;
            if($key->status == 'false'){$status = 'SPD Belum Dibuat';
            }else{$status = 'SPD Sudah Dibuat';}
            $row[] = $status;

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


    public function getNoSpd() {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->orderBy('pegawai_diperintah')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
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

        // $response['count'] = $count;
        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    public function getPegawai(){
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        // d($this->request->getPost('spd'));print_r($this->request->getPost('spd'));die();
        $response = array();
        $pegawailist = $this->spd->select('nama_pegawai')->where('id', $this->request->getPost('spd'))->first();

        $data = array();
        $nama = $this->pegawai->whereIn('nip', json_decode($pegawailist['nama_pegawai']))->get();
        foreach (array_combine(json_decode($pegawailist['nama_pegawai']), $nama->getResultArray())  as $pegawai => $nama) {
            $data[] = array(
                "id" => $pegawai,
                "text" => $nama['nama'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    function getDetailPegawai(){

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
                'rules'     => 'required'
            ],
            'endAddEditForm'   => [
                'label'     => 'Tanggal Kembali',
                'rules'     => 'required'
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
        ]);
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
        //
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
