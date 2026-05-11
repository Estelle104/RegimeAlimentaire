<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>

    <form id="connexionForm" method="post" action="<?= base_url('frontoffice/connexion') ?>">
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>

        <button type="submit">Se connecter</button>
    </form>

        <a href="<?= base_url('frontoffice/inscription') ?>">Pas encore inscrit ?</a>
        <a href="<?= base_url('backoffice/connexion') ?>">Connexion admin</a>

    <script src="<?= base_url('FrontOffice/js/connexion.js') ?>"></script>
</body>
</html>
