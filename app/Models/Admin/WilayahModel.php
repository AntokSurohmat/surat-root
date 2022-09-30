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
    protected $allowedFields    = ['kode', 'kode_provinsi', 'kode_kabupaten', 'kode_kecamatan', 'kode_jenis_wilayah', 'kode_zonasi'];

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
        'kode_kecamatan' => 'required|numeric|max_length[20]',
        'kode_jenis_wilayah' => 'required|numeric|max_length[20]',
        'kode_zonasi' => 'required|numeric|max_length[20]'
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
        'kode_kecamatan' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'kode_jenis_wilayah' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'kode_zonasi' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
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

    var $column_order = array(null, 'wilayah.kode', 'provinsi.nama_provinsi', 'kabupaten.nama_kabupaten', 'kecamatan.nama_kecamatan', 'jenis_wilayah.jenis_wilayah', 'zonasi.nama_zonasi', null);
    var $order = array('wilayah.id' => 'DESC');

    function get_datatables(){

		// search
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = "wilayah.deleted_at IS NULL AND (wilayah.kode LIKE '%$search%' OR provinsi.nama_provinsi LIKE '%$search%' OR kabupaten.nama_kabupaten LIKE '%$search%' OR kecamatan.nama_kecamatan LIKE '%$search%' OR jenis_wilayah.jenis_wilayah LIKE '%$search%' OR zonasi.nama_zonasi LIKE '%$search%')";
		} else {
			$attr_order = "wilayah.id != '' AND wilayah.deleted_at IS NULL";
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
		$query = $builder->select('wilayah.*')
                ->select('provinsi.kode', 'provinsi.nama_provinsi')
                ->select('kabupaten.kode', 'kabupaten.nama_kabupaten')
                ->select('kecamatan.kode', 'kecamatan.nama_kecamatan')
                ->select('jenis_wilayah.kode', 'jenis_wilayah.jenis_wilayah')
                ->select('zonasi.kode', 'zonasi.nama_zonasi')
                ->join('provinsi', 'provinsi.kode = wilayah.kode_provinsi', 'left')
                ->join('kabupaten', 'kabupaten.kode = wilayah.kode_kabupaten', 'left')
                ->join('kecamatan', 'kecamatan.kode = wilayah.kode_kecamatan', 'left')
                ->join('jenis_wilayah', 'jenis_wilayah.kode = wilayah.kode_jenis_wilayah', 'left')
                ->join('zonasi', 'zonasi.kode = wilayah.kode_zonasi', 'left')
				->where($attr_order)
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}


	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM wilayah WHERE deleted_at IS NULL";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND wilayah.deleted_at IS NULL AND (wilayah.kode LIKE '%$search%' OR provinsi.nama_provinsi LIKE '%$search%' OR kabupaten.nama_kabupaten LIKE '%$search%' OR kecamatan.nama_kecamatan LIKE '%$search%' OR jenis_wilayah.jenis_wilayah LIKE '%$search%' OR zonasi.nama_zonasi LIKE '%$search%')";
		} else {
			$attr_order = " AND wilayah.deleted_at IS NULL ";
		}
		$sQuery = "SELECT COUNT(wilayah.id) as total FROM wilayah
                    LEFT JOIN provinsi ON provinsi.kode = wilayah.kode_provinsi
                    LEFT JOIN kabupaten ON kabupaten.kode = wilayah.kode_kabupaten
                    LEFT JOIN kecamatan ON kecamatan.kode = wilayah.kode_kecamatan
                    LEFT JOIN jenis_wilayah ON jenis_wilayah.kode = wilayah.kode_jenis_wilayah
                    LEFT JOIN zonasi ON zonasi.kode = wilayah.kode_zonasi
                    WHERE wilayah.id != '' $attr_order";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}
}
