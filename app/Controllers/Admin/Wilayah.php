<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Admin\ProvinsiModel;
use App\Models\Admin\KabupatenModel;
use App\Models\Admin\KecamatanModel;
use App\Models\Admin\WilayahModel;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property IncomingRequest $request
 */

class Wilayah extends ResourcePresenter
{

    protected $helpers = ['form', 'url'];
    public function __construct()
    {
        $this->provinsi = new ProvinsiModel();
        $this->kabupaten = new KabupatenModel();
        $this->kecamatan = new KecamatanModel();
        $this->wilayah = new WilayahModel();
        $this->csrfToken = csrf_token();
        $this->csrfHash = csrf_hash();
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

    function load_data() {
        if (!$this->request->isAJAX()) {
            exit('No direct script is allowed');
        }
        $db      = \Config\Database::connect();
        $provinsi = $db->table('provinsi')->get();
        $kabupaten = $db->table('kabupaten')->get();
        $kecamatan = $db->table('kecamatan')->get();
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
            foreach ($provinsi->getResult() as $prov ) {
				if ($prov->id == $key->id_provinsi) {
					$row[] =  $prov->nama_provinsi;
				}
			};
            foreach ($kabupaten->getResult() as $kab ) {
				if ($kab->id == $key->id_kabupaten) {
					$row[] =  $kab->nama_kabupaten;
				}
			};
            foreach ($kecamatan->getResult() as $kec ) {
				if ($kec->id == $key->id_kecamatan) {
					$row[] =  $kec->nama_kecamatan;
				}
			};
            $row[] = $key->jenis_wilayah;
            $row[] = $key->zonasi;
            $row[] = '
            <a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="/Admin/Wilayah/edit/'.$key->id.'"  data-rel="tooltip" data-placement="top" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>
            <a class="btn btn-xs btn-danger mr-1 mb-1 delete" href="javascript:void(0)" name="delete" data-id="' . $key->id . '" data-rel="tooltip" data-placement="top" title="[ Delete Data ]"><i class="fas fa-trash text-white"></i></a>
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
        if (($this->request->getPost('searchTerm') == NULL)) {
            $provinsilist = $this->provinsi->select('id,nama_provinsi') // Fetch record
                ->orderBy('nama_provinsi')
                ->findAll(10);
        } else {
            $provinsilist = $this->provinsi->select('id,nama_provinsi') // Fetch record
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
                ->orderBy('nama_kabupaten')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kabupaten->select('id,nama_kabupaten') // Fetch record
                ->like('nama_kabupaten', $this->request->getPost('searchTerm'))
                ->where('id_provinsi', $this->request->getPost('provinsi'))
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
    public function getKecamatan()
    {
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $response = array();
        if ($this->request->getPost('searchTerm') == NULL) {            
            $kabupatenlist = $this->kecamatan->select('id,nama_kecamatan') // Fetch record
                ->where('id_kabupaten', $this->request->getPost('kabupaten'))
                ->orderBy('nama_kecamatan')
                ->findAll(10);
        } else {
            $kabupatenlist = $this->kecamatan->select('id,nama_kecamatan') // Fetch record
                ->like('nama_kecamatan', $this->request->getPost('searchTerm'))
                ->where('id_kabupaten', $this->request->getPost('kabupaten'))
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

    function savemodal(){
        if (!$this->request->isAjax()) {
            exit('No direct script is allowed');
        }

        $validation = \Config\Services::validation();

        // d($this->request->getVar());
        // print_r($this->request->getVar());
        // die();

        switch ($this->request->getVar('method')) {
            case 'Prov':
                $valid = $this->validate([
                    'nama_provinsiAddEdit' => [
                        'label' => 'Nama Provinsi',
                        'rules' => 'required|max_length[40]',
                        'errors' => [
                            'max_length' => '{field} Maksimal 40 Karakter'
                        ]
                    ]
                ]);
    
                if(!$valid){
                    $data = [
                        'error' => [
                            'nama_provinsi' => $validation->getError('nama_provinsiAddEdit')
                            ]
                        ];
                }else{ 
                    $data = [
                        'nama_provinsi' => $this->request->getVar('nama_provinsiAddEdit')
                    ];
                    if($this->provinsi->insert($data)){
                        $data = array('success'=> true, 'msg'=> 'Data berhasil disimpan');
                    }else{
                        $data = array('success'=> false, 'msg'=> 'Terjadi kesalahan dalam memilah data');
                    }
                }
                break;
                case 'Kab':
                    $valid = $this->validate([
                        'id_provinsiAddEdit' => [
                            'label' => 'Provinsi',
                            'rules' => 'required|numeric|max_length[20]',
                            'errors' => [
                                'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                                'max_length' => '{field} Maksimal 20 Karakter'
                            ]
                        ],
                        'nama_kabupatenAddEdit' => [
                            'label' => 'Nama Kabupaten',
                            'rules' => 'required|max_length[40]',
                            'errors' => [
                                'max_length' => '{field} Maksimal 40 Karakter'
                            ]
                        ]
                    ]);
        
                    if(!$valid){
                        $data = [
                            'error' => [
                                'id_provinsi' => $validation->getError('id_provinsiAddEdit'),
                                'nama_kabupaten' => $validation->getError('nama_kabupatenAddEdit')
                                ]
                            ];
                    }else{ 
                        $data = [
                            'id_provinsi' => $this->request->getVar('id_provinsiAddEdit'),
                            'nama_kabupaten' => $this->request->getVar('nama_kabupatenAddEdit')
                        ];
                        if($this->kabupaten->insert($data)){
                            $data = array('success'=> true, 'msg'=> 'Data berhasil disimpan');
                        }else{
                            $data = array('success'=> false, 'msg'=> 'Terjadi kesalahan dalam memilah data');
                        }
                    }
                    break;
                    case 'Kec':
                        $valid = $this->validate([
                            'id_kabupatenAddEdit' => [
                                'label' => 'Kabupaten',
                                'rules' => 'required|numeric|max_length[20]',
                                'errors' => [
                                    'numeric' => '{field} Hanya Boleh Memasukkan Angka',
                                    'max_length' => '{field} Maksimal 20 Karakter'
                                ]
                            ],
                            'nama_kecamatanAddEdit' => [
                                'label' => 'Nama Kecamatan',
                                'rules' => 'required|max_length[40]',
                                'errors' => [
                                    'max_length' => '{field} Maksimal 40 Karakter'
                                ]
                            ]
                        ]);
            
                        if(!$valid){
                            $data = [
                                'error' => [
                                    'id_kabupaten' => $validation->getError('id_kabupatenAddEdit'),
                                    'nama_kecamatan' => $validation->getError('nama_kecamatanAddEdit')
                                    ]
                                ];
                        }else{ 
                            $data = [
                                'id_kabupaten' => $this->request->getVar('id_kabupatenAddEdit'),
                                'nama_kecamatan' => $this->request->getVar('nama_kecamatanAddEdit')
                            ];
                            if($this->kecamatan->insert($data)){
                                $data = array('success'=> true, 'msg'=> 'Data berhasil disimpan');
                            }else{
                                $data = array('success'=> false, 'msg'=> 'Terjadi kesalahan dalam memilah data');
                            }
                        }
                        break;
            
            default:
                $data = array('success'=> false, 'msg'=> 'Terjadi kesalahan dalam memilah data');
                break;
        }





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
            'title' => 'WILAYAH',
            'parent' => 2,
            'pmenu' => 2.4,
            'method' => 'new',
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
            exit('No direct script is allowed');
        }

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodeAddEdit' => [
                'label'     => 'Kode Wilayah',
                'rules'     => 'required|numeric|max_length[10]|is_unique[etbl_wilayah.kode]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 10 Karakter',
                    'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                ],
            ],
            'provinsiAddEdit' => [
                'label'     => 'Provinsi',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                    'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                ],
            ],
            'kabupatenAddEdit' => [
                'label'     => 'Kabupaten',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                    'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                ],
            ],
            'kecamatanAddEdit' => [
                'label'     => 'Kecamatan',
                'rules'     => 'required|numeric|max_length[20]',
                'errors' => [
                    'numeric' => '{field}Hanya Bisa Memasukkan Angka',
                    'max_length' => '{field} Maksimal 20 Karakter',
                    'is_unique' => '{field} Kode Yang Anda masukkan sudah dipakai',
                ],
            ],
            'jenis_wilayahAddEdit' => [
                'label' => 'Nama Pangkat & Golongan',
                'rules' => 'required|max_length[40]',
                'errors' => [
                    'max_length' => '{field} Maksimal 40 Karakter',
                ],
            ],
            'zonasiAddEdit' => [
                'label' => 'Nama Pangkat & Golongan',
                'rules' => 'required|max_length[40]',
                'errors' => [
                    'max_length' => '{field} Maksimal 40 Karakter',
                ],
            ]
        ]);

        if (!$valid) {
            $data = [
                'error' => [
                    'kode' => $validation->getError('kodeAddEdit'),
                    'id_provinsi' => $validation->getError('provinsiAddEdit'),
                    'id_kabupaten' => $validation->getError('kabupatenAddEdit'),
                    'id_kecamatan' => $validation->getError('kecamatanAddEdit'),
                    'jenis_wilayah' => $validation->getError('jenis_wilayahAddEdit'),
                    'zonasi' => $validation->getError('zonasiAddEdit'),
                ]
            ];
        } else {

            $data = [
                'kode' => $this->request->getVar('kodeAddEdit'),
                'id_provinsi' => $this->request->getVar('provinsiAddEdit'),
                'id_kabupaten' => $this->request->getVar('kabupatenAddEdit'),
                'id_kecamatan' => $this->request->getVar('kecamatanAddEdit'),
                'jenis_wilayah' => $this->request->getVar('jenis_wilayahAddEdit'),
                'zonasi' => $this->request->getVar('zonasiAddEdit'),
            ];
            if ($this->wilayah->insert($data)) {
                $data = array('success' => true, 'msg' => 'Data Berhasil disimpan', 'redirect' => base_url('admin/wilayah'));
            } else {
                $data = array('success' => false, 'msg' => 'Terjadi kesalahan dalam memilah data');
            }
        }

        $data[$this->csrfToken] = $this->csrfHash;
        echo json_encode($data);
    }

    function single_data()
    {

        if ($this->request->getVar('id')) {
            $data = $this->wilayah->where('id', $this->request->getVar('id'))->first();

            $data['provinsi'] = $this->provinsi->where('id', $data['id_provinsi'])->first();

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
        // if (!isset($id)) {
		// 	return redirect()->to('/admin/wilayah/')->with('error', 'Data yang Anda Inginkan Tidak Mempunyai ID');
		// }
        // if (!$this->request->isAJAX()) {
        //     exit('No direct script is allowed');
        // }

        // $query = $this->wilayah->where('id', $this->request->getVar('id'))->first();
        $data = array(
            'title' => 'WILAYAH Edit',
            'parent' => 2,
            'pmenu' => 2.4,
            'method' => 'update',
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
