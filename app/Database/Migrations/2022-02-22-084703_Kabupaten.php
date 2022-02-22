<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kabupaten extends Migration
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
            'nama_kabupaten'   => [
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
        $this->forge->createTable('kabupaten');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_kabupaten_id_provinsi_foreign');
        $this->forge->dropTable('kabupaten');
    }
}
