<?php

namespace App\Models;

use CodeIgniter\Model;

class AlimentModel extends Model
{
    protected $table = 'aliments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle', 'id_categorie_aliment', 'prix_par_calorie'];
}
