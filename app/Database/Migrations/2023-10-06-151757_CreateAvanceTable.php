<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAvanceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_avance' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_client' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'date_avance' => [
                'type' => 'Date',
            ],
            'montant' => [
                'type' => 'FLOAT',
            ],
            'mode_pay' => [
                'type' => 'ENUM("espece", "cheque", "effet", "virement")',
            ],
            'status' => [
                'type' => 'ENUM("avance", "retour")',
            ],
            'reference' => [
                'type' => 'INT',
            ],
            'date_pay' => [
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addPrimaryKey('id_avance');
        $this->forge->addForeignKey('id_client', 'client', 'id_client');
        $this->forge->createTable('avance');
    }

    public function down()
    {
        $this->forge->dropTable('avance');
    }
}
