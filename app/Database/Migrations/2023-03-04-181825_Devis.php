<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Devis extends Migration
{
    public function up()
    {
        // CREATE TABLE FOR Devis
        $this->forge->addField([
            'id_devis'=>[
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
            'code_devis'=>[
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true
            ],
            'date_saisie'=>[
                'type' => 'DATE',
                'null' => false
            ],
            'total_ht'=>[
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false
            ],
            'total_ttc'=>[
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true
            ],
            'modalite_paiement'=>[
                'type' => 'VARCHAR',
                'constraint' => 600,
                'null' => true
            ],
            'etat'=>[
                'type' => 'VARCHAR',
                'constraint' => 600,
                'null' => true
            ],
            
        ]);
        $this->forge->addKey('id_devis', true);
        $this->forge->addForeignKey('id_client','client','id_client');
        $this->forge->createTable('devis');
           
    }

    public function down()
    {
        // FOR DELETE TABLE Devis
        $this->forge->dropTable('devis');
    }
    
}


