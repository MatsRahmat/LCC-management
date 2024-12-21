<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrateRoleTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                // 'auto_increment' => true // make it constant from where insert the data
            ],
            'name' => ['type' => 'VARCHAR', 'constraint' => 30]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('roles');
    }

    public function down()
    {
        //
        $this->forge->dropTable('roles');
    }
}
