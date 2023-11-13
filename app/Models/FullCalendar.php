<?php

namespace App\Models;

use CodeIgniter\Model;

class FullCalendar extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'calender';
    protected $primaryKey       = 'id_calendar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['titre','start_event','end_event'];

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

    public function getEvent($start, $end)
    {
        return $this->db->table($this->table)
            ->where('start_event >=', $start)
            ->where('end_event <=', $end)
            ->get()
            ->getResult();
    }

    
    public function getAllEvents()
    {
        return $this->findAll();
    }

    
}
