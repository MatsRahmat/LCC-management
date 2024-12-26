<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeAnswereFeedbackTable extends Migration
{
    public function up()
    {
        //
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'answer'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'question_id'       => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => false],
            'period_id'         => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => false],
            'answere_by'        => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => false],
            'created_at'        => ['type' => 'DATETIME'],
            'updated_at'        => ['type' => 'DATETIME'],
            'deleted_at'        => ['type' => 'DATETIME'],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('question_id', 'question_feedbacks', 'id', 'CASCADE', 'CASCADE', 'Fk_question_feedback_answere');
        $this->forge->addForeignKey('period_id', 'question_periods', 'id', 'CASCADE', 'CASCADE', 'Fk_period_answere');
        $this->forge->addForeignKey('answere_by', 'users', 'id', 'CASCADE', 'CASCADE', 'Fk_user_answere');
        $this->forge->createTable('answere_feedbacks');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('answere_feedbacks');
        $this->db->enableForeignKeyChecks();
    }
}
