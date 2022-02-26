<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jeniswilayah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
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
            'jenis_wilayah'   => [
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
        $this->forge->createTable('jenis_wilayah');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_jenis_wilayah_id_provinsi_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_jenis_wilayah_id_kabupaten_foreign');
        $this->forge->dropTable('jenis_wilayah');
    }
}
