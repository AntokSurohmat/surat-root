<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Admin\WilayahModel;
use App\Models\Admin\RekeningModel;
use App\Models\Pegawai\SpdModel;

use CodeIgniter\HTTP\IncomingRequest;


/**
 * @property IncomingRequest $request
*/

class Spd extends BaseController
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {

        if (session()->get('level') != "Pegawai") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $this->pegawai = new PegawaiModel();
        $this->instansi = new instansiModel();
        $this->provinsi = new ProvinsiModel();
        $this->kabupaten = new KabupatenModel();
        $this->kecamatan = new KecamatanModel();
        $this->wilayah = new WilayahModel();
        $this->rekening = new RekeningModel();
        $this->spd = new SpdModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        $profile = $this->pegawai->select(['foto', 'nama'])->where('id', $this->session->id)->first();
        $data = array(
            'title' => 'SURAT PERJALANAN DINAS',
            'parent' => 2,
            'pmenu' => 2.2,
            'photo' => $profile['foto'],
            'nama'  => $profile['nama']
        );
        return view('pegawai/spd/v-spd', $data);
    }
    function load_data() {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }
        $pegawai = $this->db->table('pegawai')->get();
        $list = $this->spd->get_datatables();
        $count_all = $this->spd->count_all();
        $count_filter = $this->spd->count_filter();

        // d($list);print_r($list);die();
        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->kodes;
            foreach ($pegawai->getResult() as $pega ) {
                if ($pega->nip == $key->diperintah) {
                    $row[] =  $pega->nama;
                }
            };
            $row[] = $key->nama_pegawai;
            $row[] = $key->untuk;
            $row[] = $key->jenis_kendaraan;
            $row[] = $key->keterangan;

            $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
            $button .= $key->status == 'true' ? '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="javascript:void(0)" name="print" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>' : '' ;
            $button .= $key->status == 'true' ? '<a class="btn btn-xs btn-secondary mr-1 mb-1 print" href="javascript:void(0)" name="print" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Download Data ]"><i class="fas fa-download text-white"></i></a>' : '' ;

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

}
