<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class SbuhModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'sbuh';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'kode','kode_provinsi', 'kode_kabupaten', 'kode_jenis_wilayah', 'kode_kecamatan', 'kode_zonasi', 'kode_pangol', 'jumlah_uang'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode' => 'required|numeric|max_length[20]',
        'kode_provinsi' => 'required|numeric|max_length[20]',
        'kode_kabupaten' => 'required|numeric|max_length[20]',
        'kode_jenis_wilayah' => 'required|max_length[20]',
        'kode_kecamatan' => 'required|numeric|max_length[20]',
        'kode_zonasi' => 'required|max_length[20]',
        'kode_pangol' => 'required|max_length[10]',
        'jumlah_uang' => 'required|max_length[6]',
    ];
    protected $validationMessages   = [
        'kode' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter' 
        ],        
        'kode_provinsi' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter' 
        ],
        'kode_kabupaten' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'kode_jenis_wilayah' => [
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'kode_kecamatan' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'kode_zonasi' => [
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'kode_pangol' => [
            'max_length' => 'Maksimal 10 Karakter'
        ],
        'jumlah_uang' => [
            'max_length' => 'Maksimal 6 Karakter'
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

    var $column_order = array(null, 'kode','id_provinsi', 'id_kabupaten', 'id_jenis_wilayah', 'id_kecamatan', 'id_zonasi', 'id_pangol', 'jumlah_uang', null);
    var $order = array('id' => 'DESC');

    function get_datatables(){

		// search
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = "kode LIKE '%$search%' OR jumlah_uang LIKE '%$search%'";
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
		$builder = $this->db->table('sbuh');
		$query = $builder->select('*')
				->where($attr_order)
				->where('deleted_at', NULL)
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}


	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM etbl_sbuh WHERE deleted_at IS NULL";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND (kode LIKE '%$search%' OR jumlah_uang LIKE '%$search%') AND deleted_at IS NULL";
		} else {
			$attr_order = " AND deleted_at IS NULL";
		}
		$sQuery = "SELECT COUNT(id) as total FROM etbl_sbuh WHERE id != '' $attr_order";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}
}
