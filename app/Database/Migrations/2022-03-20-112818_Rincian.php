<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rincian extends Migration
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
            'kode_spd'              => [
                'type'              => 'VARCHAR',
                'constraint'        => '3',
                'null'              => true
            ],
            'awal'              => [
                'type'              => 'DATE',
            ],
            'akhir'             => [
                'type'              => 'DATE',
            ],
            'rincian_biaya_1'    => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
                'null'              => true,
            ],
            'jumlah_biaya_1'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '9',
                'null'              => true,
            ],
            'keterangan_1'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
            ],
            'rincian_biaya_2'    => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
                'null'              => true,
            ],
            'jumlah_biaya_2'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '9',
                'null'              => true,
            ],
            'keterangan_2'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
            ],
            'rincian_biaya_3'    => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
                'null'              => true,
            ],
            'jumlah_biaya_3'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '9',
                'null'              => true,
            ],
            'keterangan_3'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
            ],
            'rincian_biaya_4'    => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
                'null'              => true,
            ],
            'jumlah_biaya_4'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '9',
                'null'              => true,
            ],
            'keterangan_4'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
            ],
            'rincian_biaya_5'    => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
                'null'              => true,
            ],
            'jumlah_biaya_5'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '9',
                'null'              => true,
            ],
            'keterangan_5'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
            ],
            'rincian_biaya_6'    => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
                'null'              => true,
            ],
            'jumlah_biaya_6'     => [
                'type'              => 'VARCHAR',
                'constraint'        => '9',
                'null'              => true,
            ],
            'keterangan_6'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
            ],
            'jumlah_uang'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '8',
            ],
            'jumlah_total'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '10',
            ],
            'yang_menyetujui' => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
                'null'              => true,
            ],
            'bendahara'         => [
                'type'              => 'VARCHAR',
                'constraint'        => '25'
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
        $this->forge->addForeignKey('kode_spd', 'spd', 'kode');
        $this->forge->createTable('rincian');
    }

    public function down()
    {
        {
            $this->forge->dropForeignKey('spd', 'etbl_rincian_kode_spd_foreign');
            $this->forge->dropTable('rincian');     
        }
    }
}
