<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kecamatan extends Migration
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
            'nama_kecamatan'   => [
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
        $this->forge->addForeignKey('id_provinsi', 'provinsi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kabupaten', 'kabupaten', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kecamatan');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_kecamatan_id_provinsi_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_kecamatan_id_kabupaten_foreign');
        $this->forge->dropTable('kecamatan');
    }
}
