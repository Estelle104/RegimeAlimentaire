<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorieAlimentModel extends Model
{
    protected $table = 'categories_aliments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle'];
}
