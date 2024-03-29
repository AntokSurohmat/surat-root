<?php

namespace App\Controllers\Bendahara;

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
        if (session()->get('level') != "Bendahara") {
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
            'parent' => 2,
            'pmenu' => 2.2
        );
        return view('bendahara/rincian/v-rincian', $data);
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
                $button .= '<a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="/Bendahara/Rincian/edit/' . $row->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>' ;
                $button .='<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>';
                $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="/Bendahara/Rincian/print/' . $row->id . '" target="_blank" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
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
        $data = array(
            'title' => 'Input Rincian',
            'parent' => 2,
            'pmenu' => 2.2,
            'method' => 'New',
            'hiddenID' => '',
        );
        return view('bendahara/rincian/v-rincianAddEdit', $data);
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
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'noSpdAddEditForm' => [
                'label'     => 'No SPD',
                'rules'     => 'required|numeric|max_length[3]',
                'errors' => [
                    'numeric'       => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length'    => '{field} Maksimal 3 Karakter',
                ],
            ],
            'rincianBiayaSpdAddEditForm' => [
                'label'     => 'Rincian Biaya Uang Harian',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'jumlahTotalSpdAddEditForm' => [
                'label'     => 'Jumlah Total',
                'rules'     => 'required|numeric|max_length[8]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 8 Karakter',
                ]
            ],
            'rincianBiayaAddEditForm[]' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty',
            ],
            'jumlahAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty'
            ],
            'buktiAddEditForm[]' => [
                'label' => 'Bukti Riil',
                'rules' => "mime_in[buktiAddEditForm,application/pdf,application/msword,image/jpg,image/jpeg,image/gif,image/png]"
                ."|max_size[buktiAddEditForm,10000]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
            ],
        ]);

        if (!$valid) {
            /**
             *'kode' => $validation->getError('kodeAddEdit'),
             * 'kode' -> id or class to display error
             * 'kodeAddEdit' -> name field that ajax send
             */
            $data = [
                'error' => [
                    'noSpd' => $validation->getError('noSpdAddEditForm'),
                    'rincianBiayaSpd' => $validation->getError('rincianBiayaSpdAddEditForm'),
                    'jumlahTotalSpd' => $validation->getError('jumlahTotalSpdAddEditForm'),
                    'rincianBiayaSatu' => $validation->getError('rincianBiayaAddEditForm[]'),
                    'jumlahSatu' => $validation->getError('jumlahAddEditForm[]'),
                    'buktiSatu' => $validation->getError('buktiAddEditForm[]'),
                ],
                'msg' => '',
            ];
        }else{

            $kode_spd = $this->kuitansi->where('kode_spd', $this->request->getVar('noSpdAddEditForm'))->first();

            $image = array();
            if ($imagefile = $this->request->getFiles()) {
                foreach($imagefile['buktiAddEditForm'] as $img) {
                    if ($img->isValid() && ! $img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('uploads/rincian/'.$this->request->getVar('noSpdAddEditForm').'_'.date('d-m-Y').'/', $newName);
                        $image[] = $this->request->getVar('noSpdAddEditForm').'_'.date('d-m-Y').'/'.$newName;
                    } elseif ($img->getName() == NULL) {
                        $newName = '';
                        $image[] = $newName;
                    }
                }
            }

            $a = $this->request->getVar('rincianBiayaAddEditForm[]');
            $b = $this->request->getVar('jumlahAddEditForm[]');
            $c = $image;


            for($i=0;$i<count($a);$i++){
                $detail_array[$i]["rincian_biaya"]=$a[$i];
                $detail_array[$i]["jumlah_biaya"]=$b[$i];
                $detail_array[$i]["bukti_riil"]=$c[$i];
            }
             
            $data = [
                'kode_spd' => $this->db->escapeString($this->request->getVar('noSpdAddEditForm')),
                'rincian_sbuh' => $this->db->escapeString($this->request->getVar('rincianBiayaSpdAddEditForm')),
                'jumlah_uang' => $this->db->escapeString($this->request->getVar('jumlahTotalSpdAddEditForm')),
                'jumlah_total' => $this->db->escapeString($kode_spd['jumlah_uang']+array_sum($b)),
                'awal' =>  $this->db->escapeString($kode_spd['awal']),
                'akhir' =>  $this->db->escapeString($kode_spd['akhir']),
                'yang_menyetujui' => $kode_spd['yang_menyetujui'],
                'bendahara' => $this->session->get('nip'),
                'detail' => json_encode($detail_array, JSON_UNESCAPED_SLASHES),
            ];

            if ($this->rincian->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('bendahara/rincian'));
            } else {
                $data = array('success' => false, 'msg' => $this->rincian->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($data);
    }

    function single_data()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $rincian_id = $this->rincian->where('id', $this->request->getVar('id'))->where('deleted_at', NULL)->get();
        if($rincian_id->getRow() == null){
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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

    function getBukti() {

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $rincian_id = $this->rincian->where('id', $this->request->getVar('id'))->where('deleted_at', NULL)->get();
        if($rincian_id->getRow() == null){
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $data = $this->rincian->where('id', $this->request->getVar('id'))->first();
            $data['json'] = json_decode($data['detail']);
            
            $bukti = array();
            foreach($data['json'] as $key => $json){
                if($key == $this->request->getVar('number')) {
                    foreach($json as $row => $bukti){
                        $result[$row] = $bukti;
                    }
                }
            }

            $result[$this->csrfToken] = $this->csrfHash;
            echo json_encode($result);
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
        if (!$id) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $data = array(
            'title' => 'Edit Rincian',
            'parent' => 2,
            'pmenu' => 2.2,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('bendahara/rincian/v-rincianAddEdit', $data);
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
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $rincian_id = $this->rincian->where('id', $this->request->getVar('hiddenID'))->where('deleted_at', NULL)->get();
        if($rincian_id->getRow() == null){
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('hiddenID')) {
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'noSpdAddEditForm' => [
                'label'     => 'No SPD',
                'rules'     => 'required|numeric|max_length[3]',
                'errors' => [
                    'numeric'       => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length'    => '{field} Maksimal 3 Karakter',
                ],
            ],
            'rincianBiayaSpdAddEditForm' => [
                'label'     => 'Rincian Biaya Uang Harian',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'jumlahTotalSpdAddEditForm' => [
                'label'     => 'Jumlah Total',
                'rules'     => 'required|numeric|max_length[8]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 8 Karakter',
                ]
            ],
            'rincianBiayaAddEditForm[]' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty',
            ],
            'jumlahAddEditForm[]' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty'
            ],
            'buktiAddEditForm[]' => [
                'label' => 'Bukti Riil',
                'rules' => "mime_in[buktiAddEditForm,application/pdf,application/msword,image/jpg,image/jpeg,image/gif,image/png]"
                ."|max_size[buktiAddEditForm,10000]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 10 MB'
                ],
            ],
        ]);

        if (!$valid) {
            /**
             *'kode' => $validation->getError('kodeAddEdit'),
             * 'kode' -> id or class to display error
             * 'kodeAddEdit' -> name field that ajax send
             */
            $data = [
                'error' => [
                    'noSpd' => $validation->getError('noSpdAddEditForm'),
                    'rincianBiayaSpd' => $validation->getError('rincianBiayaSpdAddEditForm'),
                    'jumlahTotalSpd' => $validation->getError('jumlahTotalSpdAddEditForm'),
                ],
                'msg' => '',
            ];
        }else{

            $prop_item = $this->rincian->where('id', $this->request->getVar('hiddenID'))->first();
            $olds = json_decode($prop_item['detail']);

            $image = array();
            if ($imagefile = $this->request->getFiles()) {
                foreach ($imagefile['buktiAddEditForm'] as  $img) {
                    
                    if ($img->isValid() && !$img->hasMoved()) {
                        // foreach($olds as $imgs){

                        //     // var_dump($key.' -- ');
                        //     // die();

                        //     foreach($imgs as $row =>  $content){
                                
                        //         if($row == 'bukti_riil'){
                        //             // var_dump($row.' ---- '.$content);die();
                        //     //         $myArray = explode('/', $content);
                        //     //         if (file_exists("uploads/rincian/".$myArray[0]."/".$myArray[1])) {
                        //     //             unlink("uploads/rincian/".$myArray[0]."/".$myArray[1]);
                        //     //         }
                        //         }
                        //     }
                        // }

                        $newName = $img->getRandomName();
                        $img->move('uploads/rincian/'. $this->request->getVar('noSpdAddEditForm').'_'. date('d-m-Y') . '/', $newName);
                        $image[] = $this->request->getVar('noSpdAddEditForm').'_'.date('d-m-Y') . '/' . $newName;
                    } else {
                        foreach($olds as  $imgs){
                            foreach($imgs as $row =>  $content){
                                if($row == 'bukti_riil' && $content == ""){
                                    $image[] = $content;
                                }
                            }
                        }
                    }
                }
            }

            $a = $this->request->getVar('rincianBiayaAddEditForm[]');
            $b = $this->request->getVar('jumlahAddEditForm[]');
            $c = $image;


            for($i=0;$i<count($a);$i++){
                $detail_array[$i]["rincian_biaya"]=$a[$i];
                $detail_array[$i]["jumlah_biaya"]=$b[$i];
                $detail_array[$i]["bukti_riil"]=$c[$i];
            }

            $kode_spd = $this->kuitansi->where('kode_spd', $this->request->getVar('noSpdAddEditForm'))->first();

            // var_dump(array_sum($b));die();

            $data = [
                'kode_spd' => $this->db->escapeString($this->request->getVar('noSpdAddEditForm')),
                'rincian_sbuh' => $this->db->escapeString($this->request->getVar('rincianBiayaSpdAddEditForm')),
                'jumlah_uang' => $this->db->escapeString($this->request->getVar('jumlahTotalSpdAddEditForm')),
                'jumlah_total' => $this->db->escapeString($kode_spd['jumlah_uang']+array_sum($b)),
                'awal' =>  $this->db->escapeString($kode_spd['awal']),
                'akhir' =>  $this->db->escapeString($kode_spd['akhir']),
                'yang_menyetujui' => $kode_spd['yang_menyetujui'],
                'bendahara' => $this->session->get('nip'),
                'detail' => json_encode($detail_array, JSON_UNESCAPED_SLASHES),
            ];

            // d($data);print_r($data);die();
            $id = $this->request->getVar('hiddenID');
            if ($this->rincian->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('bendahara/rincian'));
            } else {
                $data = array('success' => false, 'msg' => $this->rincian->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
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
        $rincian_id = $this->rincian->where('id', $this->request->getVar('id'))->where('deleted_at', NULL)->get();
        if($rincian_id->getRow() == null){
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $id = $this->request->getVar('id');

            if ($this->rincian->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    public function print($id = null){

        $rincian_id = $this->rincian->where('id', $id)->where('deleted_at', NULL)->get();
        if($rincian_id->getRow() == null){
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
            return redirect()->to(site_url('bendahara/rincian/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
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
        $dompdf->loadHtml(view('bendahara/rincian/p-rincian', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait'); // landscape or portrait

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, array("Attachment" => false));
    }
}
