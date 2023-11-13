<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PhpParser\Builder\TraitUse;

class Vente extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id_vente' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'id_client' => [
            'type' => 'INT',
            'constraint' => 5,
            'unsigned' => true,
        ],
        'id_commande' => [
            'type' => 'INT',
            'constraint' => 5,
            'unsigned' => true,
            'null' => true
        ],
        'code_vente' => [
            'type' => 'VARCHAR',
            'constraint' => 30,
        ],
        'date_vente' => [
            'type' => 'DATE',
        ],
        'tva' => [
            'type' => 'ENUM',
            'constraint' => "'0', '20'", // Use single quotes and comma-separated values
            'default' => '0',
            'null' => false,
        ],
        'total_ht' => [
            'type' => 'FLOAT',
            'null' => false,
        ],
        'total_ttc' => [
            'type' => 'FLOAT',
            'null' => false,
        ],
        'montant_rest' => [
            'type' => 'FLOAT',
            'null' => false,
        ],
        
        'mode_paiement' => [
            'type' => 'VARCHAR',
            'constraint' => '50',
        ],
        'reference_cheque' => [
            'type' => 'INT',
            'null' => true,
        ],
        'date_cheque' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
        'frais' => [
            'type' => 'FLOAT',
            'constraint' => 11,
        ],
        'created_at' => [
            'type' => 'TIMESTAMP',
            'default' => 'CURRENT_TIMESTAMP',
        ],
    ]);
    $this->forge->addPrimaryKey('id_vente');
    $this->forge->addForeignKey('id_client', 'client', 'id_client');
    $this->forge->addForeignKey('id_commande', 'commande', 'id_commande');
    $this->forge->createTable('vente');
}



    public function down()
    {
        $this->forge->dropTable('vente');
    }
}