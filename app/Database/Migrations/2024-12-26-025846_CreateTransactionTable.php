<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionTable extends Migration
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
            'amount'            => ['type' => 'FLOAT'],
            'desc'              => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'type_id'           => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true],
            'created_by'        => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => true],
            'created_at'        => ['type' => 'DATETIME'],
            'updated_at'        => ['type' => 'DATETIME'],
            'deleted_at'        => ['type' => 'DATETIME'],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('type_id', 'transaction_types', 'id', 'CASCADE', 'CASCADE', 'Fk_transaction_type');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'SET NULL', 'Fk_transaction_users');
        $this->forge->createTable('transactions');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('transactions');
        $this->db->enableForeignKeyChecks();
    }
}
