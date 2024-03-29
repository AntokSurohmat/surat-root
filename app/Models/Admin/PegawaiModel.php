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
    protected $useSoftDeletes   = true;
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
        'username' => 'required|max_length[20]',
        'password' => 'required|min_length[3]',
        'level' => 'required',
    ];
    protected $validationMessages   = [
        'nip' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 25 Karakter'
        ],
        'nama' => [
            'max_length' => '{field} Maksimal 50 Karakter',
        ],
        'kode_jabatan' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter'
        ],
        'kode_pangol' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter'
        ],
        'username' => [
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

    var $column_order = array(null, 'pegawai.nip', 'pegawai.nama', 'jabatan.nama_jabatan', 'pangol.nama_pangol', 'pegawai.pelaksana', 'pegawai.foto', 'pegawai.username', 'pegawai.level', null);
    var $order = array('pegawai.id' => 'DESC');

    function get_datatables(){

		// search
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = "pegawai.deleted_at IS NULL AND (pegawai.nip LIKE '%$search%' OR pegawai.nama LIKE '%$search%' OR jabatan.nama_jabatan LIKE '%$search%' OR pangol.nama_pangol LIKE '%$search%' OR pegawai.username LIKE '%$search%')";
		} else {
			$attr_order = "pegawai.id != '' AND pegawai.deleted_at IS NULL";
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
		$query = $builder->select('pegawai.*')
                ->select('jabatan.kode', 'jabatan.nama_jabatan')
                ->select('pangol.kode', 'pangol.nama_pangol')
                ->join('jabatan', 'jabatan.kode = pegawai.kode_jabatan', 'left')
                ->join('pangol', 'pangol.kode = pegawai.kode_pangol', 'left')
				->where($attr_order)
                ->where('pegawai.deleted_at', null)
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}


	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM pegawai WHERE deleted_at IS NULL";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND pegawai.deleted_at IS NULL AND (pegawai.nip LIKE '%$search%' OR pegawai.nama LIKE '%$search%' OR jabatan.nama_jabatan LIKE '%$search%' OR pangol.nama_pangol LIKE '%$search%' OR pegawai.username LIKE '%$search%')";
		} else {
			$attr_order = " AND pegawai.deleted_at IS NULL ";
		}
		$sQuery = "SELECT COUNT(pegawai.id) as total FROM pegawai
                    LEFT JOIN jabatan ON jabatan.kode = pegawai.kode_jabatan
                    LEFT JOIN pangol ON pangol.kode = pegawai.kode_pangol
                    WHERE pegawai.id != '' $attr_order " ;
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}
}
