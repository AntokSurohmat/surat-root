<?php

namespace App\Controllers\Kepala;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\JabatanModel;
use App\Models\Admin\PangolModel;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\SpdModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\SbuhModel;
use App\Models\Admin\RekeningModel;
use App\Models\Admin\JenisWilayahModel;
use App\Models\Bendahara\KuitansiModel;
use \Hermawan\DataTables\DataTable;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
*/

class Kuitansi extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
    public function __construct()
    {
        if (session()->get('level') != "Kepala Bidang") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $this->jabatan = new JabatanModel();
        $this->pangol = new PangolModel();
        $this->pegawai = new PegawaiModel();
        $this->spd = new SpdModel();
        $this->instansi = new InstansiModel();
        $this->sbuh = new SbuhModel();
        $this->rekening = new RekeningModel();
        $this->wilayah = new JenisWilayahModel();
        $this->kuitansi = new KuitansiModel();
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
            'parent' => 4,
            'pmenu' => 4.1
        );
        return view('kepala/kuitansi/v-kuitansi', $data);
    }

    public function load_data() {

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $builder = $this->db->table('kuitansi')
                  ->select('kuitansi.id,kode_spd, pegawai.nama, instansi.nama_instansi, awal, akhir, jumlah_uang')
                  ->join('pegawai', 'pegawai.nip = kuitansi.pegawai_diperintah')
                  ->join('instansi', 'instansi.kode = kuitansi.kode_instansi')
                  ->where('kuitansi.deleted_at', null);

        return DataTable::of($builder)
            ->postQuery(function($builder){
                $builder->orderBy('kode_spd', 'desc');
                $builder->where('kuitansi.deleted_at', null);
            })
            ->format('awal', function($value){return date_indo(date('Y-m-d', strtotime($value)));})
            ->format('akhir', function($value){return date_indo(date('Y-m-d', strtotime($value)));})
            ->format('jumlah_uang', function($value){return 'Rp. '.number_format($value, 0,'','.');})
            ->filter(function ($builder, $request) {
                if ($request->noSpd)
                    $builder->where('kode_spd', $request->noSpd);
                if ($request->pegawai)
                    $builder->where('nama', $request->pegawai);
                if($request->awal)
                    $builder->where('awal', date("Y-m-d", strtotime(str_replace('/', '-',$request->awal))));
                if($request->akhir)
                    $builder->where('akhir', date("Y-m-d", strtotime(str_replace('/', '-',$request->akhir))));
                if ($request->instansi)
                    $builder->where('instansi.nama_instansi', $request->instansi);
            })
            ->add(null, function($row){
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="/kepala/Kuitansi/Print/' . $row->id . '" name="print" target="_blank" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
                return $button;
            }, 'last')
            ->hide('id')->addNumbering()
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
                "id" => $pegawai['id'],
                "text" => $pegawai['kode'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getPegawaiNoSpd(){
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        $pegawailist = $this->spd->select('pegawai_all')->where('id', $this->request->getPost('spd'))->first();

        $data = array();
        $nama = $this->pegawai->havingIn('nip', json_decode($pegawailist['pegawai_all']))->get();

        foreach ($nama->getResult()  as  $nama) {
            $data[] = array(
                "id" => $nama->nip,
                "text" => $nama->nama,
            );
        }
        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    function getDetailPegawaiNoSpd(){
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        // d($this->request->getVar('id'));print_r($this->request->getVar('id'));die();
        if ($this->request->getVar('kode') && $this->request->getVar('id')) {
            $data = $this->pegawai->where('nip', $this->request->getVar('kode'))->first();
            if($data != null){
                // d($data);print_r($data);die();
    
                $data['pangol'] = $this->pangol->where('kode', $data['kode_pangol'])->first();
    
                // d($data['pangol']);print_r($data)
                $data['jabatan'] = $this->jabatan->where('kode', $data['kode_jabatan'])->first();
    
                $data['spd'] = $this->spd->where('id', $this->request->getVar('id'))->first();
    
                $data['instansi'] = $this->instansi->where('kode', $data['spd']['kode_instansi'])->first();
                $data['sbuh'] = $this->sbuh
                                ->where('kode_provinsi', $data['instansi']['kode_provinsi'])
                                ->where('kode_kabupaten', $data['instansi']['kode_kabupaten'])
                                ->where('kode_kecamatan', $data['instansi']['kode_kecamatan'])
                                ->first();
                $data['success'] =  true ;
            }else{
                $data = array('success' => false, 'msg' => 'Pegawai Yang Anda Pilih Tidak Mempunyai Data / Data Pegawai Telah Dihapus');
            }

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }
    public function getPelaksana() {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('deleted_at', NULL)
                ->where('nip !=', $this->request->getPost('bendahara'))
                ->orderBy('nama')
                ->findAll(10);
        } else {
            $pegawailist = $this->pegawai->select('nip,nama') // Fetch record
                ->where('deleted_at', NULL)
                ->where('nip !=', $this->request->getPost('bendahara'))
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
    public function getNoSpdTable() {
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
                "id" => $pegawai['nama'],
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
                ->findAll(10);
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

    function single_data() {

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

         $kuitansi_id = $this->kuitansi->where('id', $this->request->getVar('id'))->where('deleted_at', NULL)->get();
         if($kuitansi_id->getRow() == null){
             return redirect()->to(site_url('kepala/kuitansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }
         if (!$this->request->getVar('id')) {
             return redirect()->to(site_url('kepala/kuitansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }

        if ($this->request->getVar('id')) {
            $data = $this->kuitansi->where('id', $this->request->getVar('id'))->first();

            $data['spd'] = $this->spd->where('kode', $data['kode_spd'])->first();
            $data['pangol'] = $this->pangol->where('kode', $data['kode_pangol'])->first();
            $data['jabatan'] = $this->jabatan->where('kode', $data['kode_jabatan'])->first();
            $data['instansi'] = $this->instansi->where('kode', $data['spd']['kode_instansi'])->first();
            $data['instansi'] = $this->instansi->where('kode', $data['spd']['kode_instansi'])->first();
            $data['sbuh'] = $this->sbuh
                            ->where('kode_provinsi', $data['instansi']['kode_provinsi'])
                            ->where('kode_kabupaten', $data['instansi']['kode_kabupaten'])
                            ->where('kode_kecamatan', $data['instansi']['kode_kecamatan'])
                            ->first();
            $data['pegawai'] = $this->pegawai->where('nip', $data['pegawai_diperintah'])->first();
            $data['pejabat'] = $this->pegawai->select(['nip', 'nama'])->where('nip', $data['pejabat'])->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function view_data() {

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $kuitansi_id = $this->kuitansi->where('id', $this->request->getVar('id'))->where('deleted_at', NULL)->get();
        if($kuitansi_id->getRow() == null){
            return redirect()->to(site_url('kepala/kuitansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('kepala/kuitansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $data = $this->kuitansi->where('id', $this->request->getVar('id'))->first();

            $data['instansi'] = $this->instansi->select(['kode', 'nama_instansi'])->where('kode', $data['kode_instansi'])->first();
            $data['pegawai'] = $this->pegawai->where('nip', $data['pegawai_diperintah'])->first();

            $wilayah = $this->rekening->select('kode_jenis_wilayah')->where('kode', $data['kode_rekening'])->first();
            $data['wilayah'] = $this->wilayah->where('kode', $wilayah['kode_jenis_wilayah'])->first();

            $data['pejabat'] = $this->pegawai->select(['nip', 'nama'])->where('nip', $data['pejabat'])->first();
            $data['bendahara'] = $this->pegawai->select(['nip', 'nama'])->where('nip', $data['bendahara'])->first();
            $data['kepala'] = $this->pegawai->select(['nip', 'nama', 'kode_jabatan'])->where('nip', $data['yang_menyetujui'])->first();
            $data['jabatan'] = $this->jabatan->where('kode', $data['kepala']['kode_jabatan'])->first();

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
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $kuitansi_id = $this->kuitansi->where('id', $this->request->getVar('id'))->where('deleted_at', NULL)->get();
        if($kuitansi_id->getRow() == null){
            return redirect()->to(site_url('kepala/kuitansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('kepala/kuitansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $id = $this->request->getVar('id');

            if ($this->kuitansi->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    public function print($id = null){

        $kuitansi_id = $this->kuitansi->where('id', $id)->where('deleted_at', NULL)->get();
        if($kuitansi_id->getRow() == null){
            return redirect()->to(site_url('kepala/kuitansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
            return redirect()->to(site_url('kepala/kuitansi/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = $this->kuitansi->where('id',$id)->first();

        $data['instansi'] = $this->instansi->select(['kode', 'nama_instansi'])->where('kode', $data['kode_instansi'])->first();
        $data['pegawai'] = $this->pegawai->where('nip', $data['pegawai_diperintah'])->first();

        $wilayah = $this->rekening->select('kode_jenis_wilayah')->where('kode', $data['kode_rekening'])->first();
        $data['wilayah'] = $this->wilayah->where('kode', $wilayah['kode_jenis_wilayah'])->first();

        $data['pejabat'] = $this->pegawai->select(['nip', 'nama'])->where('nip', $data['pejabat'])->first();
        $data['bendahara'] = $this->pegawai->select(['nip', 'nama'])->where('nip', $data['bendahara'])->first();
        $data['kepala'] = $this->pegawai->select(['nip', 'nama', 'kode_jabatan'])->where('nip', $data['yang_menyetujui'])->first();
        $data['jabatan'] = $this->jabatan->where('kode', $data['kepala']['kode_jabatan'])->first();

        $data[$this->csrfToken] = $this->csrfHash;
        // d($data);print_r($data);die();

        $filename = 'Kuitansi_Spd_No_'.$data['kode_spd'] ;
        // instantiate and use the dompdf class
        $options = new Options();
        $dompdf = new Dompdf();

        // change root 
        $dompdf->getOptions()->setChroot(ROOTPATH . 'public');
        $dompdf->getOptions()->getIsJavascriptEnabled(true);
        // $options->setIsHtml5ParserEnabled(true);
        // $dompdf->setOptions($options);

        // load HTML content
        $dompdf->loadHtml(view('kepala/kuitansi/p-kuitansi', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }
}
