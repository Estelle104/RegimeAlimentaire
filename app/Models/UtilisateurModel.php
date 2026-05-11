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

   public function createUtilisateur($data)
    {
        $details = new DetailSanteModel();

        // Vérification email déjà utilisé
        if ($this->where('email', $data['email'])->first()) {
            throw new \Exception("Cet email existe déjà");
        }

        // Vérification des champs obligatoires
        if (empty($data['nom'])) {
            throw new \Exception("Le nom est obligatoire");
        }

        if (empty($data['email'])) {
            throw new \Exception("L'email est obligatoire");
        }

        if (empty($data['mot_de_passe'])) {
            throw new \Exception("Le mot de passe est obligatoire");
        }

        if (empty($data['genre'])) {
            throw new \Exception("Le genre est obligatoire");
        }

        if (empty($data['taille'])) {
            throw new \Exception("La taille est obligatoire");
        }

        if (empty($data['poids'])) {
            throw new \Exception("Le poids est obligatoire");
        }

        // Hash du mot de passe
        // $data['mot_de_passe'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);

        $this->db->transStart();

        // Insertion user
        $insertId = $this->insert($data);

        if (!$insertId) {
            $this->db->transComplete();
            throw new \Exception("Erreur lors de l'insertion");
        }

        $taille = (float) $data['taille']/100;
        $poids = (float) $data['poids'];
        $imc = $taille > 0 ? $poids / ($taille * $taille) : null;

        $detailData = [
            'id_utilisateur' => $insertId,
            'taille' => $taille,
            'poids' => $poids,
            'imc' => $imc,
        ];

        if (!$details->insert($detailData)) {
            $this->db->transComplete();
            throw new \Exception("Erreur lors de l'insertion des details de sante");
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            throw new \Exception("Erreur lors de la transaction");
        }

        return $insertId;
    }
}