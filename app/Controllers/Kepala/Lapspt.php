<?php

namespace App\Controllers\Kepala;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Admin\SptModel;
use App\Models\Admin\TujuanModel;
use App\Models\Admin\PegawaiModel;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use App\Models\Admin\InstansiModel;
use CodeIgniter\HTTP\IncomingRequest;
/**
 * @property IncomingRequest $request
*/


class Lapspt extends BaseController
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
    public function __construct()
    {
        if (session()->get('level') != "Kepala Bidang") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $this->pegawai   = new PegawaiModel();
        $this->instansi  = new instansiModel();
        $this->spt       = new SptModel();
        $this->tujuan    = new TujuanModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash  = csrf_hash();
        $this->session   = \Config\Services::session();
        $this->db        = \Config\Database::connect();
        $this->session->start();
    }
    public function index()
    {
        $data = array(
            'title' => 'LAPORAN SURAT PERINTAH TUGAS',
            'parent' => 3,
            'pmenu' => 3.1
        );
        return view('kepala/lapspt/v-lapspt', $data);
    }
    public function load_data() {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $builder = $this->db->table('spt')
                  ->select('spt.id, spt.kode, pegawai_all, instansi.nama_instansi, awal, akhir, pegawai.nama, status')
                  ->join('pegawai', 'pegawai.nip = spt.pejabat')
                  ->join('instansi', 'instansi.kode = spt.kode_instansi');

        return DataTable::of($builder)
            ->postQuery(function($builder){
                $builder->orderBy('kode', 'desc');
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
                    $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="/Kepala/Lapspt/print/' . $row->id . '" target="_blank" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-secondary mr-1 mb-1 download" href="/Kepala/Lapspt/download/' . $row->id.'" target="_blank" name="download" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Download Data ]"><i class="fas fa-download text-white"></i></a>';
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
                ->where('deleted_at', null)
                ->orderBy('kode')
                ->findAll(10);
        } else {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->where('deleted_at', null)
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
            $instansilist = $this->instansi->select('kode,nama_instansi') // Fetch 
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

    function view_data()
    {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $pst_id = $this->spt->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
        if($pst_id->getRow() == null){
             return redirect()->to(site_url('kepala/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
             return redirect()->to(site_url('kepala/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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

    public function print($id = null){

        $spt = $this->spt->where('id', $id)->where('deleted_at', null)->get();
        if($spt->getRow() == null){
             return redirect()->to(site_url('kepala/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
             return redirect()->to(site_url('kepala/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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
        $dompdf->loadHtml(view('kepala/lapspt/p-spt', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }
    public function download($id = null){

        $spt = $this->spt->where('id', $id)->where('deleted_at', null)->get();
        if($spt->getRow() == null){
             return redirect()->to(site_url('kepala/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
             return redirect()->to(site_url('kepala/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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
        $dompdf->loadHtml(view('kepala/lapspt/p-spt', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function print_all(){

        $spt = $this->spt->where(['status' => 'Disetujui','deleted_at' => null])->get();
        $looping = array();$pejabat = array();
        $instansi = array();$untuk = array();

        foreach($spt->getResult() as $spt_data){

            $pegawai = array();
            foreach(json_decode($spt_data->pegawai_all) as $value) {
                $builder = $this->db->table('pegawai');
                $query = $builder->select('pegawai.*')
                ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
                ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
                ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
                ->where('pegawai.nip', $value)->where('pegawai.deleted_at', null)->get();
                $pegawai[] = $query->getResult();
            }
    
            $looping[]  = $pegawai;
            $pejabat[] = $this->pegawai->where('nip', $spt_data->pejabat)->first();
            $instansi[] = $this->instansi->where('kode', $spt_data->kode_instansi)->first();
            $untuk[] = $this->tujuan->where('id', $spt_data->untuk)->first();
        }

        $data['spt'] =  $spt->getResult();
        $data['looping'] = $looping;
        $data['pejabat'] = $pejabat;
        $data['instansi'] = $instansi;
        $data['untuk'] = $untuk;

        
        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();
        
        $filename = 'ALL_SPT_'.date('d-m-Y') ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('kepala/lapspt/p-sptall', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();
   

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }

    public function download_all(){

        $spt = $this->spt->where(['status' => 'Disetujui','deleted_at' => null])->get();
        $looping = array();$pejabat = array();
        $instansi = array();$untuk = array();

        foreach($spt->getResult() as $spt_data){
            $pegawai = array();
            foreach(json_decode($spt_data->pegawai_all) as $value) {
                $builder = $this->db->table('pegawai');
                $query = $builder->select('pegawai.*')
                ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
                ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
                ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
                ->where('pegawai.nip', $value)->where('pegawai.deleted_at', null)->get();
                $pegawai[] = $query->getResult();
            }
    
            $looping[]  = $pegawai;
            $pejabat[] = $this->pegawai->where('nip', $spt_data->pejabat)->first();
            $instansi[] = $this->instansi->where('kode', $spt_data->kode_instansi)->first();
            $untuk[] = $this->tujuan->where('id', $spt_data->untuk)->first();
        }

        $data['spt'] =  $spt->getResult();
        $data['looping'] = $looping;
        $data['pejabat'] = $pejabat;
        $data['instansi'] = $instansi;
        $data['untuk'] = $untuk;

        
        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();
        
        $filename = 'ALL_SPT_'.date('d-m-Y') ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('kepala/lapspt/p-sptall', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();
   

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function print_recap(){

        $spt_all = $this->spt->where(['status' => 'Disetujui','deleted_at' => null])->get();
        $pegawai_all = array();
        foreach($spt_all->getResult() as $result){
            $pegawai = array();
            foreach(json_decode($result->pegawai_all) as $value) {
                $builder = $this->db->table('pegawai');
                $query = $builder->select('nip,nama')
                ->where('nip', $value)->where('deleted_at', null)->get();
                $pegawai[] = $query->getResult();
            }
    
            $pegawai_all[]  = $pegawai;
            $instansi_query_all = $this->instansi->where('kode', $result->kode_instansi)->get();
            $instansi_all[] = $instansi_query_all->getResult();
            $tujuan_query_all = $this->tujuan->where('id', $result->untuk)->get();
            $tujuan_all[] = $tujuan_query_all->getResult();
            
        }
        $data['spt_all'] = $spt_all->getResult();
        $data['pegawai_all'] = $pegawai_all;
        $data['instansi_all'] = $instansi_all;
        $data['tujuan_all'] = $tujuan_all;

        $spt = $this->spt->selectMax('id')->first();
        $data['spt'] = $this->spt->where('id', $spt['id'])->first();
        $pegawai = $this->pegawai->whereIn('nip', json_decode($data['spt']['pegawai_all']))->get();
        $data['pegawai'] = $pegawai->getResult();
        $data['instansi'] = $this->instansi->where('kode', $data['spt']['kode_instansi'])->first();
        $data['pejabat'] = $this->pegawai->where('nip', $data['spt']['pejabat'])->first();
        $data['untuk'] = $this->tujuan->where('id', $data['spt']['untuk'])->first();
        // $spt->getResult();


        $data[$this->csrfToken] = $this->csrfHash;
        // echo'<pre>';print_r($data);echo'</pre>';die();
        // d($max->getResult()[0]->id);print_r($max->getResult()[0]->id);die();
        // d($data);print_r($data);die();
        
        $filename = 'ALL_Recap_'.date('d-m-Y') ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('kepala/lapspt/r-sptall', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape'); // landscape or portrait

        // render html as PDF
        $dompdf->render();
   

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));

    }

    public function download_recap(){

        $spt_all = $this->spt->where(['status' => 'Disetujui','deleted_at' => null])->get();
        $pegawai_all = array();
        foreach($spt_all->getResult() as $result){
            $pegawai = array();
            foreach(json_decode($result->pegawai_all) as $value) {
                $builder = $this->db->table('pegawai');
                $query = $builder->select('nip,nama')
                ->where('nip', $value)->where('deleted_at', null)->get();
                $pegawai[] = $query->getResult();
            }
    
            $pegawai_all[]  = $pegawai;
            $instansi_query_all = $this->instansi->where('kode', $result->kode_instansi)->get();
            $instansi_all[] = $instansi_query_all->getResult();
            $tujuan_query_all = $this->tujuan->where('id', $result->untuk)->get();
            $tujuan_all[] = $tujuan_query_all->getResult();
            
        }
        $data['spt_all'] = $spt_all->getResult();
        $data['pegawai_all'] = $pegawai_all;
        $data['instansi_all'] = $instansi_all;
        $data['tujuan_all'] = $tujuan_all;

        $spt = $this->spt->selectMax('id')->first();
        $data['spt'] = $this->spt->where('id', $spt['id'])->first();
        $pegawai = $this->pegawai->whereIn('nip', json_decode($data['spt']['pegawai_all']))->get();
        $data['pegawai'] = $pegawai->getResult();
        $data['instansi'] = $this->instansi->where('kode', $data['spt']['kode_instansi'])->first();
        $data['pejabat'] = $this->pegawai->where('nip', $data['spt']['pejabat'])->first();
        $data['untuk'] = $this->tujuan->where('id', $data['spt']['untuk'])->first();
        // $spt->getResult();


        $data[$this->csrfToken] = $this->csrfHash;
        // echo'<pre>';print_r($data);echo'</pre>';die();
        // d($max->getResult()[0]->id);print_r($max->getResult()[0]->id);die();
        // d($data);print_r($data);die();
        
        $filename = 'ALL_Recap_'.date('d-m-Y') ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('kepala/lapspt/r-sptall', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape'); // landscape or portrait

        // render html as PDF
        $dompdf->render();
   

        // output the generated pdf
        $dompdf->stream($filename);

    }
}
