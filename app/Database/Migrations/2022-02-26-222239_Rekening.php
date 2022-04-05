<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rekening extends Migration
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
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'kode_jenis_wilayah'  => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'nomer_rekening'    => [
                'type'              => 'VARCHAR',
                'constraint'        => 12,
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
        $this->forge->addForeignKey('kode_jenis_wilayah', 'jenis_wilayah', 'kode', 'NO ACTION', 'CASCADE');
        $this->forge->createTable('rekening');
    }

    public function down()
    {
        $this->forge->dropForeignKey('jenis_wilayah', 'etbl_rekening_kode_jenis_wilayah_foreign');
        $this->forge->dropTable('rekening');
    }
}
