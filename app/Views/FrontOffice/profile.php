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

<?= $this->extend('FrontOffice/modele') ?>

<?= $this->section('content') ?>
    <section class="content-card">
        <div class="section-head">
            <div>
                <p class="backoffice-kicker">Vos informations</p>
                <h1>Profil utilisateur</h1>
            </div>
            <a href="<?= base_url('frontoffice/profile/edit') ?>" class="action-link action-link--edit">Modifier</a>
        </div>

        <h3 class="small-muted">Informations personnelles</h3>
        <?php if (!empty($user)) : ?>
            <table>
                <tbody>
                    <tr><th>Nom</th><td><?= esc($user['nom'] ?? '') ?></td></tr>
                    <tr><th>Email</th><td><?= esc($user['email'] ?? '') ?></td></tr>
                    <tr><th>Genre</th><td><?= esc($user['genre'] ?? '') ?></td></tr>
                    <tr><th>Solde</th><td><?= esc($user['solde'] ?? '') ?> Ariary</td></tr>
                    <tr><th>Statut</th><td><?= !empty($user['est_gold']) ? '⭐ Gold' : 'Standard' ?></td></tr>
                </tbody>
            </table>
        <?php else : ?>
            <p class="small-muted">Aucune information utilisateur trouvée.</p>
        <?php endif; ?>

        <h3 class="small-muted" style="margin-top:22px;">Données santé</h3>
        <?php if (!empty($details)) : ?>
            <table>
                <tbody>
                    <tr><th>Taille (cm)</th><td><?= esc($details['taille'] ?? '-') ?></td></tr>
                    <tr><th>Poids (kg)</th><td><?= esc($details['poids'] ?? '-') ?></td></tr>
                    <tr><th>IMC</th><td><?= $imc !== null ? esc(number_format((float) $imc, 1)) : '-' ?></td></tr>
                </tbody>
            </table>
        <?php else : ?>
            <p class="small-muted">Aucune information santé trouvée.</p>
        <?php endif; ?>

        <div style="margin-top:22px;padding:16px;background:#e5e9d6;border-radius:12px;">
            <h3 class="small-muted">Mes Régimes</h3>
            <p>Découvrez les régimes recommandés pour vous en fonction de vos objectifs !</p>
            <a href="<?= base_url('frontoffice/regimes') ?>" class="action-link action-link--edit">Voir les régimes</a>
        </div>
    </section>
<?= $this->endSection() ?>
