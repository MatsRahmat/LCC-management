<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentAttachmenentTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 2,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'filename'          => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => false],
            'original_name'     => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => false],
            'size'              => ['type' => 'INT', 'unsigned' => true],
            'url'               => ['type' => 'VARCHAR', 'constraint' => 100],
            'desc'              => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_by'        => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => true],
            'created_at'        => ['type' => 'DATETIME'],
            'updated_at'        => ['type' => 'DATETIME'],
            'deleted_at'        => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'SET NULL', 'Fk_payment_attachment_users');
        $this->forge->createTable('payment_attachments');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('payment_attachments');
        $this->db->enableForeignKeyChecks();
    }
}
