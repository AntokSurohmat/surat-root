<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\PegawaiModel;
use App\Models\Admin\InstansiModel;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Admin\WilayahModel;
use App\Models\Admin\RekeningModel;
use App\Models\Admin\SpdModel;

use CodeIgniter\HTTP\IncomingRequest;


/**
 * @property IncomingRequest $request
*/

class Spd extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text'];
    public function __construct()
    {
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
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        $data = array(
            'title' => 'SURAT PERJALAN DINAS',
            'parent' => 3,
            'pmenu' => 3.2
        );
        return view('admin/spd/v-spd', $data);
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
                if ($pega->nip == $key->pejabat) {
                    $row[] =  $pega->nama;
                }
            };
            $row[] = $key->pegawai_all;
            $row[] = $key->untuk;
            $row[] = $key->jenis_kendaraan;
            $row[] = $key->keterangan;

            $button = $key->status == 'false' ? '<a class="btn btn-xs btn-primary mr-1 mb-1 print" href="/Admin/spd/new/' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Create Data ]"><i class="fas fa-plus text-white"></i></a>' : '' ;
            $button .= '<a type="button" class="btn btn-xs btn-info mr-1 mb-1 view" href="javascript:void(0)" name="view" data-id="'. $key->id .'" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Detail Data ]"><i class="fas fa-eye text-white"></i></a>';
            $button .= $key->status == 'true' ? '<a type="button" class="btn btn-xs btn-warning mr-1 mb-1" href="/Admin/spd/edit/' . $key->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>' : '' ;
            $button .='<a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>';
            $button .= $key->status == 'true' ? '<a class="btn btn-xs btn-success mr-1 mb-1 print" href="javascript:void(0)" name="print" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Data ]"><i class="fas fa-print text-white"></i></a><a class="btn btn-xs btn-secondary mr-1 mb-1 print" href="javascript:void(0)" name="print" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Print Detail Only ]"><i class="fas fa-file-alt text-white"></i></a>' : '' ;
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

    public function getPegawai()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        $pegawailist = $this->spd->select('pegawai_all')->first();

        $data = array();
        $nama = $this->pegawai->whereIn('nip', json_decode($pegawailist['pegawai_all']))->get();
        foreach (array_combine(json_decode($pegawailist['pegawai_all']), $nama->getResultArray())  as $pegawai => $nama) {
            $data[] = array(
                "id" => $pegawai,
                "text" => $nama['nama'],
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
        //
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new($id = null)
    {
        $data = array(
            'title' => 'Tambah Data Surat Perjalanan Dinas',
            'parent' => 3,
            'pmenu' => 3.2,
            'method' => 'New',
            'hiddenID' => $id,
        );
        return view('admin/spd/v-spdAddEdit', $data);
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
            exit('No direct script is allowed');
        }

        // d($this->request->getVar('pegawaiAddEditForm'));print_r($this->request->getVar('pegawaiAddEditForm'));die();

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodeAddEditForm' => [
                'label'     => 'No SPT',
                'rules'     => 'required|numeric|max_length[3]',
                'errors' => [
                    'numeric'       => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length'    => '{field} Maksimal 3 Karakter',
                ],
            ],
            'diperintahAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'pegawaiAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'tingkatBiayaAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[10]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 10 Karakter'
                ]
            ],
            'untukAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'instansiAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 20 Karakter'
                ]
            ],
            'startAddEditForm' => [
                'label'     => 'Tanggal Pergi',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'endAddEditForm'   => [
                'label'     => 'Tanggal Kembali',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'lamaAddEditForm'  => [
                'label'     => 'Lama Perjalanan',
                'rules'     => 'required|numeric|max_length[2]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 2 Karakter',
                ]
            ],
            'rekeningAddEditForm'  => [
                'label'     => 'Lama Perjalanan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'keteranganAddEditForm'  => [
                'label'     => 'keterangan',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'kendaraanAddEditForm'  => [
                'label'     => 'Jenis Kendaraan',
                'rules'     => 'required',
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
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'diperintah' => $validation->getError('diperintahAddEditForm[]'),
                    'pegawai' => $validation->getError('pegawaiAddEditForm'),
                    'tingkatBiaya' => $validation->getError('tingkatBiayaAddEditForm'),
                    'untuk' => $validation->getError('untukAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                    'start' => $validation->getError('startAddEditForm'),
                    'end' => $validation->getError('endAddEditForm'),
                    'lama' => $validation->getError('lamaAddEditForm'),
                    'rekening' => $validation->getError('rekeningAddEditForm'),
                    'keterangan' => $validation->getError('keteranganAddEditForm'),
                    'kendaraan' => $validation->getError('kendaraanAddEditForm'),
                ],
                'msg' => '',
            ];
        }else{

            $detail_array = array(
                "first" => array(
                    "tibadi" => $this->request->getVar('tibadiAddEditFirst'),
                    "tanggaltiba" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalTibaAddEditFormFirst')))),
                    "kepalatiba" => $this->request->getVar('kepalaTibaAddEditFormFirst'),
                    "berangkatdari" => $this->request->getVar('berangkatAddEditFormFirst'),
                    "tujuan" => $this->request->getVar('tujuanAddEditFormFirst'),
                    "tanggalberangkat" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalBerangkatAddEditFormFirst')))),
                    "kepalaberangkat" => $this->request->getVar('kepalaBerangkatAddEditFormFirst'),
                ),
                "second" => array(
                    "tibadi" => $this->request->getVar('tibadiAddEditSecond'),
                    "tanggaltiba" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalTibaAddEditFormSecond')))),
                    "kepalatiba" => $this->request->getVar('kepalaTibaAddEditFormSecond'),
                    "berangkatdari" => $this->request->getVar('berangkatAddEditFormSecond'),
                    "tujuan" => $this->request->getVar('tujuanAddEditFormSecond'),
                    "tanggalberangkat" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalBerangkatAddEditFormSecond')))),
                    "kepalaberangkat" => $this->request->getVar('kepalaBerangkatAddEditFormSecond'),
                ),
                "third" => array(
                    "tibadi" => $this->request->getVar('tibadiAddEditThird'),
                    "tanggaltiba" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalTibaAddEditFormThrid')))),
                    "kepalatiba" => $this->request->getVar('kepalaTibaAddEditFormThird'),
                    "berangkatdari" => $this->request->getVar('berangkatAddEditFormThird'),
                    "tujuan" => $this->request->getVar('tujuanAddEditFormThird'),
                    "tanggalberangkat" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalBerangkatAddEditFormThird')))),
                    "kepalaberangkat" => $this->request->getVar('kepalaBerangkatAddEditFormThird'),
                ),
                "fourth" => array(
                    "tibadi" => $this->request->getVar('tibadiAddEditFourth'),
                    "tanggaltiba" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalTibaAddEditFormFourth')))),
                    "kepalatiba" => $this->request->getVar('kepalaTibaAddEditFormFourth'),
                    "berangkatdari" => $this->request->getVar('berangkatAddEditFormFourth'),
                    "tujuan" => $this->request->getVar('tujuanAddEditFormFourth'),
                    "tanggalberangkat" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalBerangkatAddEditFormFourth')))),
                    "kepalaberangkat" => $this->request->getVar('kepalaBerangkatAddEditFormFourth'),
                )
            );

            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'pejabat' => $this->pegawai->select('nip')->where('nama', $this->request->getVar('diperintahAddEditForm'))->first(),
                'pegawai_diperintah' => $this->db->escapeString($this->request->getVar('pegawaiAddEditForm')),
                'untuk' => $this->db->escapeString($this->request->getVar('untukAddEditForm')),
                'kode_instansi' => $this->instansi->select('kode')->where('nama_instansi', $this->request->getVar('instansiAddEditForm'))->first(),
                'awal' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('startAddEditForm')))),
                'akhir' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('endAddEditForm')))),
                'kode_rekening' => $this->rekening->select('kode')->where('nomer_rekening', $this->request->getVar('rekeningAddEditForm'))->first(),
                'lama' => $this->db->escapeString($this->request->getVar('lamaAddEditForm')),
                'keterangan' => $this->db->escapeString($this->request->getVar('keteranganAddEditForm')),
                'jenis_kendaraan' => $this->db->escapeString($this->request->getVar('kendaraanAddEditForm')),
                'detail' => json_encode($detail_array),
                'status' => 'true',

            ];
            $id = $this->request->getVar('hiddenID');
            if ($this->spd->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/spd'));
            } else {
                $data = array('success' => false, 'msg' => $this->spt->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }

        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($data);

    }

    function view_data() {

        if ($this->request->getVar('id')) {
            $data = $this->spd->where('id', $this->request->getVar('id'))->first();

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
            echo json_encode($data);
        }
    }

    function new_update() {
        if ($this->request->getVar('id')) {
            $data = $this->spd->where('id', $this->request->getVar('id'))->first();

            $data['pegawai'] = $this->pegawai->where('nip', $data['pejabat'])->first();
            $instansi = $this->instansi->where('kode', $data['kode_instansi'])->first();

            $wilayah = $this->wilayah->select('kode_jenis_wilayah')->where(['kode_provinsi' => $instansi['kode_provinsi'], 'kode_kabupaten' => $instansi['kode_kabupaten']])->first();

            $data['rekening'] = $this->rekening->select('nomer_rekening')->where('kode_jenis_wilayah', $wilayah)->first();

            $data['instansi'] = $instansi;
            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }

    function real_update() {
        if ($this->request->getVar('id')) {
            $data = $this->spd->where('id', $this->request->getVar('id'))->first();

            $data['diperintah'] = $this->pegawai->where('nip', $data['pejabat'])->first();
            $data['pegawai'] = $this->pegawai->where('nip', $data['pegawai_diperintah'])->first();
            $data['instansi'] = $this->instansi->select('nama_instansi')->where('kode', $data['kode_instansi'])->first();
            $data['rekening'] = $this->rekening->select('nomer_rekening')->where('kode', $data['kode_rekening'])->first();
            $data['json'] = json_decode($data['detail'], true);
            // d(json_decode($data['detail']));print_r(json_decode($data['detail']));die();
            // d($data['json']);print_r($data['json']);die();

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
            // throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            return redirect()->to(site_url('admin/spd/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = array(
            'title' => 'Edit Data Surat Perjalanan Dinas',
            'parent' => 3,
            'pmenu' => 3.2,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('admin/spd/v-spdAddEdit', $data);
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
            exit('No direct script is allowed');
        }

        // d($this->request->getVar('pegawaiAddEditForm'));print_r($this->request->getVar('pegawaiAddEditForm'));die();

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodeAddEditForm' => [
                'label'     => 'No SPT',
                'rules'     => 'required|numeric|max_length[3]',
                'errors' => [
                    'numeric'       => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length'    => '{field} Maksimal 3 Karakter',
                ],
            ],
            'diperintahAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'pegawaiAddEditForm' => [
                'label'     => 'Pegawai Yang diperintah',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 20 Karakter',
                ]
            ],
            'tingkatBiayaAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[10]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 10 Karakter'
                ]
            ],
            'untukAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'instansiAddEditForm' => [
                'label'     => 'Maksud Perjalan Dinas',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 20 Karakter'
                ]
            ],
            'startAddEditForm' => [
                'label'     => 'Tanggal Pergi',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'endAddEditForm'   => [
                'label'     => 'Tanggal Kembali',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'lamaAddEditForm'  => [
                'label'     => 'Lama Perjalanan',
                'rules'     => 'required|numeric|max_length[2]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 2 Karakter',
                ]
            ],
            'rekeningAddEditForm'  => [
                'label'     => 'Lama Perjalanan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'keteranganAddEditForm'  => [
                'label'     => 'keterangan',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'kendaraanAddEditForm'  => [
                'label'     => 'Jenis Kendaraan',
                'rules'     => 'required',
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
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'diperintah' => $validation->getError('diperintahAddEditForm[]'),
                    'pegawai' => $validation->getError('pegawaiAddEditForm'),
                    'tingkatBiaya' => $validation->getError('tingkatBiayaAddEditForm'),
                    'untuk' => $validation->getError('untukAddEditForm'),
                    'instansi' => $validation->getError('instansiAddEditForm'),
                    'start' => $validation->getError('startAddEditForm'),
                    'end' => $validation->getError('endAddEditForm'),
                    'lama' => $validation->getError('lamaAddEditForm'),
                    'rekening' => $validation->getError('rekeningAddEditForm'),
                    'keterangan' => $validation->getError('keteranganAddEditForm'),
                    'kendaraan' => $validation->getError('kendaraanAddEditForm'),
                ],
                'msg' => '',
            ];
        }else{

            $detail_array = array(
                "first" => array(
                    "tibadi" => $this->request->getVar('tibadiAddEditFirst'),
                    "tanggaltiba" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalTibaAddEditFormFirst')))),
                    "kepalatiba" => $this->request->getVar('kepalaTibaAddEditFormFirst'),
                    "berangkatdari" => $this->request->getVar('berangkatAddEditFormFirst'),
                    "tujuan" => $this->request->getVar('tujuanAddEditFormFirst'),
                    "tanggalberangkat" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalBerangkatAddEditFormFirst')))),
                    "kepalaberangkat" => $this->request->getVar('kepalaBerangkatAddEditFormFirst'),
                ),
                "second" => array(
                    "tibadi" => $this->request->getVar('tibadiAddEditSecond'),
                    "tanggaltiba" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalTibaAddEditFormSecond')))),
                    "kepalatiba" => $this->request->getVar('kepalaTibaAddEditFormSecond'),
                    "berangkatdari" => $this->request->getVar('berangkatAddEditFormSecond'),
                    "tujuan" => $this->request->getVar('tujuanAddEditFormSecond'),
                    "tanggalberangkat" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalBerangkatAddEditFormSecond')))),
                    "kepalaberangkat" => $this->request->getVar('kepalaBerangkatAddEditFormSecond'),
                ),
                "third" => array(
                    "tibadi" => $this->request->getVar('tibadiAddEditThird'),
                    "tanggaltiba" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalTibaAddEditFormThrid')))),
                    "kepalatiba" => $this->request->getVar('kepalaTibaAddEditFormThird'),
                    "berangkatdari" => $this->request->getVar('berangkatAddEditFormThird'),
                    "tujuan" => $this->request->getVar('tujuanAddEditFormThird'),
                    "tanggalberangkat" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalBerangkatAddEditFormThird')))),
                    "kepalaberangkat" => $this->request->getVar('kepalaBerangkatAddEditFormThird'),
                ),
                "fourth" => array(
                    "tibadi" => $this->request->getVar('tibadiAddEditFourth'),
                    "tanggaltiba" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalTibaAddEditFormFourth')))),
                    "kepalatiba" => $this->request->getVar('kepalaTibaAddEditFormFourth'),
                    "berangkatdari" => $this->request->getVar('berangkatAddEditFormFourth'),
                    "tujuan" => $this->request->getVar('tujuanAddEditFormFourth'),
                    "tanggalberangkat" => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('tanggalBerangkatAddEditFormFourth')))),
                    "kepalaberangkat" => $this->request->getVar('kepalaBerangkatAddEditFormFourth'),
                )
            );

            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'pejabat' => $this->pegawai->select('nip')->where('nama', $this->request->getVar('diperintahAddEditForm'))->first(),
                'pegawai_diperintah' => $this->db->escapeString($this->request->getVar('pegawaiAddEditForm')),
                'untuk' => $this->db->escapeString($this->request->getVar('untukAddEditForm')),
                'kode_instansi' => $this->instansi->select('kode')->where('nama_instansi', $this->request->getVar('instansiAddEditForm'))->first(),
                'awal' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('startAddEditForm')))),
                'akhir' => date("Y-m-d", strtotime(str_replace('/', '-',$this->request->getVar('endAddEditForm')))),
                'kode_rekening' => $this->rekening->select('kode')->where('nomer_rekening', $this->request->getVar('rekeningAddEditForm'))->first(),
                'lama' => $this->db->escapeString($this->request->getVar('lamaAddEditForm')),
                'keterangan' => $this->db->escapeString($this->request->getVar('keteranganAddEditForm')),
                'jenis_kendaraan' => $this->db->escapeString($this->request->getVar('kendaraanAddEditForm')),
                'detail' => json_encode($detail_array),
                'status' => 'true',

            ];
            $id = $this->request->getVar('hiddenID');
            if ($this->spd->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/spd'));
            } else {
                $data = array('success' => false, 'msg' => $this->spt->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
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

            if ($this->spd->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
}
