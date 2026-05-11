<?php

namespace App\Models;

use CodeIgniter\Model;

class ApportAlimentModel extends Model
{
    protected $table = 'apports_aliments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_aliment', 'id_apport', 'valeur_calorie'];
}
