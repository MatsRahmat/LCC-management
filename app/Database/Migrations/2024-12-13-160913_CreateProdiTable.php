<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdiTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'name' => ['type' => 'VARCHAR', 'constraint' => 50],
            'code' => ['type' => 'VARCHAR', 'constraint' => 5]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('program_studies');
    }

    public function down()
    {
        //
        $this->forge->dropTable('program_studies');
    }
}
