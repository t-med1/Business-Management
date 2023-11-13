<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LigneCommande extends Migration
{
    public function up()
    {
        // CREATE TABLE FOR LigneCommande
        $this->forge->addField([
            'id_lignecommande'=>[
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true,
                'unsigned' => true,
            ],

            'id_service'=>[
                'type' => 'INT',
                'constraint' => 5,
            ],
            'id_devis'=>[
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            
        ]);
        $this->forge->addKey('id_lignecommande', true);
        $this->forge->addForeignKey('id_service', 'service', 'id_service');
        $this->forge->addForeignKey('id_devis', 'devis', 'id_devis');
        $this->forge->createTable('lignecommande');
    }

    public function down()
    {
        // FOR DELETE TABLE lignecommande
        $this->forge->dropTable('lignecommande');
    }
}
