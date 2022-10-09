<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\WilayahModel;
use App\Models\Admin\RekeningModel;
use App\Models\Admin\SpdModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
*/


class Lapspd extends BaseController
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
    public function index()
    {
        $data = array(
            'title' => 'LAPORAN SURAT PERJALAN DINAS',
            'parent' => 4,
            'pmenu' => 4.2
        );
        return view('admin/lapspd/v-lapspd', $data);
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
            ->postQuery(function($builder){
                $builder->orderBy('kode', 'desc');
                $builder->where('spd.deleted_at', null);
            })
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
                    $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                }else{
                    $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="/Admin/Lapspd/print/'.$row->id.'" target="_blank" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-secondary mr-1 mb-1 download" href="/Admin/Lapspd/download/' . $row->id.'" target="_blank" name="download" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Download Data ]"><i class="fas fa-download text-white"></i></a>';
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
    function view_data() {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $psd_id = $this->spd->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
        if($psd_id->getRow() == null){
             return redirect()->to(site_url('admin/lapspd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
             return redirect()->to(site_url('admin/lapspd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
 
        if ($this->request->getVar('id')) {
            $data = $this->spd->where('id', $this->request->getVar('id'))->first();

            $builder = $this->db->table('pegawai');
            $query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->where('pegawai.nip', $data['pegawai_diperintah'])->get();

            $data['pegawai'] = $query->getResult();

            if(count($data['pegawai']) == 0){
                $data['pegawai'][0]['nama'] = 'None';
                $data['pegawai'][0]['nama_pangol'] = 'None';
                $data['pegawai'][0]['nama_jabatan'] = 'None';
            }else{
                $data['pegawai'] = $query->getResult();
            }

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

    public function print($id = null){

        $psd_id = $this->spd->where('id', $id)->where('deleted_at', null)->get();
        if($psd_id->getRow() == null){
             return redirect()->to(site_url('admin/lapspd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
             return redirect()->to(site_url('admin/lapspd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/lapspd/p-spd', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }

    public function download($id = null){

        $psd_id = $this->spd->where('id', $id)->where('deleted_at', null)->get();
        if($psd_id->getRow() == null){
             return redirect()->to(site_url('admin/lapspd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
             return redirect()->to(site_url('admin/lapspd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/lapspd/p-spd', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }
    public function print_all(){

        $spd = $this->spd->where(['kode !=' => null,'deleted_at' => null])->get();
        // $data['spd'] = $spd->getResult();
        $pegawai = array();$looping = array();
        $json = array();$diperintah = array();
        $instansi = array();
        foreach($spd->getResult() as $spd_data){
            $builder = $this->db->table('pegawai');
            $pegawai_query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->where('pegawai.nip', $spd_data->pegawai_diperintah)->get();
    
            $query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->whereIn('pegawai.nip', json_decode($spd_data->pegawai_all))->get();
            
            $pegawai[] = $pegawai_query->getResult();
            $looping[] = $query->getResult();
            $json[] = json_decode($spd_data->detail, true);
            
            $diperintah_query = $this->pegawai->where('nip', $spd_data->pejabat)->get();
            $diperintah[] = $diperintah_query->getResult();
            $instansi[] = $this->instansi->select('nama_instansi')->where('kode', $spd_data->kode_instansi)->first();

        }
        $data['spd'] = $spd->getResult();
        $data['pegawai'] = $pegawai;
        $data['looping'] = $looping;
        $data['json'] = $json;
        $data['diperintah'] = $diperintah;
        $data['instansi'] = $instansi;

        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();

        $filename = 'All_Spd' ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/lapspd/p-spdall', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }

    public function download_all(){

        $spd = $this->spd->where(['kode !=' => null,'deleted_at' => null])->get();
        // $data['spd'] = $spd->getResult();
        $pegawai = array();$looping = array();
        $json = array();$diperintah = array();
        $instansi = array();
        foreach($spd->getResult() as $spd_data){
            $builder = $this->db->table('pegawai');
            $pegawai_query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->where('pegawai.nip', $spd_data->pegawai_diperintah)->get();
    
            $query = $builder->select('pegawai.*')
            ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
            ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
            ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
            ->whereIn('pegawai.nip', json_decode($spd_data->pegawai_all))->get();
            
            $pegawai[] = $pegawai_query->getResult();
            $looping[] = $query->getResult();
            $json[] = json_decode($spd_data->detail, true);
            
            $diperintah_query = $this->pegawai->where('nip', $spd_data->pejabat)->get();
            $diperintah[] = $diperintah_query->getResult();
            $instansi[] = $this->instansi->select('nama_instansi')->where('kode', $spd_data->kode_instansi)->first();

        }
        $data['spd'] = $spd->getResult();
        $data['pegawai'] = $pegawai;
        $data['looping'] = $looping;
        $data['json'] = $json;
        $data['diperintah'] = $diperintah;
        $data['instansi'] = $instansi;

        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();

        $filename = 'All_Spd' ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/lapspd/p-spdall', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function print_recap(){

        $spd_all = $this->spd->where(['kode !=' => null,'deleted_at'=> null])->get();
        $pegawai_all = array();
        foreach($spd_all->getResult() as $result){
            $pegawai_query_all = $this->pegawai->whereIn('nip', json_decode($result->pegawai_all))->get();
            $pegawai_all[] = $pegawai_query_all->getResult();
            $instansi_query_all = $this->instansi->where('kode', $result->kode_instansi)->get();
            $instansi_all[] = $instansi_query_all->getResult();

            //single items
            $diperintah_query = $this->pegawai->where('nip', $result->pegawai_diperintah)->get();
            $diperintah_all[] = $diperintah_query->getResult();
            $yangmerintah_query = $this->pegawai->where('nip', $result->pejabat)->get();
            $memerintah_all[] = $yangmerintah_query->getResult();
            
        }
        $data['spd_all'] = $spd_all->getResult();
        $data['pegawai_all'] = $pegawai_all;
        $data['instansi_all'] = $instansi_all;
        $data['diperintah_all'] = $diperintah_all;
        $data['memerintah_all'] = $memerintah_all;

        $spd = $this->spd->selectMax('id')->where(['kode !=' => null,'deleted_at' => null])->first();
        $data['spd'] = $this->spd->where('id', $spd['id'])->first();
        $pegawai = $this->pegawai->whereIn('nip', json_decode($data['spd']['pegawai_all']))->get();
        $data['pegawai'] = $pegawai->getResult();
        $data['instansi'] = $this->instansi->where('kode', $data['spd']['kode_instansi'])->first();
        $data['diperintah'] = $this->pegawai->where('nip', $data['spd']['pegawai_diperintah'])->first();
        $data['memerintah'] = $this->pegawai->where('nip', $data['spd']['pejabat'])->first();
        // $spt->getResult();
        $data['pejabat'] = $this->pegawai->where('nip', $data['spd']['pejabat'])->first();

        $data[$this->csrfToken] = $this->csrfHash;
        // echo'<pre>';print_r($data);echo'</pre>';die();

        $filename = 'All_Spd' ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/lapspd/r-spdall', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }

    public function download_recap(){
        $spd_all = $this->spd->where(['kode !=' => null,'deleted_at' => null])->get();
        $pegawai_all = array();
        foreach($spd_all->getResult() as $result){
            $pegawai_query_all = $this->pegawai->whereIn('nip', json_decode($result->pegawai_all))->get();
            $pegawai_all[] = $pegawai_query_all->getResult();
            $instansi_query_all = $this->instansi->where('kode', $result->kode_instansi)->get();
            $instansi_all[] = $instansi_query_all->getResult();

            //single items
            $diperintah_query = $this->pegawai->where('nip', $result->pegawai_diperintah)->get();
            $diperintah_all[] = $diperintah_query->getResult();
            $yangmerintah_query = $this->pegawai->where('nip', $result->pejabat)->get();
            $memerintah_all[] = $yangmerintah_query->getResult();
            
        }
        $data['spd_all'] = $spd_all->getResult();
        $data['pegawai_all'] = $pegawai_all;
        $data['instansi_all'] = $instansi_all;
        $data['diperintah_all'] = $diperintah_all;
        $data['memerintah_all'] = $memerintah_all;

        $spd = $this->spd->selectMax('id')->where(['kode !=' => null,'deleted_at' => null])->first();
        $data['spd'] = $this->spd->where('id', $spd['id'])->first();
        $pegawai = $this->pegawai->whereIn('nip', json_decode($data['spd']['pegawai_all']))->get();
        $data['pegawai'] = $pegawai->getResult();
        $data['instansi'] = $this->instansi->where('kode', $data['spd']['kode_instansi'])->first();
        $data['diperintah'] = $this->pegawai->where('nip', $data['spd']['pegawai_diperintah'])->first();
        $data['memerintah'] = $this->pegawai->where('nip', $data['spd']['pejabat'])->first();
        // $spt->getResult();
        $data['pejabat'] = $this->pegawai->where('nip', $data['spd']['pejabat'])->first();

        $data[$this->csrfToken] = $this->csrfHash;
        // echo'<pre>';print_r($data);echo'</pre>';die();

        $filename = 'All_Spd' ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/lapspd/r-spdall', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }
}
