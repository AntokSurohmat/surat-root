<?php

namespace App\Models\Admin;

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
    protected $allowedFields    = [
        'kode', 'kode_spt', 'pejabat',
        'pegawai_all', 'pegawai_diperintah',
        'tingkat_biaya', 'untuk',
        'kode_instansi', 'awal',
        'akhir', 'lama',
        'kode_rekening', 'keterangan',
        'jenis_kendaraan', 'status',
        'yang_menyetujui','detail'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode' => 'required|numeric|max_length[3]',
        'kode_spt' => 'required|numeric|max_length[3]',
        'pegawai_all' => 'required|max_length[100]',
        'untuk' => 'required|max_length[50]',
        'kode_instansi' => 'required|max_length[20]',
        'lama'  => 'required|numeric|max_length[2]',
        'kode_rekening' => 'required|max_length[20]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = true;
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
