<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CommercialeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'code_emp' => 'E-23-001',
                'nomE' =>"boutmi",
                'prenomE' => 'zahira',
                'telephone' => '0620963627',
                'email' => 'zahira@gmail.com',
                'role' => 'developpeuse',
                'date_debut' => '2020-04-02',
            ],
            [
                'code_emp' => 'E-23-002',
                'nomE' =>"jamai",
                'prenomE' => 'khawla',
                'telephone' => '0733546589',
                'email' => 'khawla@gmail.com',
                'role' => 'assisstante commerciale',
                'date_debut' => '2019-04-02',
            ],
        ];

        $this->db->table('employee')->insertBatch($data);
    }
}
