<?php
    
namespace App\Controllers\FrontOffice;

use App\Controllers\BaseController;
use App\Models\DetailSanteModel;
use App\Models\ObjectifModel;
use App\Models\ObjectifUtilisateurModel;
use App\Models\UtilisateurModel;
use App\Models\CodeRechargeModel;
use App\Models\DemandeRechargeModel;

// use App\Models\
class UserController extends BaseController
{
    // public function index()
    // {
    //     return view('FrontOffice/inscription');
    // }
    public function PageInscription()
    {
        $objectifModel = new ObjectifModel();
        $objectifs = $objectifModel->findAll();

        return view('FrontOffice/inscription', [
            'objectifs' => $objectifs,
        ]);
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

            $objectifId = $data['objectif'] ?? null;
            if ($objectifId !== null && is_numeric($objectifId)) {
                $objectifUtilisateurModel = new ObjectifUtilisateurModel();
                $row = [
                    'id_utilisateur' => $userId,
                    'id_objectif' => (int) $objectifId,
                ];

                if (!$objectifUtilisateurModel->insert($row)) {
                    throw new \Exception("Erreur lors de l'insertion de l'objectif");
                }
            }

            return $this->response->setStatusCode(200)->setJSON([
                'message' => 'Inscription reussie',
                'redirect' => base_url('frontoffice/profile'),
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
    public function profil()
    {
        $idUtilisateur = session()->get('user_id');
        if (!$idUtilisateur) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter.');
        }

        $utilisateurModel = new UtilisateurModel();
        $user = $utilisateurModel->find($idUtilisateur);

        return view('FrontOffice/profil', ['user' => $user]);
    }

    public function demanderRecharge()
    {
        $codeValeur = $this->request->getPost('code');
        $idUtilisateur = session()->get('user_id'); // Identifiant en session

        if (!$idUtilisateur || !$codeValeur) {
            return redirect()->back()->with('error', 'Veuillez vous connecter et saisir un code valide.');
        }

        $codeModel = new CodeRechargeModel();
        $code = $codeModel->where('valeur_code', $codeValeur)->where('statut', 0)->first();

        if (!$code) {
            return redirect()->back()->with('error', 'Code invalide ou déjà utilisé.');
        }

        $codeModel->update($code['id'], ['statut' => 1]);

        $demandeModel = new DemandeRechargeModel();
        $demandeModel->insert([
            'id_utilisateur' => $idUtilisateur,
            'id_code_recharge' => $code['id'],
            'est_valide' => 0
        ]);

        return redirect()->back()->with('success', 'Code soumis avec succès. En attente de validation par l\'administrateur.');
    }

    public function devenirGold()
    {
        $idUtilisateur = session()->get('user_id');
        
        if (!$idUtilisateur) {
            return redirect()->back()->with('error', 'Veuillez vous connecter.');
        }

        $prixGold = 50000.00; // Définir un prix fixe (ex: 50 000 Ariary)

        $utilisateurModel = new UtilisateurModel();
        $user = $utilisateurModel->find($idUtilisateur);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur introuvable.');
        }

        if ($user['est_gold'] === 't' || $user['est_gold'] === true || $user['est_gold'] == 1) {
            return redirect()->back()->with('info', 'Vous êtes déjà membre Gold !');
        }

        if ($user['solde'] < $prixGold) {
            return redirect()->back()->with('error', 'Solde insuffisant pour devenir Gold (Prix : ' . $prixGold . '). Veuillez recharger votre porte-monnaie.');
        }

        // Débiter le solde et rendre Gold
        $nouveauSolde = $user['solde'] - $prixGold;
        $utilisateurModel->update($idUtilisateur, [
            'solde' => $nouveauSolde,
            'est_gold' => 'true' // Adaptation Postgres
        ]);

        return redirect()->back()->with('success', 'Félicitations, vous êtes membre Gold ! Vous bénéficiez de 15% de remise sur tous nos régimes.');
    }
}