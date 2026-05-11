<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="<?= base_url('assets/backOffice/css/backoffice.css') ?>">
    <style>
        body { display: flex; align-items: center; justify-content: center; min-height: 100vh; background: linear-gradient(135deg, #f5f7f0 0%, #e5e9d6 100%); }
        .auth-container { width: 100%; max-width: 420px; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .auth-header { text-align: center; margin-bottom: 32px; }
        .auth-header h1 { color: var(--bo-olive); margin: 0; font-size: 1.8rem; }
        .auth-header p { color: var(--bo-muted); margin: 8px 0 0; font-size: 0.95rem; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; color: var(--bo-text); font-weight: 600; margin-bottom: 6px; font-size: 0.95rem; }
        .form-group input { width: 100%; padding: 10px 14px; border: 1px solid var(--bo-border); border-radius: 8px; font-size: 0.95rem; }
        .form-group input:focus { outline: none; border-color: var(--bo-olive); box-shadow: 0 0 0 3px rgba(111,123,67,0.1); }
        .form-submit { width: 100%; padding: 12px; background: var(--bo-olive); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; margin-top: 10px; }
        .form-submit:hover { background: var(--bo-olive-dark); }
        .auth-footer { text-align: center; margin-top: 24px; font-size: 0.9rem; }
        .auth-footer a { color: var(--bo-olive); text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Connexion</h1>
            <p>Accédez à votre compte</p>
        </div>

        <form id="connexionForm" method="post" action="<?= base_url('frontoffice/connexion') ?>">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <button type="submit" class="form-submit">Se connecter</button>
        </form>

        <div class="auth-footer">
            Pas encore inscrit ? <a href="<?= base_url('frontoffice/inscription') ?>">Créer un compte</a><br>
            <a href="<?= base_url('backoffice/connexion') ?>">Se connecter en tant qu'administrateur</a>
        </div>
    </div>

        <!-- <a href="<?= base_url('frontoffice/inscription') ?>">Pas encore inscrit ?</a>
        > -->

    <script src="<?= base_url('FrontOffice/js/connexion.js') ?>"></script>
</body>
</html>
