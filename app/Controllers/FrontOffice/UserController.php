<?php
    
namespace App\Controllers\FrontOffice;

use App\Controllers\BaseController;
use App\Models\UtilisateurModel;

// use App\Models\
class UserController extends BaseController
{
    public function index()
    {
        return view('FrontOffice/inscription');
    }
    public function PageInscription()
    {
        return view('FrontOffice/inscription');
    }

    public function InsertionInscription()
    {
        $data = $this->request->getJSON(true);
        if (empty($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => 'Donnees d\'inscription invalides',
            ]);
        }

        $userModel = new UtilisateurModel();

        try {
            $userId = $userModel->createUtilisateur($data);
            session()->set('user_id', $userId);

            return $this->response->setStatusCode(200)->setJSON([
                'message' => 'Inscription reussie',
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function PageConnection()
    {
        return view('FrontOffice/connexion');
    }

    public function VerifierConnection()
    {
        $data = $this->request->getJSON(true);
        if (empty($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => 'Donnees de connection invalides',
            ]);
        }

        $userModel = new UtilisateurModel();

        try {
            $user = $userModel->where('email', $data['email'])->first();
            if (!$user || $data['mot_de_passe'] !== $user['mot_de_passe']) {
                throw new \Exception("Email ou mot de passe incorrect");
            }

            session()->set('user_id', $user['id_utilisateur']);

            return $this->response->setStatusCode(200)->setJSON([
                'message' => 'Connection reussie',
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => $e->getMessage(),
            ]);
        }
    }
}