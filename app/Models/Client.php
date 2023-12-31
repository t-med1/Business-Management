<?php

namespace App\Models;

use CodeIgniter\Model;

class Client extends Model
{
    
    protected $DBGroup = 'default';
    protected $table = 'client';
    protected $primaryKey = 'id_client';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['code_client','id_emp','societe','ICE','contact', 'email_client', 'numero_telephone','ville','adresse','source','remarque'];

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    

}