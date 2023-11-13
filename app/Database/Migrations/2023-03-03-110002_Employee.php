<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Employee extends Migration
{
    public function up()
    {
       
        $this->forge->addField([
            'id_emp'=>[
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'code_emp'=>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'nom'=>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'prenom'=>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'telephone'=>[
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => true
            ],
            'email'=>[
                'type' => 'VARCHAR',
                'constraint' => 600,
                'null' => false
            ],
            'role'=>[
                'type' => 'ENUM',
                'constraint' => ['admin', 'gestionnaire'],
                "default" => 'gestionnaire',
                'null' => false
            ],
            'date_debut'=>[
                'type' => 'DATE',
                'null' => true
            ],
            
           
           
        ]);
        $this->forge->addKey('id_emp', true);
        $this->forge->createTable('employee');
    }

    public function down()
    {
        $this->forge->dropTable('employee');
    }
}
