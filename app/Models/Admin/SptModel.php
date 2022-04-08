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
    protected $allowedFields    = ['kode', 'pegawai_all', 'dasar', 'untuk', 'kode_instansi', 'alamat_instansi', 'awal', 'akhir', 'lama', 'pejabat', 'status', 'keterangan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode' => 'required|numeric|max_length[3]',
        'pegawai_all' => 'required|max_length[100]',
        'dasar' => 'required|max_length[50]',
        'untuk' => 'required|max_length[50]',
        'kode_instansi' => 'required|numeric|max_length[20]',
        'alamat_instansi' => 'required|max_length[50]',
        'awal' => 'required',
        'akhir' => 'required',
        'lama' => 'required|numeric|max_length[2]',
        'pejabat' => 'required|numeric|max_length[25]',
        'status' => 'required',
        'keterangan' => 'max_length[20]'
    ];
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


}
