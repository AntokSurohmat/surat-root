<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pangol extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode'          => [
                'type'          => 'BIGINT',
                'constraint'    => 10,
                'unsigned'      => true,
            ],
            'nama_pangol'   => [
                'type'          => 'VARCHAR',
                'constraint'    => '20',
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
        $this->forge->addUniqueKey('kode');
        $this->forge->createTable('pangol');
    }

    public function down()
    {
        $this->forge->dropTable('pangol');
    }
}