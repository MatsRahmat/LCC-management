<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostAttachmentTable extends Migration
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
            'filename'          => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => false],
            'original_name'     => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => false],
            'size'              => ['type' => 'INT', 'unsigned' => true],
            'url'               => ['type' => 'VARCHAR', 'constraint' => 100],
            'post_id'           => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'null' => true],
            'created_at'        => ['type' => 'DATETIME'],
            'updated_at'        => ['type' => 'DATETIME'],
            'deleted_at'        => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('post_id', 'posts', 'id', 'CASCADE', 'CASCADE', 'Fk_attachment_post');
        $this->forge->createTable('post_attachments');
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('post_attachments');
        $this->db->enableForeignKeyChecks();
    }
}
