<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tujuan extends Migration
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
                'type'           => 'VARCHAR',
                'constraint'     => '20',
            ],
            'tujuan' => [
                'type'          => 'TEXT',
            ],
            'pelaksana'         => [
                'type'              => 'ENUM',
                'constraint'        => ['Kasi Pelayan','Kasi Pengawasan'],
                'null'              => true,
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
        $this->forge->addKey('kode');
        $this->forge->createTable('tujuan');
    }

    public function down()
    {
        $this->forge->dropTable('tujuan');
    }
}
