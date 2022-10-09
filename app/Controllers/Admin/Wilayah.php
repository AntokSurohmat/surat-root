<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Admin\JenisWilayahModel;
use App\Models\Admin\ZonasiModel;
use App\Models\Admin\WilayahModel;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */

class Wilayah extends ResourcePresenter
{

    protected $helpers = ['form', 'url', 'text'];
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
        $this->wilayah = new WilayahModel();
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
            'title' => 'WILAYAH',
            'parent' => 2,
            'pmenu' => 2.4,
        );
        return view('admin/wilayah/v-wilayah', $data);
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
        $list = $this->wilayah->get_datatables();
        $count_all = $this->wilayah->count_all();
        $count_filter = $this->wilayah->count_filter();

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
            foreach ($kecamatan->getResult() as $kec) {
                if ($kec->kode == $key->kode_kecamatan) {
                    $row[] =  $kec->nama_kecamatan;
                }
            };
            foreach ($jenis->getResult() as $jen) {
                if ($jen->kode == $key->kode_jenis_wilayah) {
                    $row[] =  $jen->jenis_wilayah;
                }
            };
            foreach ($zonasi->getResult() as $zona) {
                if ($zona->kode == $key->kode_zonasi) {
                    $row[] =  $zona->nama_zonasi;
                }
            };
            $row[] = '
            <a class="btn btn-xs btn-warning mr-1 mb-1" href="/Admin/Wilayah/edit/' . $key->id . '"  data-rel="tooltip" data-placement="top" data-container=".content" title="[ Update Data ]"><i class="fas fa-edit text-white"></i></a>
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
    function generatorProv(){
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $data['kode'] = random_string('numeric', 2);
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
    function generatorKab(){
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $data['kode'] = random_string('numeric', 4);
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
    function generatorKec(){
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $data['kode'] = random_string('numeric', 7);
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
    function generatorJenis(){
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }
        $data['kode'] = random_string('numeric');
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
    function generatorZona(){
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
                ->where('deleted_at', NULL)
                ->orderBy('nama_provinsi')
                ->findAll(10);
        } else {
            $provinsilist = $this->provinsi->select('kode,nama_provinsi') // Fetch record
                ->where('deleted_at', NULL)
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
                ->where('kode_provinsi', $this->request->getPost('provinsi'))
                ->where('deleted_at', NULL)
                ->orderBy('nama_kabupaten')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kabupaten->select('kode,nama_kabupaten') // Fetch record
                ->like('nama_kabupaten', $this->request->getPost('searchTerm'))
                ->where('kode_provinsi', $this->request->getPost('provinsi'))
                ->where('deleted_at', NULL)
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
    public function getKecamatan()
    {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if ($this->request->getPost('searchTerm') == NULL) {
            $kabupatenlist = $this->kecamatan->select('kode,nama_kecamatan') // Fetch record
                ->where('kode_kabupaten', $this->request->getPost('kabupaten'))
                ->where('deleted_at', NULL)
                ->orderBy('nama_kecamatan')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kecamatan->select('kode,nama_kecamatan') // Fetch record
                ->like('nama_kecamatan', $this->request->getPost('searchTerm'))
                ->where('kode_kabupaten', $this->request->getPost('kabupaten'))
                ->where('deleted_at', NULL)
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
    public function getJenis()
    {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $jenislist = $this->jenis->select('kode,jenis_wilayah') // Fetch record
                ->where('kode_provinsi', $this->request->getPost('provinsi'))
                ->where('kode_kabupaten', $this->request->getPost('kabupaten'))
                ->where('deleted_at', NULL)
                ->orderBy('jenis_wilayah')
                ->findAll(10);
        } else {
            $jenislist = $this->jenis->select('kode,jenis_wilayah') // Fetch record
                ->like('jenis_wilayah', $this->request->getPost('searchTerm'))
                ->where('kode_provinsi', $this->request->getPost('provinsi'))
                ->where('kode_kabupaten', $this->request->getPost('kabupaten'))
                ->where('deleted_at', NULL)
                ->orderBy('jenis_wilayah')
                ->findAll(10);
        }

        $data = array();
        foreach ($jenislist as $jenis) {
            $data[] = array(
                "id" => $jenis['kode'],
                "text" => $jenis['jenis_wilayah'],
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

        $response = array();
        if (($this->request->getPost('searchTerm') == NULL)) {
            $zonasilist = $this->zonasi->select('kode,nama_zonasi') // Fetch record
                ->where('kode_provinsi', $this->request->getPost('provinsi'))
                ->where('kode_kabupaten', $this->request->getPost('kabupaten'))
                ->where('kode_kecamatan', $this->request->getPost('kecamatan'))
                ->where('deleted_at', NULL)
                ->orderBy('nama_zonasi')
                ->findAll(10);
        } else {
            $zonasilist = $this->zonasi->select('kode,nama_zonasi') // Fetch record
                ->like('nama_zonasi', $this->request->getPost('searchTerm'))
                ->where('kode_provinsi', $this->request->getPost('provinsi'))
                ->where('kode_kabupaten', $this->request->getPost('kabupaten'))
                ->where('kode_kecamatan', $this->request->getPost('kecamatan'))
                ->where('deleted_at', NULL)
                ->orderBy('nama_zonasi')
                ->findAll(10);
        }

        $data = array();
        foreach ($zonasilist as $zonasi) {
            $data[] = array(
                "id" => $zonasi['kode'],
                "text" => $zonasi['nama_zonasi'],
            );
        }

        $response['data'] = $data;
        $response[$this->csrfToken] = $this->csrfHash;
        return $this->response->setJSON($response);
    }

    function savemodal()
    {
        if (!$this->request->isAjax()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException(base_url('/forbidden'));
        }

        $validation = \Config\Services::validation();

        switch ($this->request->getVar('method')) {
            case 'Prov':
                $valid = $this->validate([
                    'kodeAddEditModalProv' => [
                        'label'     => 'Kode Provinsi',
                        'rules'     => 'required|numeric|max_length[20]|is_unique[provinsi.kode]',
                        'errors' => [
                            'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                            'max_length' => '{field} Maksimal 20 Karakter',
                            'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                        ],
                    ],
                    'provinsiAddEditModalProv' => [
                        'label' => 'Nama Provinsi',
                        'rules' => 'required|max_length[40]',
                        'errors' => [
                            'max_length' => '{field} Maksimal 40 Karakter'
                        ]
                    ]
                ]);

                if (!$valid) {
                    $data = [
                        'error' => [
                            'kode' => $validation->getError('kodeAddEditModalProv'),
                            'provinsi' => $validation->getError('provinsiAddEditModalProv')
                        ],
                        'msg' => '',
                    ];
                } else {
                    $data = [
                        'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditModalProv')),
                        'nama_provinsi' => $this->db->escapeString($this->request->getVar('provinsiAddEditModalProv')),
                    ];
                    if ($this->provinsi->insert($data)) {
                        $data = array('success' => true, 'msg' => 'Data berhasil disimpan');
                    } else {
                        $data = array('success' => false, 'msg' => $this->wilayah->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                    }
                }
                break;
            case 'Kab':
                $valid = $this->validate([
                    'kodeAddEditModalKab' => [
                        'label'     => 'Kode Kabupaten',
                        'rules'     => 'required|numeric|max_length[20]|is_unique[kabupaten.kode]',
                        'errors' => [
                            'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                            'max_length' => '{field} Maksimal 20 Karakter',
                            'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                        ],
                    ],
                    'provinsiAddEditModalKab' => [
                        'label' => 'Nama Provinsi',
                        'rules' => 'required|numeric|max_length[20]',
                        'errors' => [
                            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                            'max_length' => '{field} Maksimal 20 Karakter'
                        ]
                    ],
                    'kabupatenAddEditModalKab' => [
                        'label' => 'Nama Kabupaten',
                        'rules' => 'required|max_length[40]',
                        'errors' => [
                            'max_length' => '{field} Maksimal 40 Karakter'
                        ]
                    ]
                ]);

                if (!$valid) {
                    $data = [
                        'error' => [
                            'kode' => $validation->getError('kodeAddEditModalKab'),
                            'provinsi' => $validation->getError('provinsiAddEditModalKab'),
                            'kabupaten' => $validation->getError('kabupatenAddEditModalKab')
                        ],
                        'msg' => '',
                    ];
                } else {
                    $data = [
                        'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditModalKab')),
                        'kode_provinsi' =>  $this->db->escapeString($this->request->getVar('provinsiAddEditModalKab')),
                        'nama_kabupaten' =>  $this->db->escapeString($this->request->getVar('kabupatenAddEditModalKab'))
                    ];
                    if ($this->kabupaten->insert($data)) {
                        $data = array('success' => true, 'msg' => 'Data berhasil disimpan');
                    } else {
                        $data = array('success' => false, 'msg' => $this->wilayah->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                    }
                }
                break;
            case 'Kec':
                $valid = $this->validate([
                    'kodeAddEditModalKec' => [
                        'label'     => 'Kode Kecamatan',
                        'rules'     => 'required|numeric|max_length[20]|is_unique[kecamatan.kode]',
                        'errors' => [
                            'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                            'max_length' => '{field} Maksimal 20 Karakter',
                            'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                        ],
                    ],
                    'kabupatenAddEditModalKec' => [
                        'label' => 'Nama Kabupaten',
                        'rules' => 'required|numeric|max_length[20]',
                        'errors' => [
                            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                            'max_length' => '{field} Maksimal 20 Karakter'
                        ]
                    ],
                    'kecamatanAddEditModalKec' => [
                        'label' => 'Nama Kecamatan',
                        'rules' => 'required|max_length[40]',
                        'errors' => [
                            'max_length' => '{field} Maksimal 40 Karakter'
                        ]
                    ]
                ]);

                if (!$valid) {
                    $data = [
                        'error' => [
                            'kode' => $validation->getError('kodeAddEditModalKec'),
                            'kabupaten' => $validation->getError('kabupatenAddEditModalKec'),
                            'kecamatan' => $validation->getError('kecamatanAddEditModalKec')
                        ],
                        'msg' => '',
                    ];
                } else {
                    $data = [
                        'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditModalKec')),
                        'kode_kabupaten' => $this->db->escapeString($this->request->getVar('kabupatenAddEditModalKec')),
                        'nama_kecamatan' => $this->db->escapeString($this->request->getVar('kecamatanAddEditModalKec')),
                    ];
                    if ($this->kecamatan->insert($data)) {
                        $data = array('success' => true, 'msg' => 'Data berhasil disimpan');
                    } else {
                        $data = array('success' => false, 'msg' => $this->wilayah->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                    }
                }
                break;
            case 'Jenis':
                $valid = $this->validate([
                    'kodeAddEditModalJenis' => [
                        'label'     => 'Kode Jenis',
                        'rules'     => 'required|numeric|max_length[20]|is_unique[jenis_wilayah.kode]',
                        'errors' => [
                            'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                            'max_length' => '{field} Maksimal 20 Karakter',
                            'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                        ],
                    ],
                    'provinsiAddEditModalJenis' => [
                        'label' => 'Nama Provinsi',
                        'rules' => 'required|numeric|max_length[20]',
                        'errors' => [
                            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                            'max_length' => '{field} Maksimal 20 Karakter'
                        ]
                    ],
                    'kabupatenAddEditModalJenis' => [
                        'label' => 'Nama Kabupaten',
                        'rules' => 'required|max_length[40]',
                        'errors' => [
                            'max_length' => '{field} Maksimal 40 Karakter'
                        ]
                    ],
                    'jenisWilayahAddEditModalJenis' => [
                        'label' => 'Nama Jenis Wilayah',
                        'rules' => 'required|max_length[40]',
                        'errors' => [
                            'max_length' => '{field} Maksimal 40 Karakter'
                        ]
                    ]
                ]);

                if (!$valid) {
                    $data = [
                        'error' => [
                            'kode' => $validation->getError('kodeAddEditModalJenis'),
                            'provinsi' => $validation->getError('provinsiAddEditModalJenis'),
                            'kabupaten' => $validation->getError('kabupatenAddEditModalJenis'),
                            'jenisWilayah' => $validation->getError('jenisWilayahAddEditModalJenis')
                        ],
                        'msg' => '',
                    ];
                } else {
                    $data = [
                        'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditModalJenis')),
                        'kode_provinsi' => $this->db->escapeString($this->request->getVar('provinsiAddEditModalJenis')),
                        'kode_kabupaten' => $this->db->escapeString($this->request->getVar('kabupatenAddEditModalJenis')),
                        'jenis_wilayah' => $this->db->escapeString($this->request->getVar('jenisWilayahAddEditModalJenis')),
                    ];
                    if ($this->jenis->insert($data)) {
                        $data = array('success' => true, 'msg' => 'Data berhasil disimpan');
                    } else {
                        $data = array('success' => false, 'msg' => $this->wilayah->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                    }
                }
                break;
            case 'Zona':
                $valid = $this->validate([
                    'kodeAddEditModalZona' => [
                        'label'     => 'Kode Zonasi',
                        'rules'     => 'required|numeric|max_length[20]|is_unique[zonasi.kode]',
                        'errors' => [
                            'numeric' => '{field} Hanya Bisa Memasukkan Angka',
                            'max_length' => '{field} Maksimal 20 Karakter',
                            'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                        ],
                    ],
                    'provinsiAddEditModalZona' => [
                        'label' => 'Nama Provinsi',
                        'rules' => 'required|numeric|max_length[20]',
                        'errors' => [
                            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                            'max_length' => '{field} Maksimal 20 Karakter'
                        ]
                    ],
                    'kabupatenAddEditModalZona' => [
                        'label' => 'Nama Kabupaten',
                        'rules' => 'required|max_length[40]',
                        'errors' => [
                            'max_length' => '{field} Maksimal 40 Karakter'
                        ]
                    ],
                    'kecamatanAddEditModalZona' => [
                        'label' => 'Nama Kecamatan',
                        'rules' => 'required|max_length[40]|is_unique[zonasi.kode_kecamatan]',
                        'errors' => [
                            'max_length' => '{field} Maksimal 40 Karakter',
                            'is_unique' => '{field} yang Anda Masukkan Telah Mempunyai Zonasi'
                        ]
                    ],
                    'zonasiAddEditModalZona' => [
                        'label' => 'Nama Kabupaten',
                        'rules' => 'required|max_length[40]',
                        'errors' => [
                            'max_length' => '{field} Maksimal 40 Karakter'
                        ]
                    ]
                ]);

                if (!$valid) {
                    $data = [
                        'error' => [
                            'kode' => $validation->getError('kodeAddEditModalZona'),
                            'provinsi' => $validation->getError('provinsiAddEditModalZona'),
                            'kabupaten' => $validation->getError('kabupatenAddEditModalZona'),
                            'kecamatan' => $validation->getError('kecamatanAddEditModalZona'),
                            'zonasi' => $validation->getError('zonasiAddEditModalZona')
                        ],
                        'msg' => '',
                    ];
                } else {
                    $data = [
                        'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditModalZona')),
                        'kode_provinsi' => $this->db->escapeString($this->request->getVar('provinsiAddEditModalZona')),
                        'kode_kabupaten' => $this->db->escapeString($this->request->getVar('kabupatenAddEditModalZona')),
                        'kode_kecamatan' => $this->db->escapeString($this->request->getVar('kecamatanAddEditModalZona')),
                        'nama_zonasi' => $this->db->escapeString($this->request->getVar('zonasiAddEditModalZona')),
                    ];
                    if ($this->zonasi->insert($data)) {
                        $data = array('success' => true, 'msg' => 'Data berhasil disimpan');
                    } else {
                        $data = array('success' => false, 'msg' => $this->wilayah->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
                    }
                }
                break;

            default:
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
                break;
        }

        $data['msg'] =$data['msg'];
        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
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
            'title' => 'Tambah Wilayah',
            'parent' => 2,
            'pmenu' => 2.4,
            'method' => 'New',
            'hiddenID' => '',
        );
        return view('admin/wilayah/v-wilayahAddEdit', $data);
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
                'label'     => 'Kode Wilayah',
                'rules'     => 'required|numeric|max_length[20]|is_unique[wilayah.kode]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Kode Karakter',
                    'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                ],
            ],
            'provinsiAddEditForm' => [
                'label'     => 'Provinsi',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                    'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                ],
            ],
            'kabupatenAddEditForm' => [
                'label'     => 'Kabupaten',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                    'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                ],
            ],
            'kecamatanAddEditForm' => [
                'label'     => 'Kecamatan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'jenisWilayahAddEditForm' => [
                'label' => 'Nama Jenis Wilayah',
                'rules' => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'zonasiAddEditForm' => [
                'label' => 'Nama Zonasi',
                'rules' => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ]
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
                    'kecamatan' => $validation->getError('kecamatanAddEditForm'),
                    'jenisWilayah' => $validation->getError('jenisWilayahAddEditForm'),
                    'zonasi' => $validation->getError('zonasiAddEditForm'),
                ],
                'msg' => '',
            ];
        } else {

            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'kode_provinsi' => $this->db->escapeString($this->request->getVar('provinsiAddEditForm')),
                'kode_kabupaten' => $this->db->escapeString($this->request->getVar('kabupatenAddEditForm')),
                'kode_kecamatan' => $this->db->escapeString($this->request->getVar('kecamatanAddEditForm')),
                'kode_jenis_wilayah' => $this->db->escapeString($this->request->getVar('jenisWilayahAddEditForm')),
                'kode_zonasi' => $this->db->escapeString($this->request->getVar('zonasiAddEditForm')),
            ];
            if ($this->wilayah->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/wilayah'));
            } else {
                $data = array('success' => false, 'msg' => $this->wilayah->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
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
         $wilayah_id = $this->wilayah->where('id', $this->request->getVar('id'))->get();
         if($wilayah_id->getRow() == null){
             return redirect()->to(site_url('admin/wilayah/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }
         if (!$this->request->getVar('id')) {
             return redirect()->to(site_url('admin/wilayah/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }

        if ($this->request->getVar('id')) {
            $data = $this->wilayah->where('id', $this->request->getVar('id'))->first();

            $data['provinsi'] = $this->provinsi->where('kode', $data['kode_provinsi'])->first();
            $data['kabupaten'] = $this->kabupaten->where('kode', $data['kode_kabupaten'])->first();
            $data['kecamatan'] = $this->kecamatan->where('kode', $data['kode_kecamatan'])->first();
            $data['jenis'] = $this->jenis->where('kode', $data['kode_jenis_wilayah'])->first();
            $data['zonasi'] = $this->zonasi->where('kode', $data['kode_zonasi'])->first();

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

         $wilayah_id = $this->wilayah->where('id', $id)->get();
         if($wilayah_id->getRow() == null){
             return redirect()->to(site_url('admin/wilayah/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }
         if (!$id) {
             return redirect()->to(site_url('admin/wilayah/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }

        $data = array(
            'title' => 'Edit Wilayah',
            'parent' => 2,
            'pmenu' => 2.4,
            'method' => 'Update',
            'hiddenID' => $id,
        );
        return view('admin/wilayah/v-wilayahAddEdit', $data);
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
         $wilayah_id = $this->wilayah->where('id', $this->request->getVar('hiddenID'))->get();
         if($wilayah_id->getRow() == null){
             return redirect()->to(site_url('admin/wilayah/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }
         if (!$this->request->getVar('hiddenID')) {
             return redirect()->to(site_url('admin/wilayah/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
         }

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodeAddEditForm' => [
                'label'     => 'Kode Wilayah',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'provinsiAddEditForm' => [
                'label'     => 'Provinsi',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kabupatenAddEditForm' => [
                'label'     => 'Kabupaten',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'kecamatanAddEditForm' => [
                'label'     => 'Kecamatan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ],
            ],
            'jenisWilayahAddEditForm' => [
                'label' => 'Nama Jenis Wilayah',
                'rules' => 'required|numeric|max_length[40]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 40 Karakter',
                ],
            ],
            'zonasiAddEditForm' => [
                'label' => 'Nama Zonasi',
                'rules' => 'required|numeric|max_length[40]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 40 Karakter',
                ],
            ]
        ]);

        if (!$valid) {
            $data = [
                'error' => [
                    'kode' => $validation->getError('kodeAddEditForm'),
                    'provinsi' => $validation->getError('provinsiAddEditForm'),
                    'kabupaten' => $validation->getError('kabupatenAddEditForm'),
                    'kecamatan' => $validation->getError('kecamatanAddEditForm'),
                    'jenisWilayah' => $validation->getError('jenisWilayahAddEditForm'),
                    'zonasi' => $validation->getError('zonasiAddEditForm'),
                ],
                'msg' => '',
            ];
        } else {

            $id = $this->request->getVar('hiddenID');
            $data = [
                'kode' => $this->db->escapeString($this->request->getVar('kodeAddEditForm')),
                'kode_provinsi' => $this->db->escapeString($this->request->getVar('provinsiAddEditForm')),
                'kode_kabupaten' => $this->db->escapeString($this->request->getVar('kabupatenAddEditForm')),
                'kode_kecamatan' => $this->db->escapeString($this->request->getVar('kecamatanAddEditForm')),
                'kode_jenis_wilayah' => $this->db->escapeString($this->request->getVar('jenisWilayahAddEditForm')),
                'kode_zonasi' => $this->db->escapeString($this->request->getVar('zonasiAddEditForm')),
            ];
            if ($this->wilayah->update($id, $data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil di update!', 'redirect' => base_url('admin/wilayah'));
            } else {
                $data = array('success' => false, 'msg' => $this->wilayah->errors(), 'error' => 'Terjadi kesalahan dalam memilah data');
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
        $wilayah_id = $this->wilayah->where('id', $this->request->getVar('hiddenID'))->get();
        if($wilayah_id->getRow() == null){
            return redirect()->to(site_url('admin/wilayah/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }
        if (!$this->request->getVar('hiddenID')) {
            return redirect()->to(site_url('admin/wilayah/'))->with('error', 'Data Yang Anda Inginkan Tidak Mempunyai ID');
        }

        if ($this->request->getVar('id')) {
            $id = $this->request->getVar('id');

            if ($this->wilayah->where('id', $id)->delete($id)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil dihapus');
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }
}
