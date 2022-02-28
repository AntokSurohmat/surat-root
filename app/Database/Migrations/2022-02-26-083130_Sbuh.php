<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sbuh extends Migration
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
            'kode_pangol'       => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
            ],
            'jumlah_uang'       => [
                'type'              => 'VARCHAR',
                'constraint'        => 6,
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
        $this->forge->addForeignKey('kode_pangol', 'pangol', 'kode');
        $this->forge->createTable('sbuh');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_sbuh_kode_provinsi_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_sbuh_kode_kabupaten_foreign');
        $this->forge->dropForeignKey('kecamatan', 'etbl_sbuh_kode_kecamatan_foreign');
        $this->forge->dropForeignKey('jenis_wilayah', 'etbl_sbuh_kode_jenis_wilayah_foreign');
        $this->forge->dropForeignKey('zonasi', 'etbl_sbuh_kode_zonasi_foreign');
        $this->forge->dropForeignKey('pangol', 'etbl_sbuh_kode_pangol_foreign');
        $this->forge->dropTable('sbuh');
    }
}
