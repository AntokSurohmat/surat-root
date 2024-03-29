<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'jabatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'nama_jabatan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode' => 'required|numeric|max_length[20]',
        'nama_jabatan' => 'required|max_length[20]'
    ];
    protected $validationMessages   = [
        'kode'        => [
			'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter',
        ],
		'nama_jabatan'        => [
            'max_length' => '{field} Maksimal 20 Karakter',
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

    var $column_order = array(null, 'kode', 'nama_jabatan', null);
    var $order = array('id' => 'DESC');

    function get_datatables(){

		// search
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = "deleted_at IS NULL AND (kode LIKE '%$search%' OR nama_jabatan LIKE '%$search%')";
		} else {
			$attr_order = "id != '' AND deleted_at IS NULL";
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
		$builder = $this->db->table('jabatan');
		$query = $builder->select('*')
				->where($attr_order)
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}


	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM jabatan WHERE deleted_at IS NULL";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND deleted_at IS NULL AND (kode LIKE '%$search%' OR nama_jabatan LIKE '%$search%') ";
		} else {
			$attr_order = " AND deleted_at IS NULL ";
		}
		$sQuery = "SELECT COUNT(id) as total FROM jabatan WHERE id != '' $attr_order";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}
}
