<?php

namespace App\Models;

use CodeIgniter\Model;

class DemandeRechargeModel extends Model
{
    protected $table = 'demandes_recharge';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'id_code_recharge', 'est_valide', 'date_demande'];
}
