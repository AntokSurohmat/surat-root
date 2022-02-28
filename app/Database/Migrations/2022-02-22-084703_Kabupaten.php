<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kabupaten extends Migration
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
            'kode_provinsi'     => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
            ],
            'kode'              => [
                'type'              => 'BIGINT',
                'constraint'        => 20,
                'unsigned'          => true,
            ],
            'nama_kabupaten'    => [
                'type'              => 'VARCHAR',
                'constraint'        => '40',
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
        $this->forge->createTable('kabupaten');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_kabupaten_kode_provinsi_foreign');
        $this->forge->dropTable('kabupaten');
    }
}
