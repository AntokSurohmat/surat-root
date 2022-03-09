<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class KabupatenModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'kabupaten';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_provinsi', 'kode', 'nama_kabupaten'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode_provinsi' => 'required|numeric|max_length[20]',
        'kode' => 'required|numeric|max_length[20]',
        'nama_kabupaten' => 'required|max_length[40]',
    ];
    protected $validationMessages   = [
        'kode_provinsi' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter',
        ],
        'kode' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 20 Karakter',
        ],
        'nama_kabupate' => [
            'max_length' => 'Maksimal 40 Karakter'
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
}
