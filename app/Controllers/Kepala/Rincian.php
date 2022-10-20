<?php

namespace App\Controllers\Kepala;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\SpdModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\SbuhModel;
use App\Models\Admin\RekeningModel;
use App\Models\Admin\PegawaiModel;
use App\Models\Bendahara\KuitansiModel;
use App\Models\Bendahara\RincianModel;
use \Hermawan\DataTables\DataTable;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
*/

class Rincian extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
    public function __construct()
    {
        if (session()->get('level') != "Kepala Bidang") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $this->spd = new SpdModel();
        $this->instansi = new InstansiModel();
        $this->sbuh = new SbuhModel();
        $this->rekening = new RekeningModel();
        $this->pegawai = new PegawaiModel();
        $this->kuitansi = new KuitansiModel();
        $this->rincian = new RincianModel();
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
            'title' => 'RINCIAN BIAYA',
            'parent' => 4,
            'pmenu' => 4.2
        );
        return view('kepala/rincian/v-rincian', $data);
    }

    public function load_data() {

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $builder = $this->db->table('rincian')
                  ->select('id,kode_spd, rincian_sbuh, jumlah_uang, jumlah_total')
                  ->where('deleted_at', null);

        return DataTable::of($builder)
            ->postQuery(function($builder){
                $builder->orderBy('kode_spd', 'desc');
                $builder->where('deleted_at', null);
            })
            ->format('jumlah_uang', function($value){return 'Rp. '.number_format($value, 0,'','.');})
            ->format('jumlah_total', function($value){return 'Rp. '.number_format($value, 0,'','.');})
            ->setSearchableColumns(['kode_spd', 'rincian_sbuh', 'jumlah_uang', 'jumlah_total'])
            ->add(null, function($row){
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="/kepala/Rincian/print/' . $row->id . '" target="_blank" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
                return $button;
            }, 'last')
            ->hide('id')
            ->addNumbering()
            ->toJson();

    }

    public function getNoSpd() {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->where('deleted_at', NULL)
                ->orderBy('pegawai_diperintah')
                ->findAll(10);
        } else {
            $spdlist = $this->spd->select('id,kode') // Fetch record
                ->where('deleted_at', NULL)
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

    function getDetailNoSpd(){
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        if ($this->request->getVar('kode')) {

            $kuitansi = $this->kuitansi->where('kode_spd', $this->request->getVar('kode'))->first();
            if($kuitansi == null){
                $data = array('success' => false, 'msg' => 'Kuitansi Dengan NO SPD '.$this->request->getVar('kode').' Tidak Ada, Silahkan Membuat Terlebih Dahulu', 'isi' => '');
            }else{
                $instansi = $this->instansi->where('kode', $kuitansi['kode_instansi'])->first();
                $sbuh = $this->sbuh
                ->where('kode_provinsi', $instansi['kode_provinsi'])
                ->where('kode_kabupaten', $instansi['kode_kabupaten'])
                ->where('kode_kecamatan', $instansi['kode_kecamatan'])
                ->first();
    
                $data = array('success' => true, 'msg' => '', 'rincian' => $sbuh , 'isi' => $kuitansi );
            }
            
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

    function single_data()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $rincian_id = $this->rincian->where('id', $this->request->getVar('id'))->where('deleted_at', NULL)->get();
        if($rincian_id->getRow() == null){
            return redirect()->to(site_url('kepala/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('kepala/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $data = $this->rincian->where('id', $this->request->getVar('id'))->first();
            $data['json'] = json_decode($data['detail']);

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function view_data() {

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $rincian_id = $this->rincian->where('id', $this->request->getVar('id'))->where('deleted_at', NULL)->get();
        if($rincian_id->getRow() == null){
            return redirect()->to(site_url('kepala/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('kepala/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $data = $this->rincian->where('id', $this->request->getVar('id'))->first();

            $data['bendahara'] = $this->pegawai->select(['nama', 'nip'])->where('nip', $data['bendahara'])->first();
            $data['kepala'] = $this->pegawai->select(['nama', 'nip'])->where('nip', $data['yang_menyetujui'])->first();
            $data['json'] = json_decode($data['detail']);
            $jml_biaya = array();
            foreach($data['json'] as $json){
                foreach($json as $row => $jumlah){
                    if($row == 'jumlah_biaya'){
                        $jml_biaya[] = ($jumlah != '') ? $jumlah : 0;
                    }
                }
            }

            $data['json'] = json_decode($data['detail']);

            $sum = array_reduce( $jml_biaya, function($carry, $item){return $carry + $item;});
            $sum = $sum + $data['jumlah_uang'];$data['sum'] = $sum;

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
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
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

        $rincian_id = $this->rincian->where('id', $id)->where('deleted_at', NULL)->get();
        if($rincian_id->getRow() == null){
            return redirect()->to(site_url('kepala/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
            return redirect()->to(site_url('kepala/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        $data = $this->rincian->where('id', $id)->first();

        $data['bendahara'] = $this->pegawai->select(['nama', 'nip'])->where('nip', $data['bendahara'])->first();
        $data['kepala'] = $this->pegawai->select(['nama', 'nip'])->where('nip', $data['yang_menyetujui'])->first();
        $data['json'] = json_decode($data['detail']);
        $jml_biaya = array();
        foreach($data['json'] as $json){
            foreach($json as $row => $jumlah){
                if($row == 'jumlah_biaya'){
                    $jml_biaya[] = ($jumlah != '') ? $jumlah : 0;
                }
            }
        }

        $data['json'] = json_decode($data['detail']);

        $sum = array_reduce( $jml_biaya, function($carry, $item){return $carry + $item;});
        $sum = $sum + $data['jumlah_uang'];$data['sum'] = $sum;

        // d($data);print_r($data);die();

        $filename = 'Rincian_Spd_No_'.$data['kode_spd'] ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('kepala/rincian/p-rincian', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }
}
