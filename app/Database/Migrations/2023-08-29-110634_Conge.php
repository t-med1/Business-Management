<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Conge extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_conge' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true,
                'unsigned' => true,
                'primary' => true,
            ],
            'id_emp' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'date_debutC' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'date_fin' => [
                'type' => 'DATE',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id_conge', true);
        $this->forge->addForeignKey('id_emp', 'employee', 'id_emp');
        $this->forge->createTable('conge');
    }

    public function down()
    {
        $this->forge->dropTable('conge');
    }
}
