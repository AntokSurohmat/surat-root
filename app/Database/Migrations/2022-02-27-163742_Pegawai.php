<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pegawai extends Migration
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
            'nip'               => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
            ],
            'nama'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
                'null'              => false,
            ],
            'tgl_lahir'         => [
                'type'              => 'DATE',
                'null'              => true,
            ],
            'kode_jabatan'        => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'kode_pangol'         => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'pelaksana'         => [
                'type'              => 'ENUM',
                'constraint'        => ['Kasi Pelayan','Kasi Pengawasan'],
                'default'           => 'Kasi Pelayan',
            ],
            'foto'              => [
                'type'              => 'VARCHAR',
				'constraint'        => '255',
                'default'           => 'custom/img/foto/default.png',
            ],
            'username'          => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
                'null'              => false,
            ],
            'password'          => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'level'             => [
                'type'              => 'ENUM',
                'constraint'        => ['Admin','Kepala Bidang','Bendahara','Pegawai'],
                'default'           => 'Pegawai',
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
        $this->forge->addKey('kode');
        $this->forge->addUniqueKey('username');
        $this->forge->addForeignKey('kode_jabatan', 'jabatan', 'kode');
        $this->forge->addForeignKey('kode_pangol', 'pangol', 'kode');
        $this->forge->createTable('pegawai');
    }

    public function down()
    {
        $this->forge->dropKey('pegawai', 'username');
        $this->forge->dropForeignKey('jabatan', 'etbl_pegawai_kode_jabatan_foreign');
        $this->forge->dropForeignKey('pangol', 'etbl_pegawai_kode_pangol_foreign');
        $this->forge->dropTable('pegawai');
    }
}
