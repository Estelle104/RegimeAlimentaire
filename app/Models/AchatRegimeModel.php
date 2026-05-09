<?php

namespace App\Models;

use CodeIgniter\Model;

class AchatRegimeModel extends Model
{
    protected $table = 'achats_regimes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'id_regime', 'prix_paye'];
}
