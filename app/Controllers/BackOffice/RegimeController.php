<?php

namespace App\Controllers\BackOffice;

use App\Controllers\BaseController;

use App\Models\RegimeModel;
use App\Models\DetailRegimeModel;

class RegimeController extends BaseController
{
    public function index() {

        $regimeModel = new RegimeModel();

        $data = [
            'regimes' => $regimeModel->findAll()
        ];

        return view('BackOffice/regime/regime_list', $data);
    }

    public function add()
    {
        return view('BackOffice/regime/regime_add');
    }

    public function create()
    {
        $model = new RegimeModel();

        $model->save([
            'libelle' => $this->request->getPost('libelle'),
            'pourcentage_viande' => $this->request->getPost('pourcentage_viande'),
            'pourcentage_poisson' => $this->request->getPost('pourcentage_poisson'),
            'pourcentage_volaille' => $this->request->getPost('pourcentage_volaille'),
        ]);
        $insertId = $model->getInsertID();

        // Créer l'effet / détails du régime si fournis
        $duree = $this->request->getPost('duree_jours');
        $prix = $this->request->getPost('prix');
        $variation = $this->request->getPost('variation_poids_kg');

        if ($insertId && ($duree !== null || $prix !== null || $variation !== null)) {
            $detailModel = new DetailRegimeModel();
            $detailModel->insert([
                'id_regime' => $insertId,
                'duree_jours' => $duree ?: 0,
                'prix' => $prix ?: 0,
                'variation_poids_kg' => $variation ?: 0,
            ]);
        }

        return redirect()->to('/backoffice/regimes');
    }

    public function update($id)
    {
        $model = new RegimeModel();

        $regime = $model->find($id);
        $detailModel = new DetailRegimeModel();
        $detail = $detailModel->where('id_regime', $id)->first();

        return view('BackOffice/regime/regime_update', [
            'regime' => $regime,
            'detail' => $detail,
        ]);
    }

    public function updateAction($id)
    {
        $model = new RegimeModel();

        $model->update($id, [
            'libelle' => $this->request->getPost('libelle'),
            'pourcentage_viande' => $this->request->getPost('pourcentage_viande'),
            'pourcentage_poisson' => $this->request->getPost('pourcentage_poisson'),
            'pourcentage_volaille' => $this->request->getPost('pourcentage_volaille'),
        ]);

        // Mettre à jour ou créer les détails du régime
        $detailModel = new DetailRegimeModel();
        $existing = $detailModel->where('id_regime', $id)->first();

        $duree = $this->request->getPost('duree_jours') ?: 0;
        $prix = $this->request->getPost('prix') ?: 0;
        $variation = $this->request->getPost('variation_poids_kg') ?: 0;

        if ($existing) {
            $detailModel->update($existing['id'], [
                'duree_jours' => $duree,
                'prix' => $prix,
                'variation_poids_kg' => $variation,
            ]);
        } else {
            $detailModel->insert([
                'id_regime' => $id,
                'duree_jours' => $duree,
                'prix' => $prix,
                'variation_poids_kg' => $variation,
            ]);
        }

        return redirect()->to('/backoffice/regimes');
    }

    public function delete($id)
    {
        $model = new RegimeModel();
        $model->delete($id);

        return redirect()->to('/backoffice/regimes');
    }

}
