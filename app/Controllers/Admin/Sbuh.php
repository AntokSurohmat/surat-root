<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Admin\JenisWilayahModel;
use App\Models\Admin\ZonasiModel;
use App\Models\Admin\PangolModel;
use App\Models\Admin\SbuhModel;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */

class Sbuh extends ResourcePresenter
{
    protected $helpers = ['form', 'url', 'text', 'my_helper'];
    public function __construct()
    {
        if (session()->get('level') != "Admin") {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $this->provinsi = new ProvinsiModel();
        $this->kabupaten = new KabupatenModel();
        $this->kecamatan = new KecamatanModel();
        $this->jenis = new JenisWilayahModel();
        $this->zonasi = new ZonasiModel();
        $this->pangol = new PangolModel();
        $this->sbuh = new SbuhModel();
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
            'title' => 'STANDAR BIAYA UANG HARIAN',
            'parent' => 2,
            'pmenu' => 2.6
        );
        return view('admin/sbuh/v-sbuh', $data);
    }

    function load_data()
    {
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $provinsi = $this->db->table('provinsi')->get();
        $kabupaten = $this->db->table('kabupaten')->get();
        $kecamatan = $this->db->table('kecamatan')->get();
        $jenis = $this->db->table('jenis_wilayah')->get();
        $zonasi = $this->db->table('zonasi')->get();
        $pangol = $this->db->table('pangol')->get();
        $list = $this->sbuh->get_datatables();
        $count_all = $this->sbuh->count_all();
        $count_filter = $this->sbuh->count_filter();

        $data = array();
        $no = $this->request->getPost('start');
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $key->kode;
            foreach ($provinsi->getResult() as $prov) {
                if ($prov->kode == $key->kode_provinsi) {
                    $row[] =  $prov->nama_provinsi;
                }
            };
            foreach ($kabupaten->getResult() as $kab) {
                if ($kab->kode == $key->kode_kabupaten) {
                    $row[] =  $kab->nama_kabupaten;
                }
            };
            foreach ($jenis->getResult() as $jen) {
                if ($jen->kode == $key->kode_jenis_wilayah) {
                    $row[] =  $jen->jenis_wilayah;
                }
            };
            foreach ($kecamatan->getResult() as $kec) {
                if ($kec->kode == $key->kode_kecamatan) {
                    $row[] =  $kec->nama_kecamatan;
                }
            };
            foreach ($zonasi->getResult() as $zona) {
                if ($zona->kode == $key->kode_zonasi) {
                    $row[] =  $zona->nama_zonasi;
                }
            };
            foreach ($pangol->getResult() as $pang) {
                if ($pang->kode == $key->kode_pangol) {
                    $row[] =  $pang->nama_pangol;
                }
            };
            $row[] = 'Rp. '.number_format($key->jumlah_uang, 0,'','.');
            $row[] = '
            <a class="btn btn-xs btn-warning mr-1 mb-1" href="'. base_url('admin/sbuh/edit/'.$key->id).'"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
            <a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" data-container=".content" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>
            ';
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

    function generator(){
        if (!$this->request->isAJAX()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $data['kode'] = random_string('numeric');
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    public function getProvinsi()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $provinsilist = $this->provinsi->select('kode,nama_provinsi') // Fetch record
                ->where('deleted_at', null)
                ->orderBy('nama_provinsi')
                ->findAll(10);
        } else {
            $provinsilist = $this->provinsi->select('kode,nama_provinsi') // Fetch record
                ->where('deleted_at', null)
                ->like('nama_provinsi', $this->request->getPost('searchTerm'))
                ->orderBy('nama_provinsi')
                ->findAll(10);
        }

        $data = array();
        foreach ($provinsilist as $provinsi) {
            $data[] = array(
                "id" => $provinsi['kode'],
                "text" => $provinsi['nama_provinsi'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getKabupaten()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if ($this->request->getPost('searchTerm') == NULL) {
            $kabupatenlist = $this->kabupaten->select('kode,nama_kabupaten') // Fetch record
                ->where('deleted_at', null)
                ->where('kode_provinsi', $this->request->getPost('provinsi'))
                ->orderBy('nama_kabupaten')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kabupaten->select('kode,nama_kabupaten') // Fetch record
                ->where('deleted_at', null)
                ->like('nama_kabupaten', $this->request->getPost('searchTerm'))
                ->where('kode_provinsi', $this->request->getPost('provinsi'))
                ->orderBy('nama_kabupaten')
                ->findAll(10);
        }

        $data = array();
        foreach ($kabupatenlist as $kabupaten) {
            $data[] = array(
                "id" => $kabupaten['kode'],
                "text" => $kabupaten['nama_kabupaten'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getJenis()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        if ($this->request->getVar('provinsi') && $this->request->getVar('kabupaten')) {
            $data = $this->jenis->where('kode_provinsi', $this->request->getVar('provinsi'))->where('kode_kabupaten', $this->request->getVar('kabupaten'))->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }
    public function getKecamatan()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if ($this->request->getPost('searchTerm') == NULL) {
            $kabupatenlist = $this->kecamatan->select('kode,nama_kecamatan') // Fetch record
                ->where('deleted_at', null)
                ->where('kode_kabupaten', $this->request->getPost('kabupaten'))
                ->orderBy('nama_kecamatan')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kecamatan->select('kode,nama_kecamatan') // Fetch record
                ->where('deleted_at', null)
                ->like('nama_kecamatan', $this->request->getPost('searchTerm'))
                ->where('kode_kabupaten', $this->request->getPost('kabupaten'))
                ->orderBy('nama_kecamatan')
                ->findAll(10);
        }

        $data = array();
        foreach ($kabupatenlist as $kabupaten) {
            $data[] = array(
                "id" => $kabupaten['kode'],
                "text" => $kabupaten['nama_kecamatan'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getZonasi()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        if ($this->request->getVar('provinsi') && $this->request->getVar('kabupaten') && $this->request->getVar('kecamatan')) {
            $data = $this->zonasi->where('kode_provinsi', $this->request->getVar('provinsi'))->where('kode_kabupaten', $this->request->getVar('kabupaten'))->where('kode_kecamatan', $this->request->getVar('kecamatan'))->first();

            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }
    public function getpangol()
    {
        if (!$this->request->isAjax()) {
           throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pangollist = $this->pangol->select('kode,nama_pangol') // Fetch record
                ->where('deleted_at', null)
                ->orderBy('nama_pangol')
                ->findAll(10);
        } else {
            $pangollist = $this->pangol->select('kode,nama_pangol') // Fetch record
                ->where('deleted_at', null)
                ->like('nama_pangol', $this->request->getPost('searchTerm'))
                ->orderBy('nama_pangol')
                ->findAll(10);
        }

        $data = array();
        foreach ($pangollist as $pangol) {
            $data[] = array(
                "id" => $pangol['kode'],
                "text" => $pangol['nama_pangol'],
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
        $data = array(
            'title' => 'Tambah Standar Biaya Uang Harian',
            'parent' => 2,
            'pmenu' => 2.6,
            'method' => 'New',
            'hiddenID' => '',
        );
        return view('admin/sbuh/v-sbuhAddEdit', $data);
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
            'kodeAddEditForm' => [
                'label'     => 'Kode SBUH',
                'rules'     => 'required|numeric|max_length[20]|is_unique[sbuh.kode]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                    'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                ],
            ],
            'provinsiAddEditForm' => [
                'label'     => 'Nama Provinsi',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kabupatenAddEditForm' => [
                'label'     => 'Nama Kabupaten',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'jenisWilayahAddEditForm' => [
                'label' => 'Nama Jenis Wilayah',
                'rules'  => 'required|max_length[20]',
                'errors' => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kecamatanAddEditForm' => [
                'label'     => 'Nama Kecamatan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'zonasiAddEditForm' => [
                'label' => 'Nama Zonasi',
                'rules'     => 'required|max_length[20]',
                'errors' => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'pangolAddEditForm' => [
                'label'     => 'Nama Pangkat & Golongan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'jumlahUangAddEditForm' => [
                'label'     => 'Jumlah Uang Biaya Harian',
                'rules'     => 'required|numeric|max_length[6]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 6 Karakter',
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
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'provinsi' => $validation->getError('provinsiAddEditForm'),
                    'kabupaten' => $validation->getError('kabupatenAddEditForm'),
                    'jenisWilayah' => $validation->getError('jenisWilayahAddEditForm'),
                    'kecamatan' => $validation->getError('kecamatanAddEditForm'),
                    'zonasi' => $validation->getError('zonasiAddEditForm'),
                    'pangol' => $validation->getError('pangolAddEditForm'),
                    'jumlahUang' => $validation->getError('jumlahUangAddEditForm'),
                ],
                'msg' => '',
            ];
        } else {

            $jenisWilayah = $this->jenis->where('kode_provinsi', $this->request->getVar('provinsiAddEditForm'))->where('kode_kabupaten', $this->request->getVar('kabupatenAddEditForm'))->first();
            $zonasi = $this->zonasi->where('kode_provinsi', $this->request->getVar('provinsiAddEditForm'))->where('kode_kabupaten', $this->request->getVar('kabupatenAddEditForm'))->where('kode_kecamatan', $this->request->getVar('kecamatanAddEditForm'))->first();


            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'kode_provinsi' => $this->db->escapeString($this->request->getVar('provinsiAddEditForm')),
                'kode_kabupaten' => $this->db->escapeString($this->request->getVar('kabupatenAddEditForm')),
                'kode_jenis_wilayah' => $this->db->escapeString($jenisWilayah['kode']),
                'kode_kecamatan' => $this->db->escapeString($this->request->getVar('kecamatanAddEditForm')),
                'kode_zonasi' => $this->db->escapeString($zonasi['kode']),
                'kode_pangol' => $this->db->escapeString($this->request->getVar('pangolAddEditForm')),
                'jumlah_uang' => $this->db->escapeString($this->request->getVar('jumlahUangAddEditForm')),
            ];
            if ($this->sbuh->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/sbuh'));
            } else {
                $data = array('success' => false, 'msg' => $this->sbuh->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    function single_data()
    {
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $sbuh_id = $this->sbuh->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
        if($sbuh_id->getRow() == null){
            return redirect()->to(site_url('admin/sbuh/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('admin/sbuh/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $data = $this->sbuh->where('id', $this->request->getVar('id'))->first();

            $data['provinsi'] = $this->provinsi->where('kode', $data['kode_provinsi'])->first();
            $data['kabupaten'] = $this->kabupaten->where('kode', $data['kode_kabupaten'])->first();
            $data['jenis'] = $this->jenis->where('kode', $data['kode_jenis_wilayah'])->first();
            $data['kecamatan'] = $this->kecamatan->where('kode', $data['kode_kecamatan'])->first();
            $data['zonasi'] = $this->zonasi->where('kode', $data['kode_zonasi'])->first();
            $data['pangol'] = $this->pangol->where('kode', $data['kode_pangol'])->first();

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

        $sbuh_id = $this->sbuh->where('id', $id)->where('deleted_at', null)->get();
        if($sbuh_id->getRow() == null){
            return redirect()->to(site_url('admin/sbuh/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$id) {
            return redirect()->to(site_url('admin/sbuh/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $data = array(
            'title' => 'Edit SBUH',
            'parent' => 2,
            'pmenu' => 2.6,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('admin/sbuh/v-sbuhAddEdit', $data);
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
        $sbuh_id = $this->sbuh->where('id', $this->request->getVar('hiddenID'))->where('deleted_at', null)->get();
        if($sbuh_id->getRow() == null){
            return redirect()->to(site_url('admin/sbuh/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('hiddenID')) {
            return redirect()->to(site_url('admin/sbuh/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodeAddEditForm' => [
                'label'     => 'Kode SBUH',
                'rules'     => 'required|numeric|max_length[10]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 10 Karakter',
                ],
            ],
            'provinsiAddEditForm' => [
                'label'     => 'Nama Provinsi',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kabupatenAddEditForm' => [
                'label'     => 'Nama Kabupaten',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'jenisWilayahAddEditForm' => [
                'label' => 'Nama Jenis Wilayah',
                'rules'     => 'required|max_length[20]',
                'errors' => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kecamatanAddEditForm' => [
                'label'     => 'Nama Kecamatan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'zonasiAddEditForm' => [
                'label' => 'Nama Zonasi',
                'rules'     => 'required|max_length[20]',
                'errors' => [
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'pangolAddEditForm' => [
                'label'     => 'Nama Pangkat & Golongan',
                'rules'     => 'required|numeric|max_length[10]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 10 Karakter',
                ],
            ],
            'jumlahUangAddEditForm' => [
                'label'     => 'Jumlah Uang Biaya Harian',
                'rules'     => 'required|numeric|max_length[6]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 6 Karakter',
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
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'provinsi' => $validation->getError('provinsiAddEditForm'),
                    'kabupaten' => $validation->getError('kabupatenAddEditForm'),
                    'jenisWilayah' => $validation->getError('jenisWilayahAddEditForm'),
                    'kecamatan' => $validation->getError('kecamatanAddEditForm'),
                    'zonasi' => $validation->getError('zonasiAddEditForm'),
                    'pangol' => $validation->getError('pangolAddEditForm'),
                    'jumlahUang' => $validation->getError('jumlahUangAddEditForm'),
                ],
                'msg' => '',
            ];
        } else {

            $jenisWilayah = $this->jenis->where('kode_provinsi', $this->request->getVar('provinsiAddEditForm'))->where('kode_kabupaten', $this->request->getVar('kabupatenAddEditForm'))->first();
            $zonasi = $this->zonasi->where('kode_provinsi', $this->request->getVar('provinsiAddEditForm'))->where('kode_kabupaten', $this->request->getVar('kabupatenAddEditForm'))->where('kode_kecamatan', $this->request->getVar('kecamatanAddEditForm'))->first();
            $id = $this->request->getVar('hiddenID');
            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'kode_provinsi' => $this->db->escapeString($this->request->getVar('provinsiAddEditForm')),
                'kode_kabupaten' => $this->db->escapeString($this->request->getVar('kabupatenAddEditForm')),
                'kode_jenis_wilayah' => $this->db->escapeString($jenisWilayah['kode']),
                'kode_kecamatan' => $this->db->escapeString($this->request->getVar('kecamatanAddEditForm')),
                'kode_zonasi' => $this->db->escapeString($zonasi['kode']),
                'kode_pangol' => $this->db->escapeString($this->request->getVar('pangolAddEditForm')),
                'jumlah_uang' => $this->db->escapeString($this->request->getVar('jumlahUangAddEditForm'))
            ];
            if ($this->sbuh->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/sbuh'));
            } else {
                $data = array('success' => false, 'msg' => $this->sbuh->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
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
        $sbuh_id = $this->sbuh->where('id', $this->request->getVar('id'))->where('deleted_at', null)->get();
        if($sbuh_id->getRow() == null){
            return redirect()->to(site_url('admin/sbuh/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('id')) {
            return redirect()->to(site_url('admin/sbuh/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $id = $this->request->getVar('id');

            if ($this->sbuh->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
}
