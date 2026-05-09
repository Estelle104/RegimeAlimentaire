<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_utilisateur';
    protected $allowedFields = ['nom', 'email', 'mot_de_passe', 'genre', 'solde', 'est_gold'];

    public function getImc($id_utilisateur)
    {
        $details = new DetailSanteModel();
        $user = $details->find($id_utilisateur);
        if ($user) {
            $taille = $user['taille']; 
            $poids = $user['poids'];   
            $imc = $poids / (($taille) ** 2);

            if($imc < 18.5) {
                return "plus";
            } elseif ($imc >= 18.5 && $imc < 25) {
                return "zero";
            } else {
                return "moins";
            }
        }
        return null;
    }
}