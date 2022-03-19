<?php

namespace App\Models\Bendahara;

use CodeIgniter\Model;

class KuitansiModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'kuitansi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_spd', 'pegawai_all','pegawai_diperintah', 'nip_pegawai', 'kode_pangol', 'kode_jabatan', 'untuk', 'kode_instansi', 'awal', 'akhir', 'lama', 'kode_rekening', 'pejabat', 'jumlah_uang','yang_menyetujui','bendahara'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode_spd' => 'required',
        'pegawai_all' => 'required',
        'pegawai_diperintah' => 'required',
        'nip_pegawai' => 'required|numeric|max_length[25]',
        'kode_pangol' => 'required|numeric|max_length[20]',
        'kode_jabatan' => 'required|numeric|max_length[20]',
        'untuk' => 'required|max_length[50]',
        'kode_instansi' => 'required|numeric|max_length[20]',
        'awal' => 'required',
        'akhir' => 'required',
        'lama' => 'required|numeric|max_length[2]',
        'kode_rekening' => 'required|numeric|max_length[20]',
        'pejabat' => 'required|numeric|max_length[25]',
        'jumlah_uang' => 'required|max_length[8]',
        'yang_menyetujui' => 'required|numeric|max_length[25]',
        'bendahara' => 'required|numeric|max_length[25]',

    ];
    protected $validationMessages   = [
        'nip_pegawai' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' =>  '{field} Maksimal 25 Karakter'
        ],
        'kode_pangol' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter'
        ],
        'kode_jabatan' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter'
        ],
        'untuk' => [
            'max_length' => '{field} Maksimal 50 Karakter'
        ],
        'kode_instansi' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter'
        ],
        'lama' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 2 Karakter'
        ],
        'kode_rekening' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter'
        ],
        'pejabat' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 25 Karakter'
        ],
        'jumlah_uang' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 8 Karakter'
        ],
        'yang_menyetujui' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 25 Karakter'
        ],
        'bendahara' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 25 Karakter'
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

    var $column_order = array(null, 'kuitansi.kode_spd', 'kuitansi.pegawai_all','kuitansi.untuk','pegawai.pejabat', null);
    var $order = array('kuitansi.id' => 'DESC');

    function get_datatables(){

		// search
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = "kuitansi.kode_spd LIKE '%$search%' OR kuitansi.pegawai_all LIKE '%$search%' OR kuitansi.untuk LIKE '%$search%' OR pegawai.pejabat LIKE '%$search%";
		} else {
			$attr_order = "kuitansi.id != ''";
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
		$builder = $this->db->table('kuitansi');
		$query = $builder->select('kuitansi.*')
                ->select('kuitansi.kode_spd AS kodes')
                ->select('pegawai.nip', 'pegawai.nama')
                ->select('instansi.kode', 'instansi.nama_instansi')
                ->join('pegawai', 'pegawai.nip = kuitansi.pejabat', 'left')
                ->join('instansi', 'instansi.kode = kuitansi.kode_instansi', 'left')
				->where($attr_order)
				->orderBy($result_order, $result_dir)
				->limit(service('request')->getPost('length'), service('request')->getPost('start'))
				->get();
		return $query->getResult();

	}

	function count_all(){
		$sQuery = "SELECT COUNT(id) as total FROM etbl_kuitansi";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}

	function count_filter(){
		// Kondisi Order
		if(service('request')->getPost('search')['value']){
			$search = service('request')->getPost('search')['value'];
			$attr_order = " AND (etbl_kuitansi.kode_spd LIKE '%$search%' OR etbl_kuitansi.pegawai_all LIKE '%$search%' OR etbl_kuitansi.untuk LIKE '%$search%' OR etbl_pegawai.pejabat LIKE '%$search%')";
		} else {
			$attr_order = " ";
		}
		$sQuery = "SELECT COUNT(etbl_kuitansi.id) as total FROM etbl_kuitansi
                    LEFT JOIN etbl_pegawai ON etbl_pegawai.nip = etbl_kuitansi.pejabat
                    LEFT JOIN etbl_instansi ON etbl_instansi.kode = etbl_kuitansi.kode_instansi
                    WHERE etbl_kuitansi.id != '' $attr_order";
		$query = $this->db->query($sQuery)->getRow();
		return $query;
	}
}
