<?php

namespace App\Controllers\BackOffice;
use App\Controllers\BaseController;
use App\Models\AdminController as AdminModel;

class AdminConnexionController extends BaseController
{
    public function index()
    {
        return view('BackOffice/connexion');
    }

    public function verifier()
    {
        $data = $this->request->getJSON(true);
        if (empty($data)) {
            $data = $this->request->getPost();
        }

        $username = trim((string) ($data['username'] ?? ''));
        $password = trim((string) ($data['password'] ?? ''));

        if ($username === '' || $password === '') {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => 'Identifiants invalides',
            ]);
        }

        $adminModel = new AdminModel();
        $isValid = $adminModel->verifyAdmin($username, $password);

        if ($isValid) {
            session()->set('admin_logged_in', true);
            return $this->response->setStatusCode(200)->setJSON([
                'message' => 'Connexion admin reussie',
                'redirect' => base_url('backoffice/dashboard'),
            ]);
        }

        return $this->response->setStatusCode(401)->setJSON([
            'message' => 'Identifiants invalides',
        ]);
    }
}