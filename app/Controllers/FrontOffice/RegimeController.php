<?php

namespace App\Controllers\FrontOffice;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;
use App\Libraries\Exporter as ExportPDF;
use App\Models\ObjectifUtilisateurModel;

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

        $idObjectif = new ObjectifUtilisateurModel();
        $idOb= $idObjectif->getObjectifsByUtilisateur($idUtilisateur);
        

$idObjectifs = $idOb ? $idOb['id_objectif'] : null;
        $detailsSante = $db->table('details_sante')->where('id_utilisateur', $idUtilisateur)->get()->getRowArray();
        
        $needsWeightLoss = false;
        $needsWeightGain = false;
        $needsMaintenance = false;
        $currentIMC = null;
        
        if ($detailsSante && isset($detailsSante['taille']) && isset($detailsSante['poids'])) {
            $taille = (float) $detailsSante['taille'];
            $poids = (float) $detailsSante['poids'];
            if ($taille > 0) {
                $currentIMC = $poids / ($taille * $taille);
                
                if ($currentIMC < 18.5) {
                    $needsWeightGain = true;
                }
                elseif ($currentIMC > 25) {
                    $needsWeightLoss = true;
                }
                else {
                    $needsMaintenance = true;
                }
            }
        }

        $query = $db->table('regimes')
                    ->select('regimes.id, regimes.libelle as regime, details_regimes.prix, details_regimes.variation_poids_kg, details_regimes.duree_jours, sports.libelle as sport, suggestions_programmes.duree')
                    ->join('details_regimes', 'details_regimes.id_regime = regimes.id')
                    ->join('suggestions_programmes', 'suggestions_programmes.id_regime = regimes.id', 'left')
                    ->join('sports', 'sports.id = suggestions_programmes.id_sport', 'left');
        
        if (!empty($idObjectifs)) {
            $query->groupStart();
            if ($idObjectifs == 1) {
                $query->where('details_regimes.variation_poids_kg < 0', null, false);
            }
            if ($idObjectifs == 2) {
                $query->Where('details_regimes.variation_poids_kg > 0', null, false);
            }
            if ($idObjectifs == 3) {
                if ($needsWeightLoss) {
                    $query->Where('details_regimes.variation_poids_kg < 0', null, false);
                } elseif ($needsWeightGain) {
                    $query->Where('details_regimes.variation_poids_kg > 0', null, false);
                } else {
                    $query->Where('ABS(details_regimes.variation_poids_kg) <= 0.5', null, false);
                }
            }
            $query->groupEnd();
        }
        
        $suggestions = $query->get()->getResultArray();

        foreach ($suggestions as &$s) {
            $s['jours_pour_imc'] = null;
            $s['prix_final'] = $s['prix'];
            
            if (!empty($user['est_gold']) && ($user['est_gold'] === 't' || $user['est_gold'] == 1)) {
                $s['prix_final'] = $s['prix'] * 0.85;
            }
            
            if ($detailsSante && isset($detailsSante['taille']) && isset($detailsSante['poids'])) {
                $taille = (float) $detailsSante['taille'];
                $poids = (float) $detailsSante['poids'];
                
                if ($taille > 0 && $currentIMC !== null) {
                    if ($currentIMC < 18.5) {
                        $targetBMI = 18.5; 
                    } elseif ($currentIMC > 25) {
                        $targetBMI = 25; 
                    } else {
                        $targetBMI = $currentIMC; 
                    }

                    $targetPoids = $targetBMI * $taille * $taille;
                    $poidsNecessaire = $targetPoids - $poids;

                    $duree_jours = isset($s['duree_jours']) ? (int) $s['duree_jours'] : 0;
                    $variation_par_duree = isset($s['variation_poids_kg']) ? (float) $s['variation_poids_kg'] : 0.0;

                    if ($duree_jours > 0 && $variation_par_duree != 0.0) {
                        $daily_change = $variation_par_duree / $duree_jours;
                        if ($daily_change != 0.0) {
                            $jours = (int) ceil(abs($poidsNecessaire) / abs($daily_change));
                            $s['jours_pour_imc'] = $jours;
                            
                            if ($idObjectifs == 3) {
                                $s['prix_final'] = $s['prix'] * ($jours / $duree_jours);
                                if (!empty($user['est_gold']) && ($user['est_gold'] === 't' || $user['est_gold'] == 1)) {
                                    $s['prix_final'] = $s['prix_final'] * 0.85;
                                }
                            }
                        }
                    }
                }
            }
        }

        $data['user'] = $user;
        $data['suggestions'] = $suggestions;
        $data['currentIMC'] = $currentIMC;
        $data['needsWeightLoss'] = $needsWeightLoss;
        $data['needsWeightGain'] = $needsWeightGain;
        $data['needsMaintenance'] = $needsMaintenance;
        $data['idObjectifs'] = $idObjectifs;
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
