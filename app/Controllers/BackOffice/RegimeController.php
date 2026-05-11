<?php

namespace App\Controllers\BackOffice;

use App\Controllers\BaseController;

use App\Models\RegimeModel;

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

        return redirect()->to('/backoffice/regimes');
    }

    public function update($id)
    {
        $model = new RegimeModel();

        return view('BackOffice/regime/regime_update', [
            'regime' => $model->find($id)
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

        return redirect()->to('/backoffice/regimes');
    }

    public function delete($id)
    {
        $model = new RegimeModel();
        $model->delete($id);

        return redirect()->to('/backoffice/regimes');
    }

}
