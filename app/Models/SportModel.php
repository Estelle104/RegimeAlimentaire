<?php

namespace App\Models;

use CodeIgniter\Model;

class SportModel extends Model
{
    protected $table = 'sports';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle'];

    public function getAllSportsByObjectif($id_objectif)
    {
        $builder = $this->db->table($this->table);
        $builder->select('sports.*');
        $builder->join('suggestions_programmes', 'suggestions_programmes.id_sport = sports.id');
        $builder->where('suggestions_programmes.id_objectif', $id_objectif);
        return $builder->get()->getResult();
    }
}
