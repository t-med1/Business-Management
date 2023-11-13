<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Paiment extends Migration
{
    public function up()
    {
         // CREATE TABLE FOR Paiment
        $this->forge->addField([
            'id_paiment'=>[
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_vente' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_facture'=>[
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'date_dernier_paiment'=>[
                'type' => 'DATE',
                'null' => true
            ],
            'montant_pay'=>[
                'type' => 'float',
                'null' => true
            ],
            
        ]);
        $this->forge->addKey('id_paiment', true);
        $this->forge->addForeignKey('id_facture','facture','id_facture');
        $this->forge->addForeignKey('id_vente','vente','id_vente');
        $this->forge->createTable('paiment');
    }

    public function down()
    {
        // FOR DELETE TABLE PAIMENT
        $this->forge->dropTable('paiment');
    }
}
