<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFinanceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 2,
                'unsigned'          => true,
            ],
            'total' => [
                'type'          => 'FLOAT',
                'default'       => 0
            ]
        ]);
        $this->forge->createTable('finances');
    }

    public function down()
    {
        $this->forge->dropTable('finances');
    }
}
