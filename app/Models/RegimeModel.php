<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle', 'pourcentage_viande', 'pourcentage_poisson', 'pourcentage_volaille'];
}
