<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regimes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['libelle', 'pourcentage_viande', 'pourcentage_poisson', 'pourcentage_volaille'];

    public function getAllRegimesByObjectif($id_objectif,$utilisateur_id)
    {
        if($id_objectif == 1){
           return $this->db->table("details_regimes")
            ->select("regimes.*")
            ->join("regimes", "regimes.id = details_regimes.id_regime")
            ->where("details_regimes.variation_poids_kg < 0")
            ->get()
            ->getResult();
        }

        if($id_objectif == 2){
            return $this->db->table("details_regimes")
             ->select("regimes.*")
             ->join("regimes", "regimes.id = details_regimes.id_regime")
             ->where("details_regimes.variation_poids_kg > 0")
             ->get()
             ->getResult();
         }

         $detailsSanteModel = new DetailSanteModel();
         $imc = $detailsSanteModel->getImc($utilisateur_id);

         if($imc == "plus"){
            return $this->db->table("details_regimes")
             ->select("regimes.*")
             ->join("regimes", "regimes.id = details_regimes.id_regime")
             ->where("details_regimes.variation_poids_kg > 0")
             ->get()
             ->getResult();
         } elseif ($imc == "moins") {
            return $this->db->table("details_regimes")
             ->select("regimes.*")
             ->join("regimes", "regimes.id = details_regimes.id_regime")
             ->where("details_regimes.variation_poids_kg < 0")
             ->get()
             ->getResult();
         } else {
            return $this->db->table("details_regimes")
             ->select("regimes.*")
             ->join("regimes", "regimes.id = details_regimes.id_regime")
             ->where("details_regimes.variation_poids_kg = 0")
             ->get()
             ->getResult();
         }
    }

}