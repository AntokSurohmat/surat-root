<?php

namespace App\Models\Bendahara;

use CodeIgniter\Model;

class RincianModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'rincian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
    'kode_spd', 'rincian_sbuh', 'jumlah_uang', 'keterangan_sbuh',
    'awal', 'akhir', 
    'jumlah_total', 'yang_menyetujui', 'bendahara', 'detail'
];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode_spd' => 'required|numeric|max_length[3]',
        'rincian_sbuh' => 'required|max_length[25]',
        'jumlah_uang'   => 'required|numeric|max_length[8]',
        'awal' => 'required',
        'akhir' => 'required',
        'rincian_biaya' => 'permit_empty',
        'jumlah_biaya'  => 'permit_empty',
        'bukti'   => 'permit_empty',
        'jumlah_total'  => 'required|numeric|max_length[10]',
        'yang_menyetujui' => 'required|numeric|max_length[25]',
        'bendahara' => 'required|numeric|max_length[25]'
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
