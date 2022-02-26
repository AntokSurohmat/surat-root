<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sbuh extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode'          => [
                'type'          => 'BIGINT',
                'constraint'    => 20,
                'unsigned'      => true,
            ],
            'id_provinsi'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'id_kabupaten'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'id_jenis_wilayah'   => [
                'type'          => 'BIGINT',
                'constraint'    => 20,
                'unsigned'      => true,
            ],
            'id_kecamatan'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
            ],
            'id_zonasi'   => [
                'type'          => 'BIGINT',
                'constraint'    => 20,
                'unsigned'      => true,
            ],
            'id_pangol'   => [
                'type'          => 'INT',
                'constraint'    => 10,
                'unsigned'      => true,
            ],
            'nama_zonasi'   => [
                'type'          => 'VARCHAR',
                'constraint'    => '40',
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
        $this->forge->addForeignKey('id_provinsi', 'provinsi', 'id');
        $this->forge->addForeignKey('id_kabupaten', 'kabupaten', 'id');
        $this->forge->addForeignKey('id_jenis_wilayah', 'jenis_wilayah', 'id');
        $this->forge->addForeignKey('id_kecamatan', 'kecamatan', 'id');
        $this->forge->addForeignKey('id_zonasi', 'zonasi', 'id');
        $this->forge->addForeignKey('id_pangol', 'pangol', 'id');
        $this->forge->createTable('sbuh');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_sbuh_id_provinsi_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_sbuh_id_kabupaten_foreign');
        $this->forge->dropForeignKey('kecamatan', 'etbl_sbuh_id_kecamatan_foreign');
        $this->forge->dropForeignKey('jenis_wilayah', 'etbl_sbuh_id_jenis_wilayah_foreign');
        $this->forge->dropForeignKey('zonasi', 'etbl_sbuh_id_zonasi_foreign');
        $this->forge->dropForeignKey('pangol', 'etbl_sbuh_id_pangol_foreign');
        $this->forge->dropTable('sbuh');
    }
}
