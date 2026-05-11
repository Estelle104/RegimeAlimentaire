<?php

namespace App\Models;

use CodeIgniter\Model;

class ApportModel extends Model
{
    protected $table = 'apports';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle'];
}
