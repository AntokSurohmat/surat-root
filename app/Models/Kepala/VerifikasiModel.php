<?php

namespace App\Models\Kepala;

use CodeIgniter\Model;

class VerifikasiModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'spt';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['status','keterangan', 'yang_menyetujui'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'status' => 'required',
        'keterangan' => 'permit_empty|max_length[20]',
        'yang_menyetujui' => 'required|max_length[25]'

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
