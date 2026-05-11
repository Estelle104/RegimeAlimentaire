<?php

namespace App\Libraries;

use App\Models\UtilisateurModel;
use App\Libraries\FPDF;

class Exporter extends FPDF
{
    private $idUtilisateur;
    private $db;

    public function __construct($idUtilisateur = null)
    {
        parent::__construct();
        $this->idUtilisateur = $idUtilisateur;
        $this->db = \Config\Database::connect();
    }

    public function genererPDF()
    {
        if (!$this->idUtilisateur) {
            return false;
        }

        $utilisateurModel = new UtilisateurModel();
        $user = $utilisateurModel->find($this->idUtilisateur);

        if (!$user) {
            return false;
        }

        // Récupérer l'objectif de l'utilisateur
        $idObjectifRow = $this->db->table('objectifs_utilisateurs')
                                   ->select('id_objectif')
                                   ->where('id_utilisateur', $this->idUtilisateur)
                                   ->get()
                                   ->getRowArray();
        
        $idObjectifs = $idObjectifRow ? $idObjectifRow['id_objectif'] : null;

        // Récupérer détails santé et calculer IMC
        $detailsSante = $this->db->table('details_sante')
                                  ->where('id_utilisateur', $this->idUtilisateur)
                                  ->get()
                                  ->getRowArray();
        
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

        // Requête de base
        $query = $this->db->table('regimes')
                          ->select('regimes.id, regimes.libelle as regime, regimes.pourcentage_viande, regimes.pourcentage_poisson, regimes.pourcentage_volaille, sports.libelle as sport, suggestions_programmes.duree, details_regimes.prix, details_regimes.variation_poids_kg, details_regimes.duree_jours')
                          ->join('details_regimes', 'details_regimes.id_regime = regimes.id')
                          ->join('suggestions_programmes', 'suggestions_programmes.id_regime = regimes.id', 'left')
                          ->join('sports', 'sports.id = suggestions_programmes.id_sport', 'left');

        // Filtrer par objectif
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

        // Calculer jours_pour_imc et prix_final pour chaque suggestion
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

        $est_gold = (!empty($user['est_gold']) && ($user['est_gold'] === 't' || $user['est_gold'] == 1));

        $this->AddPage();
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Mes Regimes Recommandes', 0, 1, 'C');
        
        $this->SetFont('Arial', '', 12);
        $this->Ln(5);
        $this->Cell(0, 8, 'Utilisateur : ' . $user['nom'], 0, 1);
        $this->Cell(0, 8, 'Solde : ' . number_format($user['solde'], 2) . ' Ariary', 0, 1);
        $this->Cell(0, 8, 'Statut Gold : ' . ($est_gold ? 'OUI (15% de remise)' : 'NON'), 0, 1);
        $this->Ln(5);

        if (!empty($suggestions)) {
            foreach ($suggestions as $index => $regime) {
                $this->SetFont('Arial', 'B', 12);
                $this->SetFillColor(200, 220, 255);
                $this->Cell(0, 10, ($index + 1) . '. ' . $regime['regime'], 0, 1, 'L', true);
                
                $this->SetFont('Arial', '', 10);
                $this->Ln(2);
                $this->Cell(0, 8, '  Duree : ' . ($regime['duree'] ?? $regime['duree_jours']) . ' jours', 0, 1);
                $this->Cell(0, 8, '  Sport recommande : ' . $regime['sport'], 0, 1);
                $this->Cell(0, 8, '  Variation de poids estimee : ' . $regime['variation_poids_kg'] . ' kg', 0, 1);
                $this->Ln(1);
                
                $this->SetFont('Arial', '', 9);
                $this->Cell(0, 7, '  Composition du regime :', 0, 1);
                $this->Cell(0, 7, '    - Viande : ' . $regime['pourcentage_viande'] . '%', 0, 1);
                $this->Cell(0, 7, '    - Poisson : ' . $regime['pourcentage_poisson'] . '%', 0, 1);
                $this->Cell(0, 7, '    - Volaille : ' . $regime['pourcentage_volaille'] . '%', 0, 1);
                $this->Ln(2);
                
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(0, 8, '  Prix : ' . number_format($regime['prix_final'], 2) . ' Ariary', 0, 1);
                
                if ($regime['jours_pour_imc'] !== null) {
                    $this->SetFont('Arial', '', 9);
                    $this->Cell(0, 8, '  Jours pour atteindre IMC ideal : ' . $regime['jours_pour_imc'] . ' jours', 0, 1);
                }
                
                $this->Ln(5);
            }
        } else {
            $this->SetFont('Arial', '', 11);
            $this->Cell(0, 10, 'Aucun regime recommande trouve.', 0, 1);
        }

        $this->Output('D', 'Mes_Regimes_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}