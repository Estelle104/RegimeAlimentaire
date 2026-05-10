<?php

namespace App\Controllers\BackOffice;

use App\Controllers\BaseController;
use App\Models\AchatRegimeModel;
use App\Models\CodeRechargeModel;
use App\Models\RegimeModel;
use App\Models\UtilisateurModel;

class DashboardController extends BaseController
{
	public function index()
	{
		$regimeModel = new RegimeModel();
		$utilisateurModel = new UtilisateurModel();
		$achatRegimeModel = new AchatRegimeModel();
		$codeRechargeModel = new CodeRechargeModel();

		$stats = [
			'total_regimes' => $regimeModel->countAll(),
			'total_utilisateurs' => $utilisateurModel->countAll(),
			'total_achats' => $achatRegimeModel->countAll(),
			'codes_valides' => $codeRechargeModel->where('statut', 1)->countAllResults(),
			'codes_en_attente' => $codeRechargeModel->where('statut', 0)->countAllResults(),
		];

		$recentAchats = $achatRegimeModel
			->select('achats_regimes.id, achats_regimes.id_utilisateur, achats_regimes.id_regime, achats_regimes.prix_paye, users.nom AS nom_utilisateur, regimes.libelle AS nom_regime')
			->join('users', 'users.id_utilisateur = achats_regimes.id_utilisateur')
			->join('regimes', 'regimes.id = achats_regimes.id_regime')
			->orderBy('achats_regimes.id', 'DESC')
			->limit(5)
			->findAll();

		$recentCodes = $codeRechargeModel
			->select('id, valeur_code, montant, statut')
			->orderBy('id', 'DESC')
			->limit(5)
			->findAll();

		$achatsParRegime = $achatRegimeModel
			->select('regimes.libelle AS nom_regime, COUNT(achats_regimes.id) AS total_achats')
			->join('regimes', 'regimes.id = achats_regimes.id_regime')
			->groupBy('regimes.id, regimes.libelle')
			->orderBy('total_achats', 'DESC')
			->findAll();

		return view('BackOffice/dashboard', [
			'stats' => $stats,
			'recentAchats' => $recentAchats,
			'recentCodes' => $recentCodes,
			'achatsParRegime' => $achatsParRegime,
		]);
	}
}
