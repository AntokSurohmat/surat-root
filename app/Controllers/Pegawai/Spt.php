<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Pegawai\SptModel;

use CodeIgniter\HTTP\IncomingRequest;


/**
 * @property IncomingRequest $request
*/
class Spt extends BaseController
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
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
    public function index()
    {
        $data = array(
            'title' => 'SURAT PERINTAH TUGAS',
            'parent' => 2,
            'pmenu' => 2.1
        );
        return view('pegawai/spt/v-spt', $data);
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
        $row[] = $key->nama_pegawai;
        $row[] = $key->dasar;
        $row[] = $key->untuk;
        foreach ($pegawai->getResult() as $pega ) {
            if ($pega->nip == $key->diperintah) {
                $row[] =  $pega->nama;
            }
        };

        $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
        $button .= $key->status == 'Disetujui' ? '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="javascript:void(0)" name="print" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>' : '' ;
        $button .= $key->status == 'Disetujui' ? '<a class="btn btn-xs btn-secondary mr-1 mb-1 print" href="javascript:void(0)" name="print" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Download Data ]"><i class="fas fa-download text-white"></i></a>' : '' ;

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

}
