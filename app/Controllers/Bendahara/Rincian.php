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

        // $response['count'] = $count;
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
            'nipAddEditForm' => [
                'label'     => 'NIP Pegawai',
                'rules'     => 'required|numeric|max_length[25]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 25 Karakter',
                ]
            ],
            'namaAddEditForm' => [
                'label'     => 'Nama Pegawai',
                'rules'     => 'required|max_length[25]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'pangkatAddEditForm' => [
                'label'     => 'Pangkat & Golongan Pegawai',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'jabatanAddEditForm' => [
                'label'     => 'Jabatan Pegawai',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length'    => '{field} Maksimal 50 Karakter'
                ]
            ],
            'tglBerangkatAddEditForm' => [
                'label'     => 'Tanggal Pergi',
                'rules'     => 'required|valid_date[d/m/Y]'
            ],
            'tglKembaliAddEditForm'   => [
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
                'label'     => 'Kode Rekening',
                'rules'     => 'required|numeric|max_length[20]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'instansiAddEditForm'  => [
                'label'     => 'Nama Instansi',
                'rules'     => 'required|max_length[20]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'untukAddEditForm'  => [
                'label'     => 'Nama Instansi',
                'rules'     => 'required|max_length[50]',
                'errors'    => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'pejabatKuitansiAddEditForm' => [
                'label'     => 'Pejabat Pelaksanan Teknis',
                'rules'     => 'required|numeric|max_length[25]',
                'errors'    => [
                    'numeric'       => '{field} Hanya Boleh Memsasukkan Angka',
                    'max_length'    => '{field} Maksimal 25 Karakter'
                ]
            ],
            'jumlahAddEditForm'  => [
                'label'     => 'Jumlah Uang',
                'rules'     => 'required|numeric|max_length[8]',
                'errors'    => [
                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                    'max_length' => '{field} Maksimal 8 Karakter',
                ]
            ],
        ]);
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
        //
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
        //
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
        //
    }
}
