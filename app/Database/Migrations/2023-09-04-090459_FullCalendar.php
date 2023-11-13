<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FullCalendar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_calendar' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true,
                'unsigned' => true,
                'primary' => true,
            ],
            'titre'=>[
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'start_event' => [
                'type' => 'datetime',
                'null' => false,
            ],
            'end_event' => [
                'type' => 'datetime',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id_calendar', true);
        $this->forge->createTable('calender');
    }

    public function down()
    {
       
        $this->forge->dropTable('calender');
    }
}
