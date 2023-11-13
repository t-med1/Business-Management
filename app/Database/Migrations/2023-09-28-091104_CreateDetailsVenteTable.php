<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailsVenteTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_details_vente' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_service' => [
                'type' => 'INT',
                'null' => false
            ],
            'id_vente' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_details_vente');
        $this->forge->addForeignKey('id_service', 'service', 'id_service');
        $this->forge->addForeignKey('id_vente', 'vente', 'id_vente');
        
        $this->forge->createTable('details_vente');
    }

    public function down()
    {
        $this->forge->dropTable('details_vente');
    }
}
