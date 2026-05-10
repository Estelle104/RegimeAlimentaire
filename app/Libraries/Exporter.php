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

        $objectifsUtilisateur = $this->db->table('objectifs_utilisateurs')
                                         ->select('id_objectif')
                                         ->where('id_utilisateur', $this->idUtilisateur)
                                         ->get()
                                         ->getResultArray();

        $idObjectifs = array_column($objectifsUtilisateur, 'id_objectif');

        $suggestions = $this->db->table('suggestions_programmes')
                               ->select('suggestions_programmes.id, regimes.libelle as regime, regimes.pourcentage_viande, regimes.pourcentage_poisson, regimes.pourcentage_volaille, sports.libelle as sport, suggestions_programmes.duree, details_regimes.prix, details_regimes.variation_poids_kg, details_regimes.duree_jours')
                               ->join('regimes', 'regimes.id = suggestions_programmes.id_regime')
                               ->join('sports', 'sports.id = suggestions_programmes.id_sport')
                               ->join('details_regimes', 'details_regimes.id_regime = regimes.id')
                               ->whereIn('suggestions_programmes.id_objectif', $idObjectifs ?: [0])
                               ->get()
                               ->getResultArray();

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
                $this->Cell(0, 8, '  Duree : ' . $regime['duree_jours'] . ' jours', 0, 1);
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
                $prixFinal = $regime['prix'];
                if ($est_gold) {
                    $prixFinal = $regime['prix'] * 0.85;
                    $this->Cell(0, 8, '  Prix : ' . number_format($regime['prix'], 2) . ' Ariary -> ' . number_format($prixFinal, 2) . ' Ariary (remise -15%)', 0, 1);
                } else {
                    $this->Cell(0, 8, '  Prix : ' . number_format($regime['prix'], 2) . ' Ariary', 0, 1);
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