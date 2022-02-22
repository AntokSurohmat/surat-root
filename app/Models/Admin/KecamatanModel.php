<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class KecamatanModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'kecamatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kabupaten', 'nama_kecamatan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_kabupaten' => 'required|numeric|max_lenght[10]',
        'nama_kecamatan' => 'required|max_lenght[40]'
    ];
    protected $validationMessages   = [
        'id_kabupaten' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_lenght' => 'Maksimal 10 Karakter'
        ],
        'nama_kecamatan' => [
            'max_lenght' => 'Maksimal 40 Karakter'
        ]
        
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
