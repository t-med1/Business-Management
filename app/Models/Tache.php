<?php

namespace App\Models;

use CodeIgniter\Model;

class Tache extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tache';
    protected $primaryKey       = 'id_tache';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['description','date_debutT','date_fin','statut','id_emp'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'id_emp');
    }

    public function souTaches()
    {
        return $this->hasMany(SouTache::class, 'id_tache');
    }

    public function updateStatus($tacheId, $newStatus)
    {

        $this->where('id_tache', $tacheId)->update(['statut' => $newStatus]);
    }
}
