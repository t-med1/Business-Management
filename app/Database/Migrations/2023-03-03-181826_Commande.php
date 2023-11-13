<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Commande extends Migration
{
    public function up()
    {
       
        $this->forge->addField([
            'id_commande'=>[
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'id_client'=>[
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'code_commande'=>[
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => false
            ],
            'date_debut'=>[
                'type' => 'DATE',
                'null' => false
            ],
            'prix_total'=>[
                'type' => 'decimal',
                'constraint' => 15,
                'null' => false
            ],
            'remarque' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true
            ],
            'responsable' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true
            ],
            'annuler' => [
                'type' => 'TINYINT',
                'default' => 0
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ]
           
           
        ]);
        $this->forge->addKey('id_commande', true);
        $this->forge->addForeignKey('id_client','client','id_client');
        $this->forge->createTable('commande');
    }

    public function down()
    {
        $this->forge->dropTable('commande');
    }
}

