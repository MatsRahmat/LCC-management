<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableQuestionFeedback extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'question'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'status'        => ['type' => 'BOOLEAN', 'default' => true],
            'created_by'    => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => true],
            'created_at'    => ['type' => 'DATETIME'],
            'updated_at'    => ['type' => 'DATETIME'],
            'deleted_at'    => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'SET NULL', 'Fk_created_by');
        $this->forge->createTable('question_feedbacks');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('question_feedbacks');
        $this->db->enableForeignKeyChecks();
    }
}
