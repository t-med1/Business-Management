<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailsAvanceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_details_avance' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_avance' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'id_client' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'montantAvance' => [
                'type' => 'FLOAT',
            ],
        ]);

        $this->forge->addPrimaryKey('id_details_avance');
        $this->forge->addForeignKey('id_avance', 'avance', 'id_avance');
        $this->forge->addForeignKey('id_client', 'client', 'id_client');
        $this->forge->createTable('details_avance');
    }

    public function down()
    {
        $this->forge->dropTable('details_avance');
    }
}
