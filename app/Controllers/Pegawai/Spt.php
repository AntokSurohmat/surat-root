<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Pegawai\SptModel;
use \Hermawan\DataTables\DataTable;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\HTTP\IncomingRequest;


/**
 * @property IncomingRequest $request
*/
class Spt extends BaseController
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
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
        $this->spt = new SptModel();
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
            'title' => 'SURAT PERINTAH TUGAS',
            'parent' => 2,
            'pmenu' => 2.1,
            'photo' => $profile['foto'],
            'nama'  => $profile['nama']
        );
        return view('pegawai/spt/v-spt', $data);
    }


    public function load_data() {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $builder = $this->db->table('spt')
                  ->select('spt.id, spt.kode, pegawai_all, instansi.nama_instansi, awal, akhir, pegawai.nama, status, keterangan')
                  ->join('pegawai', 'pegawai.nip = spt.pejabat')
                  ->join('instansi', 'instansi.kode = spt.kode_instansi')
                  ->where('spt.deleted_at', null);

        return DataTable::of($builder)
            ->postQuery(function($builder){
                $builder->orderBy('kode', 'desc');
                $builder->like('pegawai_all', $this->session->get('nip'));
                $builder->where('spt.deleted_at', null);
            })
            ->format('awal', function($value){return date_indo(date('Y-m-d', strtotime($value)));})
            ->format('akhir', function($value){return date_indo(date('Y-m-d', strtotime($value)));})
            ->format('pegawai_all', function($value){
                $namas = array();
                foreach(json_decode($value) as $valu ) {
                    $okay = $this->pegawai->where('nip', $valu)->get();
                    $result = $okay->getResult();
                    $namas[] = $result[0]->nama;
                }
                return $namas;
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
                if($row->status == 'Disetujui'){
                    $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="/Pegawai/Spt/print/' . $row->id . '" target="_blank" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-secondary mr-1 mb-1 download" href="/Pegawai/Spt/download/' . $row->id . '" name="download" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Download Data ]"><i class="fas fa-download text-white"></i></a>';
                }else{
                    $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
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

    function view_data()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $spt_id = $this->spt->where('id', $this->request->getVar('id'))->where('deleted_at', NULL)->get();
        if($spt_id->getRow() == null){
            return redirect()->to(site_url('pegawai/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('pegawai/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    public function print($id = null){

        $spt_id = $this->spt->where('id', $id)->where('deleted_at', NULL)->get();
        if($spt_id->getRow() == null){
            return redirect()->to(site_url('pegawai/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
            return redirect()->to(site_url('pegawai/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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
        $dompdf->loadHtml(view('pegawai/spt/p-spt', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }

    public function download($id = null){

        $spt_id = $this->spt->where('id', $id)->where('deleted_at', NULL)->get();
        if($spt_id->getRow() == null){
            return redirect()->to(site_url('pegawai/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
            return redirect()->to(site_url('pegawai/spt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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
        $dompdf->loadHtml(view('pegawai/spt/p-spt', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

}
