<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'pegawai';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nip', 'nama', 'tgl_lahir', 'id_jabatan', 'id_pangol', 'pelaksana', 'foto', 'username', 'password', 'level'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nip' => 'required|numeric|max_length[25]',
        'nama' => 'required|max_length[50]',
        'tgl_lahir' => 'required',
        'id_jabatan' => 'required|numeric|max_length[5]',
        'id_pangol' => 'required|numeric|max_length[5]',
        'pelaksana' => 'required',
        'foto'  => 'required',
        'username' => 'required|max_length[20]',
        'password' => 'requred|max_length[20]',
        'level' => 'required',
    ];
    protected $validationMessages   = [
        'nip' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 25 Karakter'
        ],
        'nama' => [
            'max_length' => 'Maksimal 50 Karakter',
        ],
        'id_jabatan' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            'max_length' => 'Maksimal 5 Karakter'
        ],
        'id_jabatan' => [
            'numeric' => 'Hanya Boleh Memasukkan Angka',
            
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
