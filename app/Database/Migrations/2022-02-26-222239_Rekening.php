<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rekening extends Migration
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
            'id_jenis_wilayah'   => [
                'type'          => 'BIGINT',
                'constraint'    => 20,
                'unsigned'      => true,
            ],
            'nomer_rekening'   => [
                'type'          => 'BIGINT',
                'constraint'    => 12,
                'unsigned'      => true,
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
        $this->forge->addForeignKey('id_jenis_wilayah', 'jenis_wilayah', 'id');
        $this->forge->createTable('rekening');
    }

    public function down()
    {
        $this->forge->dropForeignKey('jenis_wilayah', 'etbl_rekening_id_jenis_wilayah_foreign');
        $this->forge->dropTable('rekening');
    }
}
