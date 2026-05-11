<?php

namespace App\Controllers\FrontOffice;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;
use App\Libraries\Exporter as ExportPDF;

class RegimeController extends BaseController
{
    public function index()
    {
        $idUtilisateur = session()->get('user_id');
        
        if (!$idUtilisateur) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter.');
        }

        $db = \Config\Database::connect();
        
        $utilisateurModel = new UtilisateurModel();
        $user = $utilisateurModel->find($idUtilisateur);

        $objectifsUtilisateur = $db->table('objectifs_utilisateurs')
                                   ->select('id_objectif')
                                   ->where('id_utilisateur', $idUtilisateur)
                                   ->get()
                                   ->getResultArray();

        $idObjectifs = array_column($objectifsUtilisateur, 'id_objectif');

        $suggestions = $db->table('suggestions_programmes')
                         ->select('suggestions_programmes.id, regimes.libelle as regime, sports.libelle as sport, suggestions_programmes.duree, details_regimes.prix, details_regimes.variation_poids_kg')
                         ->join('regimes', 'regimes.id = suggestions_programmes.id_regime')
                         ->join('sports', 'sports.id = suggestions_programmes.id_sport')
                         ->join('details_regimes', 'details_regimes.id_regime = regimes.id')
                         ->whereIn('suggestions_programmes.id_objectif', $idObjectifs ?: [0])
                         ->get()
                         ->getResultArray();

        $data['user'] = $user;
        $data['suggestions'] = $suggestions;
        $data['est_gold'] = (!empty($user['est_gold']) && ($user['est_gold'] === 't' || $user['est_gold'] == 1));

        return view('FrontOffice/regimes', $data);
    }

    public function acheter($id_regime)
    {
        $idUtilisateur = session()->get('user_id');
        
        if (!$idUtilisateur) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter.');
        }

        $db = \Config\Database::connect();
        $utilisateurModel = new UtilisateurModel();
        
        $user = $utilisateurModel->find($idUtilisateur);
        
        $regime = $db->table('regimes')
                    ->select('regimes.id, regimes.libelle, details_regimes.prix')
                    ->join('details_regimes', 'details_regimes.id_regime = regimes.id')
                    ->where('regimes.id', $id_regime)
                    ->get()
                    ->getRowArray();

        if (!$regime) {
            return redirect()->back()->with('error', 'Régime non trouvé.');
        }

        $prixFinal = $regime['prix'];
        
        // Appliquer la remise Gold si l'utilisateur est Gold
        if (!empty($user['est_gold']) && ($user['est_gold'] === 't' || $user['est_gold'] == 1)) {
            $prixFinal = $regime['prix'] * 0.85; // 15% de remise
        }

        if ($user['solde'] < $prixFinal) {
            return redirect()->back()->with('error', 'Solde insuffisant pour acheter ce régime. Veuillez recharger votre porte-monnaie.');
        }

        // Débiter le solde
        $nouveauSolde = $user['solde'] - $prixFinal;
        $utilisateurModel->update($idUtilisateur, ['solde' => $nouveauSolde]);

        // Enregistrer l'achat
        $db->table('achats_regimes')->insert([
            'id_utilisateur' => $idUtilisateur,
            'id_regime' => $id_regime,
            'prix_paye' => $prixFinal
        ]);

        $message = 'Régime acheté avec succès !';
        if (!empty($user['est_gold']) && ($user['est_gold'] === 't' || $user['est_gold'] == 1)) {
            $message .= ' (15% de remise Gold appliquée)';
        }

        return redirect()->back()->with('success', $message);
    }

    public function exporterPDF()
    {
        $idUtilisateur = session()->get('user_id');
        
        if (!$idUtilisateur) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter.');
        }

        $exporter = new ExportPDF($idUtilisateur);
        $exporter->genererPDF();
    }
}
