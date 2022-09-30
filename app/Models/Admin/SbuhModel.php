<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class SbuhModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'sbuh';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
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

    var $column_order = array(null, 'sbuh.kode','provinsi.nama_provinsi', 'kabupaten.nama_kabupaten', 'jenis_wilayah._jenis_wilayah', 'kecamatan.nama_kecamatan', 'zonasi.nama_zonasi', 'pangol.nama_pangol', 'jumlah_uang', null);
    var $order = array('sbuh.id' => 'DESC');

    function get_datatables(){

		// search
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = "sbuh.deleted_at IS NULL AND (sbuh.kode LIKE '%$search%' OR provinsi.nama_provinsi LIKE '%$search%' OR kabupaten.nama_kabupaten LIKE '%$search%' OR jenis_wilayah.jenis_wilayah LIKE '%$search%' OR kecamatan.nama_kecamatan LIKE '%$search%' OR zonasi.nama_zonasi LIKE '%$search%' OR pangol.nama_pangol LIKE '%$search%')";
		} else {
			$attr_order = "sbuh.id != '' AND sbuh.deleted_at IS NULL";
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
		$query = $builder->select('sbuh.*')
                ->select('provinsi.kode', 'provinsi.nama_provinsi')
                ->select('kabupaten.kode', 'kabupaten.nama_kabupaten')
                ->select('jenis_wilayah.kode', 'jenis_wilayah.jenis_wilayah')
                ->select('kecamatan.kode', 'kecamatan.nama_kecamatan')
                ->select('zonasi.kode', 'zonasi.nama_zonasi')
                ->select('pangol.kode', 'pangol.nama_pangol')
                ->join('provinsi', 'provinsi.kode = sbuh.kode_provinsi', 'left')
                ->join('kabupaten', 'kabupaten.kode = sbuh.kode_kabupaten', 'left')
                ->join('jenis_wilayah', 'jenis_wilayah.kode = sbuh.kode_jenis_wilayah', 'left')
                ->join('kecamatan', 'kecamatan.kode = sbuh.kode_kecamatan', 'left')
                ->join('zonasi', 'zonasi.kode = sbuh.kode_zonasi', 'left')
                ->join('pangol', 'pangol.kode = sbuh.kode_pangol', 'left')
				->where($attr_order)
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}


	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM sbuh WHERE deleted_at IS NULL";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND sbuh.deleted_at IS NULL AND (sbuh.kode LIKE '%$search%' OR provinsi.nama_provinsi LIKE '%$search%' OR kabupaten.nama_kabupaten LIKE '%$search%' OR jenis_wilayah.jenis_wilayah LIKE '%$search%' OR kecamatan.nama_kecamatan LIKE '%$search%' OR zonasi.nama_zonasi LIKE '%$search%' OR pangol.nama_pangol LIKE '%$search%')";
		} else {
			$attr_order = " AND sbuh.deleted_at IS NULL ";
		}
		$sQuery = "SELECT COUNT(sbuh.id) as total FROM sbuh 
                    LEFT JOIN provinsi ON provinsi.kode = sbuh.kode_provinsi
                    LEFT JOIN kabupaten ON kabupaten.kode = sbuh.kode_kabupaten
                    LEFT JOIN jenis_wilayah ON jenis_wilayah.kode = sbuh.kode_jenis_wilayah
                    LEFT JOIN kecamatan ON kecamatan.kode = sbuh.kode_kecamatan
                    LEFT JOIN zonasi ON zonasi.kode = sbuh.kode_zonasi
                    LEFT JOIN pangol ON pangol.kode = sbuh.kode_pangol
                    WHERE sbuh.id != '' $attr_order";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}
}
