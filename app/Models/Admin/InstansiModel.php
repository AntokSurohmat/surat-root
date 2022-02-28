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
    protected $allowedFields    = ['kode_provinsi', 'kode_kabupaten', 'kode_kecamatan', 'kode', 'nama_instansi'];

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

    var $column_order = array(null,  'kode', 'nama_instansi', 'kode_provinsi', 'kode_kabupaten', 'kode_kecamatan', null);
    var $order = array('created_at' => 'DESC');

    function get_datatables()
    {

        // search
        if (service('request')->getPost('search')['value']) {
            $search = service('request')->getPost('search')['value'];
            $attr_order = "kode LIKE '%$search%' OR nama_instansi LIKE '%$search%'";
        } else {
            $attr_order = "id != ''";
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
        $query = $builder->select('*')
            ->where($attr_order)
            ->where('deleted_at', NULL)
            ->orderBy($result_order, $result_dir)
            ->limit(service('request')->getPost('length'), service('request')->getPost('start'))
            ->get();
        return $query->getResult();
    }


    function count_all()
    {
        $sQuery = "SELECT COUNT(id) as total FROM etbl_instansi WHERE deleted_at IS NULL";
        $query = $this->db->query($sQuery)->getRow();
        return $query;
    }

    function count_filter()
    {
        // Kondisi Order
        if (service('request')->getPost('search')['value']) {
            $search = service('request')->getPost('search')['value'];
            $attr_order = " AND (kode LIKE '%$search%' OR nama_instansi LIKE '%$search%') AND deleted_at IS NULL";
        } else {
            $attr_order = " AND deleted_at IS NULL";
        }
        $sQuery = "SELECT COUNT(id) as total FROM etbl_instansi WHERE id != '' $attr_order";
        $query = $this->db->query($sQuery)->getRow();
        return $query;
    }
}
