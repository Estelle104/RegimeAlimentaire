<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeRechargeModel extends Model
{
    protected $table = 'codes_recharge';
    protected $primaryKey = 'id';
    protected $allowedFields = ['valeur_code', 'montant', 'statut'];
}
