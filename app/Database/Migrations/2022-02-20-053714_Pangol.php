<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pangol extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode'          => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
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
        $this->forge->addKey('kode', false, true);
        $this->forge->createTable('pangol');
    }

    public function down()
    {
        $this->forge->dropTable('pangol');
    }
}
