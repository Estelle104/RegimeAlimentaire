<?php
    
namespace App\Controllers\FrontOffice;

use App\Controllers\BaseController;
use App\Models\DetailSanteModel;
use App\Models\UtilisateurModel;

// use App\Models\
class UserController extends BaseController
{
    // public function index()
    // {
    //     return view('FrontOffice/inscription');
    // }
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
                'redirect' => base_url('frontoffice/profile'),
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => $e->getMessage(),
            ]);
        }
    }
    
    public function PageProfile()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/frontOffice/connexion');
        }

        $userModel = new UtilisateurModel();
        $detailsModel = new DetailSanteModel();

        $user = $userModel->find($userId);
        $details = $detailsModel->where('id_utilisateur', $userId)->first();

        return view('FrontOffice/profile', [
            'user' => $user,
            'details' => $details,
        ]);
    }

    public function PageProfileEdit()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/frontOffice/connexion');
        }

        $userModel = new UtilisateurModel();
        $detailsModel = new DetailSanteModel();

        $user = $userModel->find($userId);
        $details = $detailsModel->where('id_utilisateur', $userId)->first();

        return view('FrontOffice/profile_edit', [
            'user' => $user,
            'details' => $details,
        ]);
    }

    public function UpdateProfile()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON([
                'message' => 'Utilisateur non connecte',
            ]);
        }

        $data = $this->request->getJSON(true);
        if (empty($data)) {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => 'Donnees invalides',
            ]);
        }

        $userModel = new UtilisateurModel();
        $detailsModel = new DetailSanteModel();

        $existing = $userModel->where('email', $data['email'] ?? '')->first();
        if ($existing && (int) $existing['id_utilisateur'] !== (int) $userId) {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => 'Cet email existe deja',
            ]);
        }

        try {
            $userData = array_intersect_key($data, array_flip(['nom', 'email', 'genre']));

            if (!empty($userData)) {
                $userModel->update($userId, $userData);
            }

            $detailsData = array_intersect_key($data, array_flip(['taille', 'poids']));
            if (!empty($detailsData)) {
                $taille = isset($detailsData['taille']) ? (float) $detailsData['taille'] : null;
                $poids = isset($detailsData['poids']) ? (float) $detailsData['poids'] : null;
                if ($taille !== null && $poids !== null) {
                    $detailsData['imc'] = $taille > 0 ? $poids / ($taille ** 2) : null;
                }

                $existingDetails = $detailsModel->where('id_utilisateur', $userId)->first();
                if ($existingDetails) {
                    $detailsModel->update($existingDetails['id'], $detailsData);
                } else {
                    $detailsData['id_utilisateur'] = $userId;
                    $detailsModel->insert($detailsData);
                }
            }

            $updatedUser = $userModel->find($userId);
            $updatedDetails = $detailsModel->where('id_utilisateur', $userId)->first();

            return $this->response->setStatusCode(200)->setJSON([
                'message' => 'Profil mis a jour',
                'user' => $updatedUser,
                'details' => $updatedDetails,
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => $e->getMessage(),
            ]);
        }
    }
}