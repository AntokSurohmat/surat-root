<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class SptModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'spt';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'nama_pegawai', 'dasar', 'untuk', 'kode_instansi', 'alamat_instansi', 'awal', 'akhir', 'lama', 'diperintah', 'status', 'keterangan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode' => 'required|numeric|max_length[3]',
        'nama_pegawai' => 'required|max_length[100]',
        'dasar' => 'required|max_length[50]',
        'untuk' => 'required|max_length[50]',
        'kode_instansi' => 'required|numeric|max_length[20]',
        'alamat_instansi' => 'required|max_length[50]',
        'awal' => 'required',
        'akhir' => 'required',
        'lama' => 'required|numeric|max_length[2]',
        'diperintah' => 'required|numeric|max_length[25]',
        'status' => 'required',
    ];
    protected $validationMessages   = [
        'kode' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 25 Karakter'
        ],

        'dasar' => [
            'max_length' => '{field} Maksimal 50 Karakter',
        ],
        'untuk' => [
            'max_length' => '{field} Maksimal 50 Karakter',
        ],
        'kode_instansi' => [
            'numeric' => '{field} Hanya Boleh Memsasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter',
        ],
        'alamat_instansi' => [
            'max_length[50]' => '{field} Maksmimal 50 Karakter'
        ],
        'lama' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 2 Karakter',
        ],
        'diperintah' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksmimal 25 Karakter',
        ],
        'keterangan' => [
            'max_length' => '{field} Maksmimal 25 Karakter'
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

    var $column_order = array(null, 'spt.kode', 'spt.nama_pegawai','spt.dasar','spt.untuk','pegawai.nip', 'spt.status', null);
    var $order = array('spt.id' => 'DESC');

    function get_datatables(){

		// search
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = "spt.kode LIKE '%$search%' OR spt.nama_pegawai LIKE '%$search%' OR spt.dasar LIKE '%$search%' OR spt.untuk LIKE '%$search%' OR pegawai.nip LIKE '%$search% OR spt.status LIKE '%$search%'";
		} else {
			$attr_order = "spt.id != ''";
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
		$builder = $this->db->table('spt');
		$query = $builder->select('spt.*')
                ->select('spt.kode AS kodes')
                ->select('pegawai.nip', 'pegawai.nama')
                ->select('instansi.kode', 'instansi.nama_instansi')
                ->join('pegawai', 'pegawai.nip = spt.diperintah', 'left')
                ->join('instansi', 'instansi.kode = spt.kode_instansi', 'left')
				->where($attr_order)
				->where('spt.deleted_at', NULL)
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}

	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM etbl_spt WHERE deleted_at IS NULL";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND (etbl_spt.kode LIKE '%$search%' OR etbl_spt.nama_pegawai LIKE '%$search%' OR etbl_spt.dasar LIKE '%$search%' OR etbl_spt.untuk LIKE '%$search%' OR etbl_pegawai.nip LIKE '%$search%' OR etbl_spt.status LIKE '%$search%') AND etbl_spt.deleted_at IS NULL";
		} else {
			$attr_order = " AND etbl_spt.deleted_at IS NULL";
		}
		$sQuery = "SELECT COUNT(etbl_spt.id) as total FROM etbl_spt
                    LEFT JOIN etbl_pegawai ON etbl_pegawai.nip = etbl_spt.diperintah
                    LEFT JOIN etbl_instansi ON etbl_instansi.kode = etbl_spt.kode_instansi
                    WHERE etbl_spt.id != '' $attr_order";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}
}
