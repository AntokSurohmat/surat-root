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
    'rincian_biaya_1', 'jumlah_biaya_1', 'bukti_1',
    'rincian_biaya_2', 'jumlah_biaya_2', 'bukti_2',
    'rincian_biaya_3', 'jumlah_biaya_3', 'bukti_3',
    'rincian_biaya_4', 'jumlah_biaya_4', 'bukti_4',
    'rincian_biaya_5', 'jumlah_biaya_5', 'bukti_5',
    'jumlah_total', 'yang_menyetujui', 'bendahara'
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
        'rincian_biaya_1' => 'permit_empty|max_length[25]',
        'jumlah_biaya_1'  => 'permit_empty|numeric|max_length[8]',
        'bukti_1'   => 'permit_empty',
        'rincian_biaya_2' => 'permit_empty|max_length[25]',
        'jumlah_biaya_2'  => 'permit_empty|numeric|max_length[8]',
        'bukti_2'   => 'permit_empty',
        'rincian_biaya_3' => 'permit_empty|max_length[25]',
        'jumlah_biaya_3'  => 'permit_empty|numeric|max_length[8]',
        'bukti_3'   => 'permit_empty',
        'rincian_biaya_4' => 'permit_empty|max_length[25]',
        'jumlah_biaya_4'  => 'permit_empty|numeric|max_length[8]',
        'bukti_4'   => 'permit_empty',
        'rincian_biaya_5' => 'permit_empty|max_length[25]',
        'jumlah_biaya_5'  => 'permit_empty|numeric|max_length[8]',
        'bukti_5'   => 'permit_empty',
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
