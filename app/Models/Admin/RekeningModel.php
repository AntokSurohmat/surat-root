<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class RekeningModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'rekening';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'kode_jenis_wilayah', 'nomer_rekening'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode' => 'required|numeric|max_length[20]',
        'kode_jenis_wilayah' => 'required|numeric|max_length[20]',
        'nomer_rekening' => 'required|max_length[12]',
    ];
    protected $validationMessages   = [
        'kode' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter' 
        ],        
        'kode_jenis_wilayah' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'nomer_rekening' => [
            'max_length' => 'Maksimal 12 Karakter'
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

    var $column_order = array(null, 'rekening.kode', 'jenis_wilayah.jenis_wilayah', 'rekening.nomer_rekening', null);
    var $order = array('rekening.id' => 'DESC');

    function get_datatables(){

		// search
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = "rekening.kode LIKE '%$search%' OR jenis_wilayah.jenis_wilayah LIKE '%$search%' OR rekening.nomer_rekening LIKE '%$search%'";
		} else {
			$attr_order = "rekening.id != ''";
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
		$builder = $this->db->table('rekening');
		$query = $builder->select('rekening.*')
                ->select('jenis_wilayah.kode', 'jenis_wilayah.jenis_wilayah')
                ->join('jenis_wilayah', 'jenis_wilayah.kode = rekening.kode_jenis_wilayah', 'left')
				->where($attr_order)
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}


	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM etbl_rekening";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND (etbl_rekening.kode LIKE '%$search%' OR etbl_jenis_wilayah.jenis_wilayah LIKE '%$search%' OR etbl_rekening.nomer_rekening LIKE '%$search%' )";
		} else {
			$attr_order = " ";
		}
		$sQuery = "SELECT COUNT(etbl_rekening.id) as total FROM etbl_rekening
                    LEFT JOIN etbl_jenis_wilayah ON etbl_jenis_wilayah.kode = etbl_rekening.kode_jenis_wilayah
                    WHERE etbl_rekening.id != '' $attr_order";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}
}
