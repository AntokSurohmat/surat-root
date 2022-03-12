<?php

namespace App\Models\Pegawai;

use CodeIgniter\Model;

class SpdModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'spd';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
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

    var $column_order = array(null, 'spd.kode', 'spd.nama_pegawai','spd.untuk','pegawai.nip', 'spd.status', null);
    var $order = array('spd.id' => 'DESC');

    function get_datatables(){

        // search
        if(service('request')->getPost('search')['value']){
            $search = service('request')->getPost('search')['value'];
            $attr_order = "spd.kode LIKE '%$search%' OR spd.nama_pegawai LIKE '%$search%' OR spd.untuk LIKE '%$search%' OR pegawai.nip LIKE '%$search% OR spd.status LIKE '%$search%'";
        } else {
            $attr_order = "spd.id != ''";
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
        $builder = $this->db->table('spd');
        $query = $builder->select('spd.*')
                ->select('spd.kode AS kodes')
                ->select('pegawai.nip', 'pegawai.nama')
                ->select('instansi.kode', 'instansi.nama_instansi')
                ->join('pegawai', 'pegawai.nip = spd.diperintah', 'left')
                ->join('instansi', 'instansi.kode = spd.kode_instansi', 'left')
                ->where($attr_order)
                ->orderBy($result_order, $result_dir)
                ->limit(service('request')->getPost('length'), service('request')->getPost('start'))
                ->get();
        return $query->getResult();

    }

    function count_all(){
        $sQuery = "SELECT COUNT(id) as total FROM etbl_spd";
        $query = $this->db->query($sQuery)->getRow();
        return $query;
    }

    function count_filter(){
        // Kondisi Order
        if(service('request')->getPost('search')['value']){
            $search = service('request')->getPost('search')['value'];
            $attr_order = " AND (etbl_spd.kode LIKE '%$search%' OR etbl_spd.nama_pegawai LIKE '%$search%' OR etbl_spd.untuk LIKE '%$search%' OR etbl_pegawai.nip LIKE '%$search%' OR etbl_spd.status LIKE '%$search%')";
        } else {
            $attr_order = " ";
        }
        $sQuery = "SELECT COUNT(etbl_spd.id) as total FROM etbl_spd
                    LEFT JOIN etbl_pegawai ON etbl_pegawai.nip = etbl_spd.diperintah
                    LEFT JOIN etbl_instansi ON etbl_instansi.kode = etbl_spd.kode_instansi
                    WHERE etbl_spd.id != '' $attr_order";
        $query = $this->db->query($sQuery)->getRow();
        return $query;
    }
}
