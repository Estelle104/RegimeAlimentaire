<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifUtilisateurModel extends Model
{
    protected $table = 'objectifs_utilisateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_utilisateur', 'id_objectif'];

    public function getObjectifsByUtilisateur($idUtilisateur)
    {
        return $this->where('id_utilisateur', $idUtilisateur)->first();
    }
}
