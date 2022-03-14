<?php

namespace App\Models\Bendahara;

use CodeIgniter\Model;

class KuitansiModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'kuitansi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_spd', 'nama_pegawai', 'nip_pegawai', 'kode_pangol', 'kode_jabatan', 'untuk', 'kode_instansi', 'awal', 'akhir', 'lama', 'kode_rekening', 'pejabat', 'jumlah_uang'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode_spd' => 'trim|required',
        'nama_pegawai' => 'required',
        'nip_pegawai' => 'trim|required|numeric|max_length[25]',
        'kode_pangol' => 'trim|required|numeric|max_length[20]',
        'kode_jabatan' => 'trim|required|numeric|max_length[20]',
        'untuk' => 'required|max_length[50]',
        'kode_instansi' => 'trim|required|numeric|max_length[20]',
        'awal' => 'trim|required',
        'akhir' => 'trim|required',
        'lama' => 'trim|required|numeric|max_length[2]',
        'kode_rekening' => 'trim|required|numeric|max_length[20]',
        'pejabat' => 'trim|required|numeric|max_length[20]',
        'jumlah_uang' => 'trim|required|max_length[8]'

    ];
    protected $validationMessages   = [];
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
