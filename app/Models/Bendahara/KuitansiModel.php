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
    protected $allowedFields    = ['kode_spd', 'pegawai_all','pegawai_diperintah', 'nip_pegawai', 'kode_pangol', 'kode_jabatan', 'untuk', 'kode_instansi', 'awal', 'akhir', 'lama', 'kode_rekening', 'pejabat', 'jumlah_uang','yang_menyetujui','bendahara'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'kode_spd' => 'required|numeric|max_length[3]',
        'pegawai_all' => 'required|max_length[100]',
        'pegawai_diperintah' => 'required|numeric|max_length[25]',
        'nip_pegawai' => 'required|numeric|max_length[25]',
        'kode_pangol' => 'required|numeric|max_length[20]',
        'kode_jabatan' => 'required|numeric|max_length[20]',
        'untuk' => 'required|max_length[50]',
        'kode_instansi' => 'required|numeric|max_length[20]',
        'awal' => 'required',
        'akhir' => 'required',
        'lama' => 'required|numeric|max_length[2]',
        'kode_rekening' => 'required|numeric|max_length[20]',
        'pejabat' => 'required|numeric|max_length[25]',
        'jumlah_uang' => 'required|max_length[8]',
        'yang_menyetujui' => 'required|numeric|max_length[25]',
        'bendahara' => 'required|numeric|max_length[25]',

    ];
    protected $validationMessages   = [
        'kode_spd' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' =>  '{field} Maksimal 3 Karakter'
        ],
        'pegawai_all' => [
            'max_length' =>  '{field} Maksimal 100 Karakter'
        ],
        'pegawai_diperintah' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' =>  '{field} Maksimal 3 Karakter'
        ],
        'nip_pegawai' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' =>  '{field} Maksimal 25 Karakter'
        ],
        'kode_pangol' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter'
        ],
        'kode_jabatan' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter'
        ],
        'untuk' => [
            'max_length' => '{field} Maksimal 50 Karakter'
        ],
        'kode_instansi' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter'
        ],
        'lama' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 2 Karakter'
        ],
        'kode_rekening' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 20 Karakter'
        ],
        'pejabat' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 25 Karakter'
        ],
        'jumlah_uang' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 8 Karakter'
        ],
        'yang_menyetujui' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 25 Karakter'
        ],
        'bendahara' => [
            'numeric' => '{field} Hanya Boleh Memasukkan Angka',
            'max_length' => '{field} Maksimal 25 Karakter'
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
