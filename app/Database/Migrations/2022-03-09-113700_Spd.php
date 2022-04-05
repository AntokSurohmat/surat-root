<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PHPUnit\Framework\Constraint\Constraint;

class Spd extends Migration
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
            'kode'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '3',
                'null'              => true
            ],
            'kode_spt'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '3',
            ],
            'pejabat'        => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
            ],
            'pegawai_all'      => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
            ],
            'pegawai_diperintah'             => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => true
            ],
            'tingkat_biaya'     => [
                'type'              => 'ENUM',
                'constraint'        =>  ['Tingkat A', 'Tingkat B', 'Tinkat C'],
                'default'           => 'Tingkat A'
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
            'keterangan'        => [
                'type'              => 'varchar',
                'constraint'        => '20',
                'null'              => true
            ],
            'jenis_kendaraan'   => [
                'type'              => 'ENUM',
                'constraint'        =>  ['Bus', 'Kapal', 'Kereta Api', 'Mobil Dinas', 'Motor Dinas', 'Pesawat'],
                'default'           => 'Bus'
            ],
            'status'            => [
                'type'              => 'ENUM',
                'constraint'        => ['true', 'false'],
                'default'           => 'false',
            ],
            'yang_menyetujui' => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
                'null'              => true,
            ],
            'detail'            => [
                'type'              => 'JSON',
                'null'              => true,
                'defaul'            => '{}',
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
        $this->forge->addUniqueKey('kode');
        $this->forge->addForeignKey('kode_spt', 'spt', 'kode', 'NO ACTION', 'CASCADE');
        $this->forge->addForeignKey('kode_instansi', 'instansi', 'kode', 'NO ACTION', 'CASCADE');
        $this->forge->addForeignKey('pejabat', 'pegawai', 'nip', 'NO ACTION', 'CASCADE');
        $this->forge->addForeignKey('kode_rekening', 'rekening', 'kode', 'NO ACTION', 'CASCADE');
        $this->forge->createTable('spd');
    }

    public function down()
    {
        $this->forge->dropKey('spd', 'kode');
        $this->forge->dropForeignKey('spt', 'etbl_spd_kode_spt_foreign');
        $this->forge->dropForeignKey('instansi', 'etbl_spd_kode_instansi_foreign');
        $this->forge->dropForeignKey('pegawai', 'etbl_spd_diperintah_foreign');
        $this->forge->dropForeignKey('rekening', 'etbl_spd_kode_rekening_foreign');
        $this->forge->dropTable('spd');
    }
}
