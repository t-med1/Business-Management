<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        // add the initial informations
        $data = [
            [
                'ICE' =>504246878,
                'nom' => 'Hotel Sahrai',
                'commerciale' => "admin",
                'email_client' => 'sahrai.hotel@gmail.com',
                'numero_telephone' => '0520963627',
                'adresse' => 'bab el ghoul fès',
                'ville' => 'FES',
                'pays' => 'Maroc',
                'remarque' => '',
                'source' => 'Facebook',
            ],
            [
                'ICE' => null,
                'nom' => 'Alaoui Mehdi',
                'commerciale' => "telaj",
                'email_client' => 'alaoui.mehdi@gmail.com',
                'numero_telephone' => '0729105673',
                'adresse' => 'Hay Riad Rue3 ',
                'ville' => 'Rabat',
                'pays' => 'Maroc',
                'remarque' => '',
                'source' => 'Publicite',
            ]
        ];

        $this->db->table('client')->insertBatch($data);
    }
}