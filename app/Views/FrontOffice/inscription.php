<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="<?= base_url('assets/backOffice/css/backoffice.css') ?>">
    <style>
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background: linear-gradient(135deg, #f5f7f0 0%, #e5e9d6 100%); padding: 20px; }
        .auth-container { width: 100%; max-width: 420px; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .auth-header { text-align: center; margin-bottom: 32px; }
        .auth-header h1 { color: var(--bo-olive); margin: 0; font-size: 1.8rem; }
        .auth-header p { color: var(--bo-muted); margin: 8px 0 0; font-size: 0.95rem; }
        .hidden { display: none; }
        .input-error { border: 1px solid #b24b3f; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; color: var(--bo-text); font-weight: 600; margin-bottom: 6px; font-size: 0.95rem; }
        .form-group input, .form-group select { width: 100%; padding: 10px 14px; border: 1px solid var(--bo-border); border-radius: 8px; font-size: 0.95rem; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: var(--bo-olive); box-shadow: 0 0 0 3px rgba(111,123,67,0.1); }
        .objectifs-list { display: grid; gap: 10px; margin-top: 8px; }
        .objectif-option { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border: 1px solid var(--bo-border); border-radius: 10px; background: #fff; cursor: pointer; }
        .objectif-option input { width: auto; margin: 0; }
        .objectif-option span { color: var(--bo-text); font-weight: 600; font-size: 0.92rem; }
        .objectif-option input[type="radio"] { accent-color: var(--bo-olive); }
        .objectif-option:has(input:checked) { border-color: var(--bo-olive); box-shadow: 0 0 0 3px rgba(111,123,67,0.08); }
        .error { color: #b24b3f; font-size: 12px; margin-top: 4px; display: none; }
        .error.show { display: block; }
        .form-submit { width: 100%; padding: 12px; background: var(--bo-olive); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; margin-top: 10px; }
        .form-submit:hover { background: var(--bo-olive-dark); }
        .auth-footer { text-align: center; margin-top: 24px; font-size: 0.9rem; }
        .auth-footer a { color: var(--bo-olive); text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1 id="stepTitle">Inscription</h1>
            <p id="stepSubtitle">Créez votre compte - Étape 1/2</p>
        </div>

        <!-- ETAPE 1 -->
        <div id="step1">
            <div class="form-group">
                <label for="nom">Nom complet</label>
                <input type="text" id="nom" placeholder="Entrez votre nom">
                <div class="error" id="nomError"></div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Entrez votre email">
                <div class="error" id="emailError"></div>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" placeholder="Minimum 8 caractères">
                <div class="error" id="motDePasseError"></div>
            </div>

            <div class="form-group">
                <label for="genre">Genre</label>
                <div class="objectifs-list">
                    <label class="objectif-option">
                        <input type="radio" name="genre" value="Homme">
                        <span>Homme</span>
                    </label>
                    <label class="objectif-option">
                        <input type="radio" name="genre" value="Femme">
                        <span>Femme</span>
                    </label>
                </div>
                <div class="error" id="genreError"></div>
            </div>
            <button type="button" class="form-submit" onclick="goToStep2()">Suivant</button>
        </div>

        <!-- ETAPE 2 -->
        <div id="step2" class="hidden">
            <div class="form-group">
                <label for="taille">Taille (cm)</label>
                <input type="number" id="taille" placeholder="Exemple: 175" min="100" max="250">
                <div class="error" id="tailleError"></div>
            </div>

            <div class="form-group">
                <label for="poids">Poids (kg)</label>
                <input type="number" id="poids" placeholder="Exemple: 70" min="20" max="250">
                <div class="error" id="poidsError"></div>
            </div>

            <div class="form-group">
                <label>Objectifs</label>
                <?php if (!empty($objectifs)) : ?>
                    <div class="objectifs-list">
                        <?php foreach ($objectifs as $objectif) : ?>
                            <label class="objectif-option">
                                <input type="radio" name="objectif" value="<?= esc($objectif['id']) ?>">
                                <span><?= esc($objectif['libelle']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div>Aucun objectif disponible.</div>
                <?php endif; ?>
            </div>

            <button type="button" class="form-submit" onclick="register()">S'inscrire</button>
        </div>
    </div>

    <div class="auth-footer" style="margin-top: 20px; text-align: center;">
        Déjà inscrit ? <a href="<?= base_url('frontoffice/connexion') ?>">Se connecter</a>
    </div>

    <script src="<?= base_url('FrontOffice/js/inscription.js') ?>"></script>
</body>
</html>