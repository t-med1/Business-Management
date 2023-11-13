<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Client extends Migration
{
    public function up()
    {
        // CREATE TABLE FOR CLIENTS
        $this->forge->addField([
            'id_client'=>[
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'id_emp'=>[
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'code_client'=>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'ICE'=>[
                'type' => 'INT',
                'constraint' => 50,
                'null' => true
            ],
            'societe'=>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'contact'=>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'numero_telephone'=>[
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => false
            ],
            'email_client'=>[
                'type' => 'VARCHAR',
                'constraint' => 600,
                'null' => false
            ],
            'adresse'=>[
                'type' => 'VARCHAR',
                'constraint' => 600,
                'null' => true
            ],
            'ville'=>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'source' => [
                'type' => 'ENUM',
                'constraint' => ['Par Tel', 'Facebook', 'Site internet' , 'Publicite'],
                'null' => true,
            ],
            'remarque'=>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
          
        ]);
        $this->forge->addKey('id_client', true);
        $this->forge->addForeignKey('id_emp','employee','id_emp');
        $this->forge->createTable('client');
    }

    public function down()
    {
        // FOR DELETE TABLE CLIENT
        $this->forge->dropTable('client');
    }
}

