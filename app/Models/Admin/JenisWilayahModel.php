<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class JenisWilayahModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'jenis_wilayah';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_provinsi', 'id_kabupaten','jenis_wilayah'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_provinsi' => 'required|numeric|max_length[20]',
        'id_kabupaten' => 'required|numeric|max_length[20]',
        'jenis_wilayah' => 'required|max_length[40]'
    ];
    protected $validationMessages   = [
        'id_provinsi' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'id_kabupaten' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter'
        ],
        'jenis_wilayah' => [
            'max_length' => 'Maksimal 40 Karakter'
        ]
    ];
    protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
//     protected $allowCallbacks = true;
//     protected $beforeInsert   = [];
//     protected $afterInsert    = [];
//     protected $beforeUpdate   = [];
//     protected $afterUpdate    = [];
//     protected $beforeFind     = [];
//     protected $afterFind      = [];
//     protected $beforeDelete   = [];
//     protected $afterDelete    = [];
}
