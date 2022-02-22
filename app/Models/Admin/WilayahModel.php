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
    protected $allowedFields    = ['kode', 'id_provinsi', 'id_kabupaten', 'id_kecamatan', 'jenis_wilayah', 'zonasi'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode' => 'required|numeric|max_lenght[10]',
        'id_provinsi' => 'required|numeric|max_lenght[10]',
        'id_kabupaten' => 'required|numeric|max_lenght[10]',
        'id_kecamatan' => 'required|numeric|max_lenght[10]',
        'jenis_wilayah' => 'required|max_lengt[40]',
        'zonasi' => 'required|max_lengt[40]'
    ];
    protected $validationMessages   = [
        'kode' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_lenght' => 'Maksimal 10 Karakter' 
        ],        
        'id_provinsi' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_lenght' => 'Maksimal 10 Karakter' 
        ],
        'id_kabupaten' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_lenght' => 'Maksimal 10 Karakter'
        ],
        'id_kecamatan' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_lenght' => 'Maksimal 10 Karakter'
        ],
        'jenis_wilayah' => [
            'max_lenght' => 'Maksimal 40 Karakter'
        ],
        'zonasi' => [
            'max_lenght' => 'Maksimal 40 Karakter'
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
}
