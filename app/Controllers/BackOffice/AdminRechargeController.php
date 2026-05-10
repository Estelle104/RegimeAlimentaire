<?php

namespace App\Controllers\BackOffice;

use App\Controllers\BaseController;
use App\Models\DemandeRechargeModel;
use App\Models\CodeRechargeModel;
use App\Models\UtilisateurModel;

class AdminRechargeController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Requête avec jointure pour afficher le nom du code et son montant
        $demandes = $db->table('demandes_recharge')
                       ->select('demandes_recharge.id, demandes_recharge.id_utilisateur, codes_recharge.valeur_code, codes_recharge.montant')
                       ->join('codes_recharge', 'codes_recharge.id = demandes_recharge.id_code_recharge')
                       ->where('demandes_recharge.est_valide', 0)
                       ->get()
                       ->getResultArray();
        
        $data['demandes_en_attente'] = $demandes;
        
        return view('BackOffice/demandes_recharge', $data);
    }

    public function valider($id_demande)
    {
        $demandeModel = new DemandeRechargeModel();
        $codeModel = new CodeRechargeModel();
        $utilisateurModel = new UtilisateurModel();

        $demande = $demandeModel->find($id_demande);

        if ($demande && $demande['est_valide'] == 0) {
            $code = $codeModel->find($demande['id_code_recharge']);
            $user = $utilisateurModel->find($demande['id_utilisateur']);

            if ($code && $user) {
                $nouveauSolde = $user['solde'] + $code['montant'];
                $utilisateurModel->update($user['id_utilisateur'], ['solde' => $nouveauSolde]);
                $demandeModel->update($id_demande, ['est_valide' => 1]);

                return redirect()->back()->with('success', 'Code validé. Le compte de l\'utilisateur a été crédité.');
            }
        }
        return redirect()->back()->with('error', 'Erreur lors de la validation.');
    }

    public function refuser($id_demande)
    {
        $demandeModel = new DemandeRechargeModel();
        $codeModel = new CodeRechargeModel();

        $demande = $demandeModel->find($id_demande);

        if ($demande && $demande['est_valide'] == 0) {
            $codeModel->update($demande['id_code_recharge'], ['statut' => 0]);
            $demandeModel->update($id_demande, ['est_valide' => -1]);

            return redirect()->back()->with('success', 'La demande a été refusée.');
        }
        return redirect()->back()->with('error', 'Erreur lors du refus.');
    }
}
