<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'pegawai';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nip', 'nama', 'tgl_lahir', 'kode_jabatan', 'kode_pangol', 'pelaksana', 'foto', 'username', 'password', 'level'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nip' => 'required|numeric|max_length[25]',
        'nama' => 'required|max_length[50]',
        'tgl_lahir' => 'required',
        'kode_jabatan' => 'required|numeric|max_length[20]',
        'kode_pangol' => 'required|numeric|max_length[20]',
        'pelaksana' => 'required',
        'foto'  => 'required',
        'username' => 'required|max_length[20]',
        'password' => 'requred|max_length[20]',
        'level' => 'required',
    ];
    protected $validationMessages   = [
        'nip' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 25 Karakter'
        ],
        'nama' => [
            'max_length' => 'Maksimal 50 Karakter',
        ],
        'kode_jabatan' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'kode_pangol' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'username' => [
            'max_length' => 'Maksimal 20 Karakter',
        ],
        'password' => [
            'max_length' => 'Maksimal 20 Karakter',
        ]

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

    var $column_order = array(null, 'nip', 'nama', 'kode_jabatan', 'kode_pangol', 'pelaksana', 'foto', 'username', 'level', null);
    var $order = array('created_at' => 'DESC');

    function get_datatables(){

		// search
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = "nip LIKE '%$search%' OR nama LIKE '%$search%' OR username LIKE '%$search%'";
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
		$builder = $this->db->table('pegawai');
		$query = $builder->select('*')
				->where($attr_order)
				->where('deleted_at', NULL)
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}


	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM etbl_pegawai WHERE deleted_at IS NULL";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND (nip LIKE '%$search%' OR nama LIKE '%$search%' OR username LIKE '%$search%') AND deleted_at IS NULL";
		} else {
			$attr_order = " AND deleted_at IS NULL";
		}
		$sQuery = "SELECT COUNT(id) as total FROM etbl_pegawai WHERE id != '' $attr_order";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}
}
