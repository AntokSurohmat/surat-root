<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Wilayah extends Migration
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
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
            ],
            'kode_provinsi'     => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
            ],
            'kode_kabupaten'    => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
            ],
            'kode_jenis_wilayah'=> [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
            ],
            'kode_kecamatan'    => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
            ],
            'kode_zonasi'       => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
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
        $this->forge->addForeignKey('kode_provinsi', 'provinsi', 'kode');
        $this->forge->addForeignKey('kode_kabupaten', 'kabupaten', 'kode');
        $this->forge->addForeignKey('kode_jenis_wilayah', 'jenis_wilayah', 'kode');
        $this->forge->addForeignKey('kode_kecamatan', 'kecamatan', 'kode');
        $this->forge->addForeignKey('kode_zonasi', 'zonasi', 'kode');
        $this->forge->createTable('wilayah');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_wilayah_kode_provinsi_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_wilayah_kode_kabupaten_foreign');
        $this->forge->dropForeignKey('jenis_wilayah', 'etbl_wilayah_kode_jenis_wilayah_foreign');
        $this->forge->dropForeignKey('kecamatan', 'etbl_wilayah_kode_kecamatan_foreign');
        $this->forge->dropForeignKey('zonasi', 'etbl_wilayah_kode_zonasi_foreign');
        $this->forge->dropTable('wilayah');
    }
}
