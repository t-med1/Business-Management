<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tache extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'id_tache'=>[
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
            'description'=>[
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false
            ],
            'date_debutT'=>[
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
                "default"=>'en attente',
                'null' => false,
            ],
            
        ]);
        $this->forge->addKey('id_tache', true);
        $this->forge->addForeignKey('id_emp','employee','id_emp');
        $this->forge->createTable('tache');
    }

    public function down()
    {
        $this->forge->dropTable('tache');
    }
}
