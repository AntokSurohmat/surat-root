<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Zonasi extends Migration
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
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'kode_kabupaten'    => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'kode_kecamatan'    => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'kode'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
            ],
            'nama_zonasi'       => [
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
        $this->forge->addKey('kode', false, true);
        $this->forge->addForeignKey('kode_provinsi', 'provinsi', 'kode', 'CASCADE', 'NO ACTION',);
        $this->forge->addForeignKey('kode_kabupaten', 'kabupaten', 'kode', 'CASCADE', 'NO ACTION',);
        $this->forge->addForeignKey('kode_kecamatan', 'kecamatan', 'kode', 'CASCADE', 'NO ACTION',);
        $this->forge->createTable('zonasi');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_zonasi_kode_provinsi_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_zonasi_kode_kabupaten_foreign');
        $this->forge->dropForeignKey('kecamatan', 'etbl_zonasi_kode_kecamatan_foreign');
        $this->forge->dropTable('zonasi');
    }
}
