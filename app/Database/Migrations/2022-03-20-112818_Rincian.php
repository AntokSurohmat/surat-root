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
            'rincian_sbuh'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '25',
            ],
            'jumlah_uang'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '8',
            ],
            'keterangan_sbuh'   => [
                'type'              => 'VARCHAR',
                'constraint'        => '50',
            ],
            'jumlah_total'       => [
                'type'              => 'VARCHAR',
                'constraint'        => '10',
            ],
            'awal'              => [
                'type'              => 'DATE',
            ],
            'akhir'             => [
                'type'              => 'DATE',
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
            'detail'            => [
                'type'              => 'JSON',
                'null'              => true,
                'defaul'            => '{}',
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
        $this->forge->addForeignKey('kode_spd', 'spd', 'kode', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('yang_menyetujui', 'pegawai', 'nip', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('bendahara', 'pegawai', 'nip', 'CASCADE', 'NO ACTION');
        $this->forge->createTable('rincian');
    }

    public function down()
    {
        {
            $this->forge->dropForeignKey('spd', 'etbl_rincian_kode_spd_foreign');
            $this->forge->dropForeignKey('pegawai', 'etbl_rincian_yang_menyetujui_foreign');
            $this->forge->dropForeignKey('pegawai', 'etbl_rincian_bendahara_foreign');
            $this->forge->dropTable('rincian');     
        }
    }
}
