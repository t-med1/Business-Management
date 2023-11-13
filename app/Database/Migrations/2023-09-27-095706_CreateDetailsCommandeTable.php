<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailsCommandeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_details_cmd' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_commande'=>[
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'id_service'=>[
                'type' => 'INT',
                'constraint' => 5,
            ],
        ]);

        $this->forge->addPrimaryKey('id_details_cmd');
        $this->forge->addForeignKey('id_commande', 'commande', 'id_commande');
        $this->forge->addForeignKey('id_service', 'service', 'id_service');

        $this->forge->createTable('details_commande');
    }

    public function down()
    {
        $this->forge->dropTable('details_commande');
    }
}
