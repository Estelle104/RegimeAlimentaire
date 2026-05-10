<?= $this->extend('BackOffice/modele') ?>

<?= $this->section('content') ?>
<?php
$stats = $stats ?? [];
$recentAchats = $recentAchats ?? [];
$recentCodes = $recentCodes ?? [];
$achatsParRegime = $achatsParRegime ?? [];

$maxAchats = 0;
foreach ($achatsParRegime as $ligne) {
    $maxAchats = max($maxAchats, (int) ($ligne['total_achats'] ?? 0));
}
?>

    <h2>Dashboard</h2>

    <h3>Indicateurs</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Régimes</th>
                <th>Utilisateurs</th>
                <th>Achats</th>
                <th>Codes validés</th>
                <th>Codes en attente</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= htmlspecialchars((string) ($stats['total_regimes'] ?? 0)) ?></td>
                <td><?= htmlspecialchars((string) ($stats['total_utilisateurs'] ?? 0)) ?></td>
                <td><?= htmlspecialchars((string) ($stats['total_achats'] ?? 0)) ?></td>
                <td><?= htmlspecialchars((string) ($stats['codes_valides'] ?? 0)) ?></td>
                <td><?= htmlspecialchars((string) ($stats['codes_en_attente'] ?? 0)) ?></td>
            </tr>
        </tbody>
    </table>

    <h3>Achats par régime</h3>
    <?php if ($achatsParRegime === []): ?>
        <p>Aucune donnée d'achat disponible pour le moment.</p>
    <?php else: ?>
        <svg width="700" height="<?php echo 60 + (count($achatsParRegime) * 40); ?>" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Graphique des achats par régime">
            <?php foreach ($achatsParRegime as $index => $ligne): ?>
                <?php
                $nomRegime = (string) ($ligne['nom_regime'] ?? '');
                $totalAchats = (int) ($ligne['total_achats'] ?? 0);
                $barWidth = $maxAchats > 0 ? (int) round(($totalAchats / $maxAchats) * 420) : 0;
                $y = 30 + ($index * 40);
                ?>
                <text x="10" y="<?= $y ?>" font-size="14"><?= htmlspecialchars($nomRegime) ?></text>
                <rect x="200" y="<?= $y - 12 ?>" width="<?= $barWidth ?>" height="18" fill="black"></rect>
                <text x="630" y="<?= $y ?>" font-size="14"><?= htmlspecialchars((string) $totalAchats) ?></text>
            <?php endforeach; ?>
        </svg>
    <?php endif; ?>

    <h3>Derniers achats</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Régime</th>
                <th>Prix payé</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($recentAchats === []): ?>
                <tr>
                    <td colspan="4">Aucun achat enregistré</td>
                </tr>
            <?php else: ?>
                <?php foreach ($recentAchats as $achat): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) ($achat['id'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($achat['nom_utilisateur'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($achat['nom_regime'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($achat['prix_paye'] ?? '')) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <h3>Derniers codes</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Montant</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($recentCodes === []): ?>
                <tr>
                    <td colspan="4">Aucun code enregistré</td>
                </tr>
            <?php else: ?>
                <?php foreach ($recentCodes as $code): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) ($code['id'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($code['valeur_code'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($code['montant'] ?? '')) ?></td>
                        <td><?= ((int) ($code['statut'] ?? 0)) === 1 ? 'Validé' : 'En attente' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>