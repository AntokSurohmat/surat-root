<?php

namespace App\Models\Admin;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class InstansiModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'instansi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'nama_instansi','kode_provinsi', 'kode_kabupaten', 'kode_kecamatan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode_provinsi' => 'required|numeric|max_length[20]',
        'kode_kabupaten' => 'required|numeric|max_length[20]',
        'kode_kecamatan' => 'required|numeric|max_length[20]',
        'kode' => 'required|numeric|max_length[20]',
        'nama_instansi' => 'required|max_length[20]',
    ];
    protected $validationMessages   = [
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
        'kode' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'nama_instansi' => [
            'max_length' => 'Maksimal 40 Karakter'
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
    var $column_order = array(null,  'instansi.kode', 'instansi.nama_instansi', 'provinsi.nama_provinsi', 'kabupaten.nama_kabupaten', 'kecamatan.nama_kecamatan', null);
    var $order = array('instansi.id' => 'DESC');

    function get_datatables()
    {

        // search
        if (service('request')->getPost('search')['value']) {
            $search = service('request')->getPost('search')['value'];
			$attr_order = "instansi.kode LIKE '%$search%' OR provinsi.nama_provinsi LIKE '%$search%' OR kabupaten.nama_kabupaten LIKE '%$search%' OR kecamatan.nama_kecamatan LIKE '%$search%'";
        } else {
            $attr_order = "instansi.id != ''";
        }

        // order
        if (service('request')->getPost('order')) {
            $result_order = $this->column_order[service('request')->getPost('order')['0']['column']];
            $result_dir = service('request')->getPost('order')['0']['dir'];
        } else if ($this->order) {
            $order = $this->order;
            $result_order = key($order);
            $result_dir = $order[key($order)];
        }


        if (service('request')->getPost('length') != -1);
        // $db = db_connect();
        $builder = $this->db->table('instansi');
        $query = $builder->select('instansi.*')
            ->select('provinsi.kode', 'provinsi.nama_provinsi')
            ->select('kabupaten.kode', 'kabupaten.nama_kabupaten')
            ->select('kecamatan.kode', 'kecamatan.nama_kecamatan')
            ->join('provinsi', 'provinsi.kode = instansi.kode_provinsi', 'left')
            ->join('kabupaten', 'kabupaten.kode = instansi.kode_kabupaten', 'left')
            ->join('kecamatan', 'kecamatan.kode = instansi.kode_kecamatan', 'left')
            ->where($attr_order)
            ->orderBy($result_order, $result_dir)
            ->limit(service('request')->getPost('length'), service('request')->getPost('start'))
            ->get();
        return $query->getResult();
    }


    function count_all()
    {
        $sQuery = "SELECT COUNT(id) as total FROM etbl_instansi";
        $query = $this->db->query($sQuery)->getRow();
        return $query;
    }

    function count_filter()
    {
        // Kondisi Order
        if (service('request')->getPost('search')['value']) {
            $search = service('request')->getPost('search')['value'];
			$attr_order = " AND (etbl_instansi.kode LIKE '%$search%' OR etbl_provinsi.nama_provinsi LIKE '%$search%' OR etbl_kabupaten.nama_kabupaten LIKE '%$search%' OR etbl_kecamatan.nama_kecamatan LIKE '%$search%')";
        } else {
            $attr_order = " ";
        }
		$sQuery = "SELECT COUNT(etbl_instansi.id) as total FROM etbl_instansi
                    LEFT JOIN etbl_provinsi ON etbl_provinsi.kode = etbl_instansi.kode_provinsi
                    LEFT JOIN etbl_kabupaten ON etbl_kabupaten.kode = etbl_instansi.kode_kabupaten
                    LEFT JOIN etbl_kecamatan ON etbl_kecamatan.kode = etbl_instansi.kode_kecamatan
                    WHERE etbl_instansi.id != '' $attr_order";
        $query = $this->db->query($sQuery)->getRow();
        return $query;
    }


    private function _get_datatables_query($term=''){ //term is value of $_REQUEST['search']['value']
        $column = array('k.id_kota','k.nm_kota', 'p.nm_propinsi');
        $this->db->select('k.id_kota, k.nm_kota, p.nm_propinsi');
        $this->db->from('kota as k');
        $this->db->join('propinsi as p', 'p.id_propinsi = k.id_propinsi','left');
        $this->db->like('k.id_kota', $term);
        $this->db->or_like('k.nm_kota', $term);
        $this->db->or_like('p.nm_propinsi', $term);
        if(isset($_REQUEST['order'])) // here order processing
        {
           $this->db->order_by($column[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
           $order = $this->order;
           $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    function get_datatables(){
      $term = $_REQUEST['search']['value'];   
      $this->_get_datatables_query($term);
      if($_REQUEST['length'] != -1)
      $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
      $query = $this->db->get();
      return $query->result(); 
    }
    
    function count_filtered(){
      $term = $_REQUEST['search']['value']; 
      $this->_get_datatables_query($term);
      $query = $this->db->get();
      return $query->num_rows();  
    }
    
    public function count_all(){
      $this->db->from($this->table);
      return $this->db->count_all_results();  
    }
}
