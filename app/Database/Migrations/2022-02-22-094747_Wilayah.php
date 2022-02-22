<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Wilayah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode'          => [
                'type'          => 'BIGINT',
                'constraint'    => 10,
                'unsigned'      => true,
            ],
            'id_provinsi'          => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
            ],
            'id_kabupaten'          => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
            ],
            'id_kecamatan'          => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
            ],
            'jenis_wilayah'   => [
                'type'          => 'VARCHAR',
                'constraint'    => '40',
                'null'          => true,
            ],
            'zonasi'   => [
                'type'          => 'VARCHAR',
                'constraint'    => '40',
                'null'          => true,
            ],
            'created_at'    => [
                'type'          => 'DATETIME',
                'null'          => true,
            ],
            'updated_at'     => [
                'type'          => 'DATETIME',
                'null'          => true,
            ],
            'deleted_at'    => [
                'type'          => 'DATETIME',
                'null'          => true,
            ]

        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_provinsi', 'provinsi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kabupaten', 'kabupaten', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kecamatan', 'kecamatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('wilayah');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_wilayah_id_provinsi_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_wilayah_id_kabupaten_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_wilayah_id_kecamatan_foreign');
        $this->forge->dropTable('wilayah');
    }
}
