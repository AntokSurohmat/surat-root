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
            'id_jenis_wilayah'          => [
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
        $this->forge->addForeignKey('id_jenis_wilayah', 'jenis_wilayah', 'id');
        $this->forge->createTable('zonasi');
    }

    public function down()
    {
        $this->forge->dropForeignKey('jenis_wilayah', 'etbl_zonasi_id_jenis_wilayah_foreign');
        $this->forge->dropTable('zonasi');
    }
}
