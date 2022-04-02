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
use App\Libraries\Pdf;
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
                  ->select('id,kode_spd, rincian_sbuh, jumlah_uang, jumlah_total');

        return DataTable::of($builder)
            ->postQuery(function($builder){$builder->orderBy('kode_spd', 'desc');})
            ->format('jumlah_uang', function($value){return 'Rp. '.number_format($value, 0,'','.');})
            ->format('jumlah_total', function($value){return 'Rp. '.number_format($value, 0,'','.');})
            ->setSearchableColumns(['kode_spd', 'nama', 'awal', 'akhir', 'nama_instansi'])
            ->add(null, function($row){
                $button = '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $row->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
                $button .= '<a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="/Bendahara/Rincian/edit/' . $row->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>' ;
                $button .='<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>';
                $button .= '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="/Bendahara/Rincian/generate" target="_blank" name="print" data-id="' . $row->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a>';
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
                ->orderBy('pegawai_diperintah')
                ->findAll(10);
        } else {
            $spdlist = $this->spd->select('id,kode') // Fetch record
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
            $data = $this->kuitansi->where('kode_spd', $this->request->getVar('kode'))->first();

            $instansi = $this->instansi->where('kode', $data['kode_instansi'])->first();
            $data['sbuh'] = $this->sbuh
                            ->where('kode_provinsi', $instansi['kode_provinsi'])
                            ->where('kode_kabupaten', $instansi['kode_kabupaten'])
                            ->where('kode_kecamatan', $instansi['kode_kecamatan'])
                            ->first();

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
                'rules' => "mime_in[buktiAddEditForm,image/jpg,image/jpeg,image/gif,image/png]"
                ."|max_size[buktiAddEditForm,2048]",
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
                        $img->move('uploads/rincian/'.date('d-m-Y').'/', $newName);
                        $image[] = date('d-m-Y').'/'.$newName;
                    } elseif ($img->getName() == NULL) {
                        $newName = '';
                        $image[] = $newName;
                    }
                }
            }

            $data = [
                'kode_spd' => $this->db->escapeString($this->request->getVar('noSpdAddEditForm')),
                'rincian_sbuh' => $this->db->escapeString($this->request->getVar('rincianBiayaSpdAddEditForm')),
                'jumlah_uang' => $this->db->escapeString($this->request->getVar('jumlahTotalSpdAddEditForm')),
                'rincian_biaya' => json_encode(!empty($this->request->getVar('rincianBiayaAddEditForm')) ? ["0"] : $this->request->getVar('rincianBiayaAddEditForm')),
                'jumlah_biaya' => json_encode(!empty($this->request->getVar('jumlahAddEditForm')) ? ["0"] : $this->request->getVar('jumlahAddEditForm')),
                'bukti' => json_encode($image, JSON_UNESCAPED_SLASHES),
                'jumlah_total' => $this->db->escapeString($kode_spd['jumlah_uang']),
                'awal' =>  $this->db->escapeString($kode_spd['awal']),
                'akhir' =>  $this->db->escapeString($kode_spd['akhir']),
                'yang_menyetujui' => $kode_spd['yang_menyetujui'],
                'bendahara' => $this->session->get('nip'),
                // 'detail' => json_encode($detail_array),
            ];

            // d($data);print_r($data);die();

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

        if ($this->request->getVar('id')) {
            $data = $this->rincian->where('id', $this->request->getVar('id'))->first();
            $data['jumlah_biaya'] = json_decode($data['jumlah_biaya']);
            $data['rincian_biaya'] = json_decode($data['rincian_biaya']);
            $data['bukti'] = json_decode($data['bukti']);

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function view_data() {

        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        if ($this->request->getVar('id')) {
            $data = $this->rincian->where('id', $this->request->getVar('id'))->first();
            $data['bendahara'] = $this->pegawai->select(['nama', 'nip'])->where('nip', $data['bendahara'])->first();
            $data['kepala'] = $this->pegawai->select(['nama', 'nip'])->where('nip', $data['yang_menyetujui'])->first();
            $data['jumlah_biaya'] = json_decode($data['jumlah_biaya']);
            $sum = array_reduce( $data['jumlah_biaya'], function($carry, $item){return $carry + $item;});
            $sum = $sum + $data['jumlah_uang'];$data['sum'] = $sum;
            $data['rincian_biaya'] = json_decode($data['rincian_biaya']);
            $data['bukti'] = json_decode($data['bukti']);
            $data['looping'] = array($data['jumlah_biaya'] , $data['rincian_biaya'] , $data['bukti']);

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
                'rules' => "mime_in[buktiAddEditForm,image/jpg,image/jpeg,image/gif,image/png]"
                ."|max_size[buktiAddEditForm,2048]",
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
                ],
                'msg' => '',
            ];
        }else{

            $prop_item = $this->rincian->where('id', $this->request->getVar('hiddenID'))->first();
            // $olds = $prop_item['bukti'];
            // $file = $this->request->getFile('buktiSatuAddEditForm');
            // if($file->isValid() && !$file->hasMoved()){
            //     if(file_exists("uploads/rincian/".date('d-m-Y')."/".$old_image)){
            //         unlink("uploads/rincian/".date('d-m-Y')."/".$old_image);
            //     }
            //     $imageName = $file->getRandomName();
            //     $file->move('uploads/rincian/'.date('d-m-Y')."/", $imageName);
            // }else{
            //     $imageName = $old_image;
            // }
            // foreach($olds as $old){
                // d(json_decode($prop_item['bukti']));print(json_decode($prop_item['bukti']));die();
                // dd(json_decode($prop_item['bukti']));
            // }
            // die();
            // foreach(json_decode($prop_item['bukti']) as $old){
            //     if(file_exists("uploads/rincian/".$old)){
            //         // unlink("uploads/rincian/".$old);
            //         d($old);print($old);die();
            //     }
            // }
            $image = array();
            if ($imagefile = $this->request->getFiles()) {
                foreach ($imagefile['buktiAddEditForm'] as $img) {
                    if ($img->isValid() && !$img->hasMoved()) {
                        foreach (json_decode($prop_item['bukti']) as $old) {
                            // d( unlink("uploads/rincian/". $old));print( unlink("uploads/rincian/". $old));die();
                            if (file_exists("uploads/rincian/".$old)) {
                                unlink("uploads/rincian/". $old);
                                // rmdir("uploads/rincian/". $old);
                                // d("uploads/rincian/" . $old);print("uploads/rincian/" . $old);
                            }
                        }

                        // d("OK");print_r("ok");die();
                        $newName = $img->getRandomName();
                        $img->move('uploads/rincian/' . date('d-m-Y') . '/', $newName);
                        $image[] = date('d-m-Y') . '/' . $newName;
                    } else {
                        foreach (json_decode($prop_item['bukti']) as $old) {
                            $newName = $old;
                        }
                        $image[] = $newName;
                    }
                }
            }

            $kode_spd = $this->kuitansi->where('kode_spd', $this->request->getVar('noSpdAddEditForm'))->first();

            $data = [
                'kode_spd' => $this->db->escapeString($this->request->getVar('noSpdAddEditForm')),
                'rincian_sbuh' => $this->db->escapeString($this->request->getVar('rincianBiayaSpdAddEditForm')),
                'jumlah_uang' => $this->db->escapeString($this->request->getVar('jumlahTotalSpdAddEditForm')),
                'rincian_biaya' => json_encode($this->request->getVar('rincianBiayaAddEditForm')),
                'jumlah_biaya' => json_encode($this->request->getVar('jumlahAddEditForm')),
                'bukti' => json_encode($image, JSON_UNESCAPED_SLASHES),
                'jumlah_total' => $this->db->escapeString($kode_spd['jumlah_uang']),
                'awal' =>  $this->db->escapeString($kode_spd['awal']),
                'akhir' =>  $this->db->escapeString($kode_spd['akhir']),
                'yang_menyetujui' => $kode_spd['yang_menyetujui'],
                'bendahara' => $this->session->get('nip'),
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
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
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
}
