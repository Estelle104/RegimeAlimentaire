<?php
$user = $user ?? [];
$details = $details ?? [];
$imc = $details['imc'] ?? null;

if ($imc === null && !empty($details['taille']) && !empty($details['poids'])) {
    $taille = (float) $details['taille'];
    $poids = (float) $details['poids'];
    $imc = $taille > 0 ? $poids / ($taille ** 2) : null;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<body>
    <h1>Profil utilisateur</h1>

    <p>
        <a href="<?= base_url('frontoffice/profile/edit') ?>">Modifier</a>
    </p>

    <h2>Table users</h2>
    <?php if (!empty($user)) : ?>
        <table border="1" cellpadding="6">
            <tbody>
                <tr><th>ID utilisateur</th><td><?= esc($user['id_utilisateur'] ?? '') ?></td></tr>
                <tr><th>Nom</th><td><?= esc($user['nom'] ?? '') ?></td></tr>
                <tr><th>Email</th><td><?= esc($user['email'] ?? '') ?></td></tr>
                <tr><th>Genre</th><td><?= esc($user['genre'] ?? '') ?></td></tr>
                <tr><th>Solde</th><td><?= esc($user['solde'] ?? '') ?></td></tr>
                <tr><th>Est gold</th><td><?= !empty($user['est_gold']) ? 'Oui' : 'Non' ?></td></tr>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucune information utilisateur trouvee.</p>
    <?php endif; ?>

    <h2>Table details_sante</h2>
    <?php if (!empty($details)) : ?>
        <table border="1" cellpadding="6">
            <tbody>
                <tr><th>ID</th><td><?= esc($details['id'] ?? '') ?></td></tr>
                <tr><th>ID utilisateur</th><td><?= esc($details['id_utilisateur'] ?? '') ?></td></tr>
                <tr><th>Taille (cm)</th><td><?= esc($details['taille'] ?? '') ?></td></tr>
                <tr><th>Poids (kg)</th><td><?= esc($details['poids'] ?? '') ?></td></tr>
                <tr><th>IMC</th><td><?= $imc !== null ? esc(number_format((float) $imc, 2)) : '' ?></td></tr>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucune information sante trouvee.</p>
    <?php endif; ?>
</body>
</html>
