<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

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
            ],
            'nama_pegawai'      => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
            ],
            'dasar'             => [
                'type'              => 'varchar',
                'constraint'        => '50',
            ],
            'untuk'             => [
                'type'              => 'varchar',
                'constraint'        => '50',
            ],
            'kode_instansi'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'alamat_instansi'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
            ],
            'awal'              => [
                'type'              => 'DATE',
            ],
            'akhir'             => [
                'type'              => 'DATE',
            ],
            'lama'              => [
                'type'              => 'INT',
                'constraint'         => 2
            ],
            'diperintah'        => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
            ],
            'status'        => [
                'type'              => 'ENUM',
                'constraint'        => ['Pending','Revisi','Disetujui'],
                'default'           => 'Pending',
            ],
            'keterangan'             => [
                'type'              => 'varchar',
                'constraint'        => '20',
                'null'              => null
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
        $this->forge->addForeignKey('kode_instansi', 'instansi', 'kode');
        $this->forge->addForeignKey('diperintah', 'pegawai', 'nip');
        $this->forge->createTable('spt');
    }

    public function down()
    {
        $this->forge->dropKey('spt', 'kode');
        $this->forge->dropForeignKey('instansi', 'etbl_spt_kode_instansi_foreign');
        $this->forge->dropForeignKey('pegawai', 'etbl_spt_diperintah_foreign');
        $this->forge->dropTable('spt');
    }
}
