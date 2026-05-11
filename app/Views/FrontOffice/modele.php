<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FrontOffice</title>
    <link rel="stylesheet" href="<?= base_url('assets/backOffice/css/backoffice.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/frontOffice/css/front.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="backoffice-shell">
        <aside class="backoffice-sidebar">
            <div class="backoffice-brand">
                <p class="backoffice-kicker">FrontOffice</p>
                <h1>Regime Alimentaire</h1>
                <p class="backoffice-subtitle">Explorez les régimes</p>
            </div>

            <nav class="backoffice-nav" aria-label="Navigation frontoffice">
                <a href="<?= base_url('frontoffice/profile') ?>">Accueil</a>
                <a href="<?= base_url('frontoffice/profile') ?>">Profil</a>
                <a href="<?= base_url('frontoffice/regimes') ?>">Mes régimes</a>
                <a href="<?= base_url('/') ?>">Deconnexion</a>
            </nav>
        </aside>

        <div class="backoffice-content">
            <header class="backoffice-topbar">
                <div>
                    <p class="backoffice-kicker">Espace utilisateur</p>
                    <h2>Bienvenue</h2>
                </div>
            </header>

            <main class="backoffice-main">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
</body>
</html>