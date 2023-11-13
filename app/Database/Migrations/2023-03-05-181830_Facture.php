<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Facture extends Migration
{
    public function up()
    {
        // CREATE TABLE FOR FACTURES
        $this->forge->addField([
            'id_facture'=>[
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'code_facture'=>[
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => false
            ],
            'id_client'=>[
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'id_vente' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'date_saisie'=>[
                'type' => 'DATE',
                'null' => false
            ],
            'date_emission'=>[
                'type' => 'DATE',
                'null' => false
            ],
            'jours_apres_emission'=>[
                'type' => 'INT',
                'constraint' => 5,
                'null' => true
            ],
            'relance_faite'=>[
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false
            ],
            'status_litige'=>[
                'type' => "ENUM('normal','technique','commercial','irrecouvrable')",
                 'null' => true
            ],
        ]);
        $this->forge->addKey('id_facture', true);
        $this->forge->addForeignKey('id_client','client','id_client');
        $this->forge->addForeignKey('id_vente','vente','id_vente');
        $this->forge->createTable('facture');
           
    }

    public function down()
    {
        // FOR DELETE TABLE FACTURE
        $this->forge->dropTable('facture');
    }
}
