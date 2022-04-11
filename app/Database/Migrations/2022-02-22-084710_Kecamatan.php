<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kecamatan extends Migration
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
            'kode_kabupaten'    => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'kode'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'nama_kecamatan'    => [
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
        $this->forge->addForeignKey('kode_kabupaten', 'kabupaten', 'kode', 'CASCADE', 'NO ACTION',);
        $this->forge->createTable('kecamatan');
    }

    public function down()
    {
        $this->forge->dropForeignKey('kabupaten', 'etbl_kecamatan_kode_kabupaten_foreign');
        $this->forge->dropTable('kecamatan');
    }
}
