<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kuitansi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => [
                'type'              => 'INT',
                'constraint'        => 10,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'kode_spd'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '3',
                'null'              => true
            ],
            'pegawai_all'      => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'pegawai_diperintah' => [
                'type'              => 'VARCHAR',
                'constraint'        => '25'
            ],
            'nip_pegawai'               => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
            ],
            'kode_pangol'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'kode_jabatan'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'untuk'             => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
            ],
            'kode_instansi'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'awal'              => [
                'type'              => 'DATE',
            ],
            'akhir'             => [
                'type'              => 'DATE',
            ],
            'lama'              => [
                'type'              => 'INT',
                'constraint'        => 2
            ],
            'kode_rekening'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
                'null'              => true
            ],
            'pejabat'        => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
            ],
            'jumlah_uang'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '8',
            ],
            'created_at'        => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_at'        => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at'        => [
                'type'              => 'DATETIME',
                'null'              => true,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kode_spd', 'spd', 'kode');
        $this->forge->addForeignKey('kode_instansi', 'instansi', 'kode');
        $this->forge->addForeignKey('pejabat', 'pegawai', 'nip');
        $this->forge->addForeignKey('kode_rekening', 'rekening', 'kode');
        $this->forge->createTable('kuitansi');
    }

    public function down()
    {
        $this->forge->dropForeignKey('spd', 'etbl_kuitansi_kode_spd_foreign');
        $this->forge->dropForeignKey('instansi', 'etbl_kuitansi_kode_instansi_foreign');
        $this->forge->dropForeignKey('pegawai', 'etbl_kuitansi_diperintah_foreign');
        $this->forge->dropForeignKey('rekening', 'etbl_kuitansi_kode_rekening_foreign');
        $this->forge->dropTable('kuitansi');     
    }
}
