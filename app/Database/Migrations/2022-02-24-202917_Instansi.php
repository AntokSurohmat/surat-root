<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Instansi extends Migration
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
            'nama_instansi'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '20',
                'null'              => true,
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
        $this->forge->addForeignKey('kode_kabupaten', 'kabupaten', 'kode');
        $this->forge->addForeignKey('kode_kecamatan', 'kecamatan', 'kode');
        $this->forge->createTable('instansi');
    }

    public function down()
    {
        $this->forge->dropForeignKey('provinsi', 'etbl_wilayah_kode_provinsi_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_wilayah_kode_kabupaten_foreign');
        $this->forge->dropForeignKey('kabupaten', 'etbl_wilayah_kode_kecamatan_foreign');
        $this->forge->dropTable('instansi');
    }
}
