<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class InstansiModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'instansi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'nama_instansi','kode_provinsi', 'kode_kabupaten', 'kode_kecamatan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode_provinsi' => 'required|numeric|max_length[20]',
        'kode_kabupaten' => 'required|numeric|max_length[20]',
        'kode_kecamatan' => 'required|numeric|max_length[20]',
        'kode' => 'required|numeric|max_length[20]',
        'nama_instansi' => 'required|max_length[20]',
    ];
    protected $validationMessages   = [
        'kode_provinsi' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'kode_kabupaten' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'kode_kecamatan' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'kode' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'nama_instansi' => [
            'max_length' => 'Maksimal 40 Karakter'
        ],
    ];
    protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];


    public function __construct()
    {
        parent::__construct();
    }

    var $column_order = array(null,  'instansi.kode', 'instansi.nama_instansi', 'provinsi.nama_provinsi', 'kabupaten.nama_kabupaten', 'kecamatan.nama_kecamatan', null);
    var $order = array('instansi.id' => 'DESC');

    function get_datatables()
    {

        // search
        if (service('request')->getPost('search')['value']) {
            $search = service('request')->getPost('search')['value'];
			$attr_order = "instansi.deleted_at IS NULL AND (instansi.kode LIKE '%$search%' OR provinsi.nama_provinsi LIKE '%$search%' OR kabupaten.nama_kabupaten LIKE '%$search%' OR kecamatan.nama_kecamatan LIKE '%$search%')";
        } else {
            $attr_order = "instansi.id != '' AND instansi.deleted_at IS NULL";
        }

        // order
        if (service('request')->getPost('order')) {
            $result_order = $this->column_order[service('request')->getPost('order')['0']['column']];
            $result_dir = service('request')->getPost('order')['0']['dir'];
        } else if ($this->order) {
            $order = $this->order;
            $result_order = key($order);
            $result_dir = $order[key($order)];
        }


        if (service('request')->getPost('length') != -1);
        // $db = db_connect();
        $builder = $this->db->table('instansi');
        $query = $builder->select('instansi.*')
            ->select('instansi.kode AS instansi_kode')
            ->select('provinsi.kode', 'provinsi.nama_provinsi')
            ->select('kabupaten.kode', 'kabupaten.nama_kabupaten')
            ->select('kecamatan.kode', 'kecamatan.nama_kecamatan')
            ->join('provinsi', 'provinsi.kode = instansi.kode_provinsi', 'left')
            ->join('kabupaten', 'kabupaten.kode = instansi.kode_kabupaten', 'left')
            ->join('kecamatan', 'kecamatan.kode = instansi.kode_kecamatan', 'left')
            ->where($attr_order)
            ->orderBy($result_order, $result_dir)
            ->limit(service('request')->getPost('length'), service('request')->getPost('start'))
            ->get();
        return $query->getResult();
    }


    function count_all()
    {
        $sQuery = "SELECT COUNT(id) as total FROM instansi WHERE deleted_at IS NULL";
        $query = $this->db->query($sQuery)->getRow();
        return $query;
    }

    function count_filter()
    {
        // Kondisi Order
        if (service('request')->getPost('search')['value']) {
            $search = service('request')->getPost('search')['value'];
			$attr_order = " AND instansi.deleted_at IS NULL AND (instansi.kode LIKE '%$search%' OR provinsi.nama_provinsi LIKE '%$search%' OR kabupaten.nama_kabupaten LIKE '%$search%' OR kecamatan.nama_kecamatan LIKE '%$search%')";
        } else {
            $attr_order = " AND instansi.deleted_at IS NULL ";
        }
		$sQuery = "SELECT COUNT(instansi.id) as total FROM instansi
                    LEFT JOIN provinsi ON provinsi.kode = instansi.kode_provinsi
                    LEFT JOIN kabupaten ON kabupaten.kode = instansi.kode_kabupaten
                    LEFT JOIN kecamatan ON kecamatan.kode = instansi.kode_kecamatan
                    WHERE instansi.id != '' $attr_order";
        $query = $this->db->query($sQuery)->getRow();
        return $query;
    }
}
