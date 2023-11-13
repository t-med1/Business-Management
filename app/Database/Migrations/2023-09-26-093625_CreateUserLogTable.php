<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserLogTable extends Migration
{
    public function up()
    {
        // Define the user_log table
        $this->forge->addField([
            'id_user_log' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_emp'=>[
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'ip_adresse' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'date_log' => [
                'type' => 'DATETIME',
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
            ],
        ]);

        // Add the primary key
        $this->forge->addPrimaryKey('id_user_log');

        // Add a foreign key constraint
        $this->forge->addForeignKey('id_emp', 'employee', 'id_emp');

        // Create the table
        $this->forge->createTable('user_log');
    }

    public function down()
    {
        // Drop the user_log table if it exists
        $this->forge->dropTable('user_log', true);
    }
}
