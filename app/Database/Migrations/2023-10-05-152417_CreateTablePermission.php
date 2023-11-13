<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePermission extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_permission' => [
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
            'can_read' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'can_show' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'can_update' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'can_delete' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
        ]);

        $this->forge->addPrimaryKey('id_permission');
        $this->forge->addForeignKey('id_emp', 'employee', 'id_emp');
        $this->forge->createTable('permissions');
    }

    public function down()
    {
        $this->forge->dropTable('permissions');
    }
}
