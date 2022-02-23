<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class WilayahModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'wilayah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'id_provinsi', 'id_kabupaten', 'id_kecamatan', 'jenis_wilayah', 'zonasi'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode' => 'required|numeric|max_length[10]',
        'id_provinsi' => 'required|numeric|max_length[20]',
        'id_kabupaten' => 'required|numeric|max_length[20]',
        'id_kecamatan' => 'required|numeric|max_length[20]',
        'jenis_wilayah' => 'required|max_length[40]',
        'zonasi' => 'required|max_length[40]'
    ];
    protected $validationMessages   = [
        'kode' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 10 Karakter' 
        ],        
        'id_provinsi' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter' 
        ],
        'id_kabupaten' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'id_kecamatan' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'jenis_wilayah' => [
            'max_length' => 'Maksimal 40 Karakter'
        ],
        'zonasi' => [
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

    var $column_order = array(null, 'id_provinsi', 'id_kabupaten', 'id_kecamatan', 'kode', 'jenis_wilayah', 'zonasi', null);
    var $order = array('created_at' => 'DESC');

    function get_datatables(){

		// search
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = "kode LIKE '%$search%' OR jenis_wilayah LIKE '%$search%' OR zonasi LIKE '%$search%'";
		} else {
			$attr_order = "id != ''";
		}

		// order
        if(service('request')->getPost('order')){
			$result_order = $this->column_order[service('request')->getPost('order')['0']['column']];
			$result_dir = service('request')->getPost('order')['0']['dir'];
		} else if ($this->order){
			$order = $this->order;
			$result_order = key($order);
			$result_dir = $order[key($order)];
		}


		if(service('request')->getPost('length')!=-1);
		// $db = db_connect();
		$builder = $this->db->table('wilayah');
		$query = $builder->select('*')
				->where($attr_order)
				->where('deleted_at', NULL)
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}


	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM etbl_wilayah WHERE deleted_at IS NULL";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND (kode LIKE '%$search%' OR jenis_wilayah LIKE '%$search%' OR zonasi LIKE '%$search%') AND deleted_at IS NULL";
		} else {
			$attr_order = " AND deleted_at IS NULL";
		}
		$sQuery = "SELECT COUNT(id) as total FROM etbl_wilayah WHERE id != '' $attr_order";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}
}
