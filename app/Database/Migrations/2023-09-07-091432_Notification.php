<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notification extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_notifications' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_emp' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_tache' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'content' => [
                'type' => 'TEXT',
            ],
            'is_read' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'showin' => [
                'type' => 'ENUM',
                'constraint' => ['unseen', 'seen'],
                "default"=>'unseen',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id_notifications', true);
        $this->forge->addForeignKey('id_emp', 'employee', 'id_emp');
        $this->forge->addForeignKey('id_tache', 'tache', 'id_tache');
        $this->forge->createTable('notifications', true);
    }

    public function down()
    {
        $this->forge->dropTable('notifications', true);
    }
}
