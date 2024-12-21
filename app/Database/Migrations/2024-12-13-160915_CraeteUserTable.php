<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CraeteUserTable extends Migration
{
    public function up()
    {
        //
        $this->db->disableForeignKeyChecks();

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'username'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => false, 'unique' => true],
            'password'      => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => false],
            'phone'         => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => true],
            'birth_date'    => ['type' => 'DATE', 'null' => true],
            'nim'           => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true, 'unique' => true],
            'is_new'        => ['type' => 'BOOLEAN', 'default' => true],
            'role_id'       => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => true],
            'study_id'      => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => true],
            'created_by'    => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => true],
            'created_at'    => ['type' => 'DATETIME'],
            'updated_at'    => ['type' => 'DATETIME'],
            'deleted_at'    => ['type' => 'DATETIME'],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'SET NULL', 'SET NULL', 'role_id');
        $this->forge->addForeignKey('study_id', 'program_studies', 'id', 'SET NULL', 'SET NULL', 'study_id');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'SET NULL', 'created_by');
        $this->forge->createTable('users');

        $this->db->enableForeignKeyChecks();
    }
    public function down()
    {
        //
        $this->db->disableForeignKeyChecks();

        $this->forge->dropTable('users');

        $this->db->enableForeignKeyChecks();
    }
}
