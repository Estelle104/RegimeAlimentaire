<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_utilisateur';
    protected $allowedFields = ['nom', 'email', 'mot_de_passe', 'genre', 'solde', 'est_gold'];
}
