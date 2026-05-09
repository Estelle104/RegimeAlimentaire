<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailRegimeModel extends Model
{
    protected $table = 'details_regimes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_regime', 'duree_jours', 'prix', 'variation_poids_kg'];
}
