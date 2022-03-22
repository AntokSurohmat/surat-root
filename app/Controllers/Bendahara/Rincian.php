<?php

namespace App\Controllers\Bendahara;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\SpdModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\SbuhModel;
use App\Models\Admin\RekeningModel;
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
            //Satu
            'rincianBiayaSatuAddEditForm' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahSatuAddEditForm' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|max_length[8]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 8'
                ]
            ],
            'buktiSatuAddEditForm' => [
                'rules' => "mime_in[buktiSatuAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[buktiSatuAddEditForm,2048]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
            ],
            //Dua
            'rincianBiayaDuaAddEditForm' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahDuaAddEditForm' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|max_length[8]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 8'
                ]
            ],
            'buktiDuaAddEditForm' => [
                'label' => 'Bukti Riil',
                'rules' => "mime_in[buktiDuaAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[buktiDuaAddEditForm,2048]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
            ],
            //Tiga
            'rincianBiayaTigaAddEditForm' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahTigaAddEditForm' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|max_length[8]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 8'
                ]
            ],
            'buktiTigaAddEditForm' => [
                'label' => 'Bukti Riil',
                'rules' => "mime_in[buktiTigaAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[buktiTigaAddEditForm,2048]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
            ],
            //Empat
            'rincianBiayaEmpatAddEditForm' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahEmpatAddEditForm' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|max_length[8]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 8'
                ]
            ],
            'buktiEmpatAddEditForm' => [
                'label' => 'Bukti Riil',
                'rules' => "mime_in[buktiEmpatAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[buktiEmpatAddEditForm,2048]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
            ],
            //Lima
            'rincianBiayaLimaAddEditForm' => [
                'label'     => 'Rincian Biaya',
                'rules'     => "permit_empty|max_length[25]",
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahLimaAddEditForm' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => "permit_empty|max_length[8]",
                'errors'    => [
                    'max_length'    => '{field} Maksimal 8'
                ]
            ],
            'buktiLimaAddEditForm' => [
                'label' => 'Bukti Riil',
                'rules' => "mime_in[buktiLimaAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[buktiLimaAddEditForm,2048]",
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
                    'rincianBiayaSatu' => $validation->getError('rincianBiayaSatuAddEditForm'),
                    'jumlahSatu' => $validation->getError('jumlahSatuAddEditForm'),
                    'buktiSatu' => $validation->getError('buktiSatuAddEditForm'),
                    'rincianBiayaDua' => $validation->getError('rincianBiayaDuaAddEditForm'),
                    'jumlahDua' => $validation->getError('jumlahDuaAddEditForm'),
                    'buktiDua' => $validation->getError('buktiDuaAddEditForm'),
                    'rincianBiayaTiga' => $validation->getError('rincianBiayaTigaAddEditForm'),
                    'jumlahTiga' => $validation->getError('jumlahTigaAddEditForm'),
                    'buktiTiga' => $validation->getError('buktiTigaAddEditForm'),
                    'rincianBiayaEmpat' => $validation->getError('rincianBiayaEmpatAddEditForm'),
                    'jumlahEmpat' => $validation->getError('jumlahEmpatAddEditForm'),
                    'buktiEmpat' => $validation->getError('buktiEmpatAddEditForm'),
                    'rincianBiayaLima' => $validation->getError('rincianBiayaLimaAddEditForm'),
                    'jumlahLima' => $validation->getError('jumlahLimaAddEditForm'),
                    'buktiLima' => $validation->getError('buktiLimaAddEditForm'),
                ],
                'msg' => '',
            ];
        }else{


            $buktiSatu = $this->request->getFile('buktiSatuAddEditForm');
            if($buktiSatu->isValid() && !$buktiSatu->hasMoved()){
                $imageName_1 = $buktiSatu->getRandomName();
                $buktiSatu->move('uploads/rincian/'.date('d-m-Y').'/', $imageName_1);
            }
            $buktiDua = $this->request->getFile('buktiDuaAddEditForm');
            if($buktiDua->isValid() && !$buktiDua->hasMoved()){
                $imageName_2 = $buktiDua->getRandomName();
                $buktiDua->move('uploads/rincian/'.date('d-m-Y').'/', $imageName_2);
            }
            $buktiTiga = $this->request->getFile('buktiTigaAddEditForm');
            if($buktiTiga->isValid() && !$buktiTiga->hasMoved()){
                $imageName_3 = $buktiTiga->getRandomName();
                $buktiTiga->move('uploads/rincian/'.date('d-m-Y').'/', $imageName_3);
            }
            $buktiEmpat = $this->request->getFile('buktiEmpatAddEditForm');
            if($buktiEmpat->isValid() && !$buktiEmpat->hasMoved()){
                $imageName_4 = $buktiEmpat->getRandomName();
                $buktiEmpat->move('uploads/rincian/'.date('d-m-Y').'/', $imageName_4);
            }
            $buktiLima = $this->request->getFile('buktiLimaAddEditForm');
            if($buktiLima->isValid() && !$buktiLima->hasMoved()){
                $imageName_5 = $buktiLima->getRandomName();
                $buktiLima->move('uploads/rincian/'.date('d-m-Y').'/', $imageName_5);
            }

            $kode_spd = $this->kuitansi->where('kode_spd', $this->request->getVar('noSpdAddEditForm'))->first();
            // $pegawai_all =  $this->spd->select('pegawai_all')->where('id', $this->request->getVar('noSpdAddEditForm'))->first();
            // $pangol = $this->pegawai->select('kode_pangol')->where('nip', $this->request->getVar('namaPegawaiAddEditForm'))->first();
            // $jabatan = $this->pegawai->select('kode_jabatan')->where('nip', $this->request->getVar('namaPegawaiAddEditForm'))->first();
            // $instansi = $this->spd->select('kode_instansi')->where('id', $this->request->getVar('noSpdAddEditForm'))->first();

            $data = [
                'kode_spd' => $this->db->escapeString($this->request->getVar('noSpdAddEditForm')),
                'rincian_sbuh' => $this->db->escapeString($this->request->getVar('rincianBiayaSpdAddEditForm')),
                'jumlah_uang' => $this->db->escapeString($this->request->getVar('jumlahTotalSpdAddEditForm')),
                //satu
                'rincian_biaya_1' => $this->db->escapeString($this->request->getVar('rincianBiayaSatuAddEditForm')),
                'jumlah_biaya_1' => $this->db->escapeString($this->request->getVar('jumlahSatuAddEditForm')),
                'bukti_1' => ($this->request->getFile('buktiSatuAddEditForm') != NULL ? $imageName_1 : ''),
                //dua
                'rincian_biaya_2' => $this->db->escapeString($this->request->getVar('rincianBiayaDuaAddEditForm')),
                'jumlah_biaya_2' => $this->db->escapeString($this->request->getVar('jumlahDuaAddEditForm')),
                'bukti_2' => ($this->request->getFile('buktiDuaAddEditForm') != NULL ? $imageName_2 : ''),
                //tiga
                'rincian_biaya_3' => $this->db->escapeString($this->request->getVar('rincianBiayaTigaAddEditForm')),
                'jumlah_biaya_3' => $this->db->escapeString($this->request->getVar('jumlahTigaAddEditForm')),
                'bukti_3' => ($this->request->getFile('buktiTigaAddEditForm') != NULL ? $imageName_3 : ''),
                //empat
                'rincian_biaya_4' => $this->db->escapeString($this->request->getVar('rincianBiayaEmpatAddEditForm')),
                'jumlah_biaya_4' => $this->db->escapeString($this->request->getVar('jumlahEmpatAddEditForm')),
                'bukti_4' => ($this->request->getFile('buktiEmpatAddEditForm') != NULL ? $imageName_4 : ''),
                //lima
                'rincian_biaya_5' => $this->db->escapeString($this->request->getVar('rincianBiayaLimaAddEditForm')),
                'jumlah_biaya_5' => $this->db->escapeString($this->request->getVar('jumlahLimaAddEditForm')),
                'bukti_5' => ($this->request->getFile('buktiLimaAddEditForm') != NULL ? $imageName_5 : ''),

                'jumlah_total' => $this->db->escapeString($kode_spd['jumlah_uang']),
                'awal' =>  $this->db->escapeString($kode_spd['awal']),
                'akhir' =>  $this->db->escapeString($kode_spd['akhir']),
                'yang_menyetujui' => $kode_spd['yang_menyetujui'],
                'bendahara' => $this->session->get('nip'),
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

        if ($this->request->getVar('id')) {
            $data = $this->rincian->where('id', $this->request->getVar('id'))->first();

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
            //Satu
            'rincianBiayaSatuAddEditForm' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahSatuAddEditForm' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|max_length[8]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 8'
                ]
            ],
            'buktiSatuAddEditForm' => [
                'rules' => "mime_in[buktiSatuAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[buktiSatuAddEditForm,2048]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
            ],
            //Dua
            'rincianBiayaDuaAddEditForm' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahDuaAddEditForm' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|max_length[8]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 8'
                ]
            ],
            'buktiDuaAddEditForm' => [
                'label' => 'Bukti Riil',
                'rules' => "mime_in[buktiDuaAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[buktiDuaAddEditForm,2048]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
            ],
            //Tiga
            'rincianBiayaTigaAddEditForm' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahTigaAddEditForm' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|max_length[8]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 8'
                ]
            ],
            'buktiTigaAddEditForm' => [
                'label' => 'Bukti Riil',
                'rules' => "mime_in[buktiTigaAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[buktiTigaAddEditForm,2048]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
            ],
            //Empat
            'rincianBiayaEmpatAddEditForm' => [
                'label'     => 'Rincian Biaya',
                'rules'     => 'permit_empty|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahEmpatAddEditForm' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => 'permit_empty|max_length[8]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 8'
                ]
            ],
            'buktiEmpatAddEditForm' => [
                'label' => 'Bukti Riil',
                'rules' => "mime_in[buktiEmpatAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[buktiEmpatAddEditForm,2048]",
				'errors' => [
					'mime_in' => 'File Extention Harus Berupa jpg,jpeg,gif,png',
					'max_size' => 'Ukuran File Maksimal 2 MB'
                ],
            ],
            //Lima
            'rincianBiayaLimaAddEditForm' => [
                'label'     => 'Rincian Biaya',
                'rules'     => "permit_empty|max_length[25]",
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahLimaAddEditForm' => [
                'label'     => 'Jumlah Rincian',
                'rules'     => "permit_empty|max_length[8]",
                'errors'    => [
                    'max_length'    => '{field} Maksimal 8'
                ]
            ],
            'buktiLimaAddEditForm' => [
                'label' => 'Bukti Riil',
                'rules' => "mime_in[buktiLimaAddEditForm,image/jpg,image/jpeg,image/gif,image/png]|max_size[buktiLimaAddEditForm,2048]",
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
                    'rincianBiayaSatu' => $validation->getError('rincianBiayaSatuAddEditForm'),
                    'jumlahSatu' => $validation->getError('jumlahSatuAddEditForm'),
                    'buktiSatu' => $validation->getError('buktiSatuAddEditForm'),
                    'rincianBiayaDua' => $validation->getError('rincianBiayaDuaAddEditForm'),
                    'jumlahDua' => $validation->getError('jumlahDuaAddEditForm'),
                    'buktiDua' => $validation->getError('buktiDuaAddEditForm'),
                    'rincianBiayaTiga' => $validation->getError('rincianBiayaTigaAddEditForm'),
                    'jumlahTiga' => $validation->getError('jumlahTigaAddEditForm'),
                    'buktiTiga' => $validation->getError('buktiTigaAddEditForm'),
                    'rincianBiayaEmpat' => $validation->getError('rincianBiayaEmpatAddEditForm'),
                    'jumlahEmpat' => $validation->getError('jumlahEmpatAddEditForm'),
                    'buktiEmpat' => $validation->getError('buktiEmpatAddEditForm'),
                    'rincianBiayaLima' => $validation->getError('rincianBiayaLimaAddEditForm'),
                    'jumlahLima' => $validation->getError('jumlahLimaAddEditForm'),
                    'buktiLima' => $validation->getError('buktiLimaAddEditForm'),
                ],
                'msg' => '',
            ];
        }else{

            $prop_item = $this->rincian->where('id', $this->request->getVar('hiddenID'))->first();
            $old_image_1 = $prop_item['bukti_1'];
            $file = $this->request->getFile('buktiSatuAddEditForm');
            if($file->isValid() && !$file->hasMoved()){
                if(file_exists("uploads/rincian/".date('d-m-Y')."/".$old_image_1)){
                    unlink("uploads/rincian/".date('d-m-Y')."/".$old_image_1);
                }
                $imageName_1 = $file->getRandomName();
                $file->move('uploads/rincian/'.date('d-m-Y')."/", $imageName_1);
            }else{
                $imageName_1 = $old_image_1;
            }

            $old_image_2 = $prop_item['bukti_2'];
            $file = $this->request->getFile('buktiDuaAddEditForm');
            if($file->isValid() && !$file->hasMoved()){
                if(file_exists("uploads/rincian/".date('d-m-Y')."/".$old_image_2)){
                    unlink("uploads/rincian/".date('d-m-Y')."/".$old_image_2);
                }
                $imageName_2 = $file->getRandomName();
                $file->move('uploads/rincian/'.date('d-m-Y')."/", $imageName_2);
            }else{
                $imageName_2 = $old_image_2;
            }

            $old_image_3 = $prop_item['bukti_3'];
            $file = $this->request->getFile('buktiTigaAddEditForm');
            if($file->isValid() && !$file->hasMoved()){
                if(file_exists("uploads/rincian/".date('d-m-Y')."/".$old_image_3)){
                    unlink("uploads/rincian/".date('d-m-Y')."/".$old_image_3);
                }
                $imageName_3 = $file->getRandomName();
                $file->move('uploads/rincian/'.date('d-m-Y')."/", $imageName_3);
            }else{
                $imageName_3 = $old_image_3;
            }

            $old_image_4 = $prop_item['bukti_4'];
            $file = $this->request->getFile('buktiEmpatAddEditForm');
            if($file->isValid() && !$file->hasMoved()){
                if(file_exists("uploads/rincian/".date('d-m-Y')."/".$old_image_4)){
                    unlink("uploads/rincian/".date('d-m-Y')."/".$old_image_4);
                }
                $imageName_4 = $file->getRandomName();
                $file->move('uploads/rincian/'.date('d-m-Y')."/", $imageName_4);
            }else{
                $imageName_4 = $old_image_4;
            }

            $old_image_5 = $prop_item['bukti_5'];
            $file = $this->request->getFile('buktiLimaAddEditForm');
            if($file->isValid() && !$file->hasMoved()){
                if(file_exists("uploads/rincian/".date('d-m-Y')."/".$old_image_5)){
                    unlink("uploads/rincian/".date('d-m-Y')."/".$old_image_5);
                }
                $imageName_5 = $file->getRandomName();
                $file->move('uploads/rincian/'.date('d-m-Y')."/", $imageName_5);
            }else{
                $imageName_5 = $old_image_5;
            }

            $kode_spd = $this->kuitansi->where('kode_spd', $this->request->getVar('noSpdAddEditForm'))->first();

            $data = [
                'kode_spd' => $this->db->escapeString($this->request->getVar('noSpdAddEditForm')),
                'rincian_sbuh' => $this->db->escapeString($this->request->getVar('rincianBiayaSpdAddEditForm')),
                'jumlah_uang' => $this->db->escapeString($this->request->getVar('jumlahTotalSpdAddEditForm')),
                //satu
                'rincian_biaya_1' => $this->db->escapeString($this->request->getVar('rincianBiayaSatuAddEditForm')),
                'jumlah_biaya_1' => $this->db->escapeString($this->request->getVar('jumlahSatuAddEditForm')),
                'bukti_1' => ($this->request->getFile('buktiSatuAddEditForm') != NULL ? $imageName_1 : ''),
                //dua
                'rincian_biaya_2' => $this->db->escapeString($this->request->getVar('rincianBiayaDuaAddEditForm')),
                'jumlah_biaya_2' => $this->db->escapeString($this->request->getVar('jumlahDuaAddEditForm')),
                'bukti_2' => ($this->request->getFile('buktiDuaAddEditForm') != NULL ? $imageName_2 : ''),
                //tiga
                'rincian_biaya_3' => $this->db->escapeString($this->request->getVar('rincianBiayaTigaAddEditForm')),
                'jumlah_biaya_3' => $this->db->escapeString($this->request->getVar('jumlahTigaAddEditForm')),
                'bukti_3' => ($this->request->getFile('buktiTigaAddEditForm') != NULL ? $imageName_3 : ''),
                //empat
                'rincian_biaya_4' => $this->db->escapeString($this->request->getVar('rincianBiayaEmpatAddEditForm')),
                'jumlah_biaya_4' => $this->db->escapeString($this->request->getVar('jumlahEmpatAddEditForm')),
                'bukti_4' => ($this->request->getFile('buktiEmpatAddEditForm') != NULL ? $imageName_4 : ''),
                //lima
                'rincian_biaya_5' => $this->db->escapeString($this->request->getVar('rincianBiayaLimaAddEditForm')),
                'jumlah_biaya_5' => $this->db->escapeString($this->request->getVar('jumlahLimaAddEditForm')),
                'bukti_5' => ($this->request->getFile('buktiLimaAddEditForm') != NULL ? $imageName_5 : ''),

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
            exit('No direct script is allowed');
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
