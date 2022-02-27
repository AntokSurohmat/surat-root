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
    protected $helpers = ['form', 'url'];
    public function __construct()
    {
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
            exit('No direct script is allowed');
        }
        $db      = \Config\Database::connect();
        $provinsi = $db->table('provinsi')->get();
        $kabupaten = $db->table('kabupaten')->get();
        $kecamatan = $db->table('kecamatan')->get();
        $jenis = $db->table('jenis_wilayah')->get();
        $zonasi = $db->table('zonasi')->get();
        $pangol = $db->table('pangol')->get();
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
                if ($prov->id == $key->id_provinsi) {
                    $row[] =  $prov->nama_provinsi;
                }
            };
            foreach ($kabupaten->getResult() as $kab) {
                if ($kab->id == $key->id_kabupaten) {
                    $row[] =  $kab->nama_kabupaten;
                }
            };
            foreach ($jenis->getResult() as $jen) {
                if ($jen->id == $key->id_jenis_wilayah) {
                    $row[] =  $jen->jenis_wilayah;
                }
            };
            foreach ($kecamatan->getResult() as $kec) {
                if ($kec->id == $key->id_kecamatan) {
                    $row[] =  $kec->nama_kecamatan;
                }
            };
            foreach ($zonasi->getResult() as $zona) {
                if ($zona->id == $key->id_zonasi) {
                    $row[] =  $zona->nama_zonasi;
                }
            };
            foreach ($pangol->getResult() as $pang) {
                if ($pang->id == $key->id_pangol) {
                    $row[] =  $pang->nama_pangol;
                }
            };
            $row[] = $key->jumlah_uang;
            $row[] = '
            <a class="btn btn-xs btn-warning mr-1 mb-1" href="/Admin/Sbuh/edit/' . $key->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
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

    public function getProvinsi()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $provinsilist = $this->provinsi->select('id,nama_provinsi') // Fetch record
                ->where('deleted_at', NULL)
                ->orderBy('nama_provinsi')
                ->findAll(10);
            // $count = $provinsilist->countAllResults();
            // d($provinsilist);
            // print_r($provinsilist);
            // die();
        } else {
            $provinsilist = $this->provinsi->select('id,nama_provinsi') // Fetch record
                ->where('deleted_at', NULL)
                ->like('nama_provinsi', $this->request->getPost('searchTerm'))
                ->orderBy('nama_provinsi')
                ->findAll(10);
        }

        $data = array();
        foreach ($provinsilist as $provinsi) {
            $data[] = array(
                "id" => $provinsi['id'],
                "text" => $provinsi['nama_provinsi'],
            );
        }

        // $response['count'] = $count;
        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }
    public function getKabupaten()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        if ($this->request->getPost('searchTerm') == NULL) {
            $kabupatenlist = $this->kabupaten->select('id,nama_kabupaten') // Fetch record
                ->where('id_provinsi', $this->request->getPost('provinsi'))
                ->where('deleted_at', NULL)
                ->orderBy('nama_kabupaten')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kabupaten->select('id,nama_kabupaten') // Fetch record
                ->like('nama_kabupaten', $this->request->getPost('searchTerm'))
                ->where('id_provinsi', $this->request->getPost('provinsi'))
                ->where('deleted_at', NULL)
                ->orderBy('nama_kabupaten')
                ->findAll(10);
        }

        $data = array();
        foreach ($kabupatenlist as $kabupaten) {
            $data[] = array(
                "id" => $kabupaten['id'],
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
            exit('No direct script is allowed');
        }

        if ($this->request->getVar('provinsi') && $this->request->getVar('kabupaten')) {
            $data = $this->jenis->where('id_provinsi', $this->request->getVar('provinsi'))->where('id_kabupaten', $this->request->getVar('kabupaten'))->first(['id']);
            // d($data['id']);print_r($data);die();
            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }
    public function getKecamatan()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        if ($this->request->getPost('searchTerm') == NULL) {
            $kabupatenlist = $this->kecamatan->select('id,nama_kecamatan') // Fetch record
                ->where('id_kabupaten', $this->request->getPost('kabupaten'))
                ->where('deleted_at', NULL)
                ->orderBy('nama_kecamatan')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kecamatan->select('id,nama_kecamatan') // Fetch record
                ->like('nama_kecamatan', $this->request->getPost('searchTerm'))
                ->where('id_kabupaten', $this->request->getPost('kabupaten'))
                ->where('deleted_at', NULL)
                ->orderBy('nama_kecamatan')
                ->findAll(10);
        }

        $data = array();
        foreach ($kabupatenlist as $kabupaten) {
            $data[] = array(
                "id" => $kabupaten['id'],
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
            exit('No direct script is allowed');
        }

        if ($this->request->getVar('provinsi') && $this->request->getVar('kabupaten') && $this->request->getVar('kecamatan')) {
            $data = $this->zonasi->where('id_provinsi', $this->request->getVar('provinsi'))->where('id_kabupaten', $this->request->getVar('kabupaten'))->where('id_kecamatan', $this->request->getVar('kecamatan'))->first();
            // d($data);print_r($data);die();
            $data[$this->csrfToken] = $this->csrfHash;
            echo json_encode($data);
        }
    }
    public function getpangol()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        // $provinsilist = $this->provinsi->getDataAjaxRemote($this->request->getPost('searchTerm'));
        if (($this->request->getPost('searchTerm') == NULL)) {
            $pangollist = $this->pangol->select('id,nama_pangol') // Fetch record
                ->where('deleted_at', NULL)
                ->orderBy('nama_pangol')
                ->findAll(10);
        } else {
            $pangollist = $this->pangol->select('id,nama_pangol') // Fetch record
                ->where('deleted_at', NULL)
                ->like('nama_pangol', $this->request->getPost('searchTerm'))
                ->orderBy('nama_pangol')
                ->findAll(10);
        }

        $data = array();
        foreach ($pangollist as $pangol) {
            $data[] = array(
                "id" => $pangol['id'],
                "text" => $pangol['nama_pangol'],
            );
        }

        // $response['count'] = $count;
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
            exit('No direct script is allowed');
        }

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodeAddEditForm' => [
                'label'     => 'Kode SBUH',
                'rules'     => 'required|numeric|max_length[10]|is_unique[etbl_wilayah.kode]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 10 Karakter',
                    'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
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
                'rules' => 'required|max_length[20]',
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
                'rules' => 'required|max_length[20]',
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
                ]
            ];
        } else {

            $jenisWilayah = $this->jenis->where('id_provinsi', $this->request->getVar('provinsiAddEditForm'))->where('id_kabupaten', $this->request->getVar('kabupatenAddEditForm'))->first();
            $zonasi = $this->zonasi->where('id_provinsi', $this->request->getVar('provinsiAddEditForm'))->where('id_kabupaten', $this->request->getVar('kabupatenAddEditForm'))->where('id_kecamatan', $this->request->getVar('kecamatanAddEditForm'))->first();


            $data = [
                'kode' => $this->request->getVar('kodeAddEditForm'),
                'id_provinsi' => $this->request->getVar('provinsiAddEditForm'),
                'id_kabupaten' => $this->request->getVar('kabupatenAddEditForm'),
                'id_jenis_wilayah' => $jenisWilayah['id'],
                'id_kecamatan' => $this->request->getVar('kecamatanAddEditForm'),
                'id_zonasi' => $zonasi['id'],
                'id_pangol' => $this->request->getVar('pangolAddEditForm'),
                'jumlah_uang' => $this->request->getVar('jumlahUangAddEditForm')
            ];
            if ($this->sbuh->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/sbuh'));
            } else {
                $data = array('success' => false, 'msg' => $this->sbuh->errors());
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    function single_data()
    {

        if ($this->request->getVar('id')) {
            $data = $this->sbuh->where('id', $this->request->getVar('id'))->first();

            $data['provinsi'] = $this->provinsi->where('id', $data['id_provinsi'])->first();
            $data['kabupaten'] = $this->kabupaten->where('id', $data['id_kabupaten'])->first();
            $data['jenis'] = $this->jenis->where('id', $data['id_jenis_wilayah'])->first();
            $data['kecamatan'] = $this->kecamatan->where('id', $data['id_kecamatan'])->first();
            $data['zonasi'] = $this->zonasi->where('id', $data['id_zonasi'])->first();
            $data['pangol'] = $this->pangol->where('id', $data['id_pangol'])->first();

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
            exit('No direct script is allowed');
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
                'rules' => 'required|max_length[20]',
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
                'rules' => 'required|max_length[20]',
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
                ]
            ];
        } else {

            $jenisWilayah = $this->jenis->where('id_provinsi', $this->request->getVar('provinsiAddEditForm'))->where('id_kabupaten', $this->request->getVar('kabupatenAddEditForm'))->first();
            $zonasi = $this->zonasi->where('id_provinsi', $this->request->getVar('provinsiAddEditForm'))->where('id_kabupaten', $this->request->getVar('kabupatenAddEditForm'))->where('id_kecamatan', $this->request->getVar('kecamatanAddEditForm'))->first();
            $id = $this->request->getVar('hiddenID');
            $data = [
                'kode' => $this->request->getVar('kodeAddEditForm'),
                'id_provinsi' => $this->request->getVar('provinsiAddEditForm'),
                'id_kabupaten' => $this->request->getVar('kabupatenAddEditForm'),
                'id_jenis_wilayah' => $jenisWilayah['id'],
                'id_kecamatan' => $this->request->getVar('kecamatanAddEditForm'),
                'id_zonasi' => $zonasi['id'],
                'id_pangol' => $this->request->getVar('pangolAddEditForm'),
                'jumlah_uang' => $this->request->getVar('jumlahUangAddEditForm')
            ];
            if ($this->sbuh->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/sbuh'));
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

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
