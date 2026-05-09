<?php

namespace App\Models;

use CodeIgniter\Model;

class SuggestionProgrammeModel extends Model
{
    protected $table = 'suggestions_programmes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_objectif', 'id_regime', 'id_sport', 'duree'];
}
