<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/backOffice/css/backOffice.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/backOffice/css/connexion.css') ?>">
    <title>Connexion Admin</title>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Connexion Admin</h1>
            <p>Acces reserve aux administrateurs</p>
        </div>

        <form id="adminConnexionForm" method="post" action="<?= base_url('backoffice/connexion') ?>">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="form-submit">Se connecter</button>
        </form>

        <div class="auth-footer">
            <a href="<?= base_url('frontoffice/connexion') ?>">Retour connexion utilisateur</a>
        </div>
    </div>

    <script src="<?= base_url('BackOffice/js/connexion.js') ?>"></script>
</body>
</html>