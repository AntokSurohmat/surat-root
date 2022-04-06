<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\SptModel;
use \Hermawan\DataTables\DataTable;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\HTTP\IncomingRequest;
/**
 * @property IncomingRequest $request
*/


class Lapspt extends BaseController
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
    public function __construct()
    {
        if (session()->get('level') != "Admin") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $this->pegawai = new PegawaiModel();
        $this->instansi = new instansiModel();
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
            'title' => 'LAPORAN SURAT PERINTAH TUGAS',
            'parent' => 4,
            'pmenu' => 4.1
        );
        return view('admin/lapspt/v-lapspt', $data);
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
            ->postQuery(function($builder){$builder->orderBy('kode', 'desc');})
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
                if($row->status == 'Disetujui'){
                    $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="/Admin/Lapspt/print/' . $row->id . '" target="_blank" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
                    $button .= '<a class="btn btn-xs btn-secondary mr-1 mb-1 download" href="/Admin/Lapspt/download/' . $row->id.'" target="_blank" name="download" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Download Data ]"><i class="fas fa-download text-white"></i></a>';
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

    function view_data()
    {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $pst_id = $this->spt->where('id', $this->request->getVar('id'))->get();
        if($pst_id->getRow() == null){
             return redirect()->to(site_url('admin/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
             return redirect()->to(site_url('admin/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $data = $this->spt->where('id', $this->request->getVar('id'))->first();

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

    public function print($id = null){

        $spt = $this->spt->where('id', $id)->get();
        if($spt->getRow() == null){
             return redirect()->to(site_url('admin/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
             return redirect()->to(site_url('admin/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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

        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();

        $filename = 'Spt_No_'.$data['kode'] ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot("C:\\www\\surat\\public");
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/lapspt/p-spt', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }
    public function download($id = null){

        $spt = $this->spt->where('id', $id)->get();
        if($spt->getRow() == null){
             return redirect()->to(site_url('admin/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
             return redirect()->to(site_url('admin/lapspt/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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

        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();

        $filename = 'Spt_No_'.$data['kode'] ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot("C:\\www\\surat\\public");
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/lapspt/p-spt', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename);
    }

    public function print_all(){

        // if (!$id) {
        //     throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        // }
        $spt = $this->spt->get();

        $data['spt'] =  $spt->getResult();

        $builder = $this->db->table('pegawai');
        $looping = $builder->select('pegawai.*')
        ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
        ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
        ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')->get();

        $data['looping'] = $looping->getResult();
        $pegawai = $this->pegawai->get();
        $data['pegawai'] = $pegawai->getResult();
        
        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();
        
        $filename = 'All_Spt' ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot("C:\\www\\surat\\public");
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/lapspt/p-sptall', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();
   

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }

    public function download_all(){

        // if (!$id) {
        //     throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        // }
        $spt = $this->spt->get();

        $data['spt'] =  $spt->getResult();

        $builder = $this->db->table('pegawai');
        $looping = $builder->select('pegawai.*')
        ->select('pangol.nama_pangol')->select('jabatan.nama_jabatan')
        ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
        ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')->get();

        $data['looping'] = $looping->getResult();
        $pegawai = $this->pegawai->get();
        $data['pegawai'] = $pegawai->getResult();
        
        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();
        
        $filename = 'All_Spt' ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot("C:\\www\\surat\\public");
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('admin/lapspt/p-sptall', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();
   

        // output the generated pdf
        $dompdf->stream($filename);
    }
}
