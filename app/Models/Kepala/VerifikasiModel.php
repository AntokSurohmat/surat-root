<?php

namespace App\Models\Kepala;

use CodeIgniter\Model;

class VerifikasiModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'spt';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['status','keterangan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'status' => 'required',
        'keterangan' => 'max_length[20]',
    ];
    protected $validationMessages   = [
        'keterangan' => [
            'max_length' => '{field} Maksmimal 20 Karakter'
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
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}

	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM etbl_spt";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND (etbl_spt.kode LIKE '%$search%' OR etbl_spt.nama_pegawai LIKE '%$search%' OR etbl_spt.dasar LIKE '%$search%' OR etbl_spt.untuk LIKE '%$search%' OR etbl_pegawai.nip LIKE '%$search%' OR etbl_spt.status LIKE '%$search%')";
		} else {
			$attr_order = " ";
		}
		$sQuery = "SELECT COUNT(etbl_spt.id) as total FROM etbl_spt
                    LEFT JOIN etbl_pegawai ON etbl_pegawai.nip = etbl_spt.diperintah
                    LEFT JOIN etbl_instansi ON etbl_instansi.kode = etbl_spt.kode_instansi
                    WHERE etbl_spt.id != '' $attr_order";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

}
