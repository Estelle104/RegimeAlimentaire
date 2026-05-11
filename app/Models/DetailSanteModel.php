<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailSanteModel extends Model
{
    protected $table = 'details_sante';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'taille', 'poids', 'imc'];
}
