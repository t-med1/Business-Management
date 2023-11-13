<?php

namespace App\Models;

use CodeIgniter\Model;

class Paiment extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'paiment';
    protected $primaryKey       = 'id_paiment';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_facture','id_vente','date_dernier_paiment', 'montant_pay'];
    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

}
