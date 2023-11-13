<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SouTache extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sou_tache'=>[
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'id_tache'=>[
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'nom'=>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'description'=>[
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false
            ],
            'date_debut'=>[
                'type' => 'DATE',
                'null' => false
            ],
            'date_fin'=>[
                'type' => 'DATE',
                'null' => false
            ],
            'statut' => [
                'type' => 'ENUM',
                'constraint' => ['en cours', 'terminée', 'en attente' , 'en retard'],
                'null' => false,
            ],
            
        ]);
        $this->forge->addKey('id_sou_tache', true);
        $this->forge->addForeignKey('id_tache','tache','id_tache');
        $this->forge->createTable('sou_tache');
    }

    public function down()
    {
        $this->forge->dropTable('sou_tache');
    }
}
