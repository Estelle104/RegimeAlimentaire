<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeAbonnementModel extends Model
{
    protected $table = 'types_abonnements';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle', 'pourcentage_remise'];
}
