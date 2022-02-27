<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Zonasi extends Migration
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
            'id_kecamatan'          => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
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
        $this->forge->addForeignKey('id_kecamatan', 'kecamatan', 'id');
        $this->forge->createTable('zonasi');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_zonasi_id_provinsi_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_zonasi_id_kabupaten_foreign');
        $this->forge->dropForeignKey('kecamatan', 'etbl_zonasi_id_kecamatan_foreign');
        $this->forge->dropTable('zonasi');
    }
}