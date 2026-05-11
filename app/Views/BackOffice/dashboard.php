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

    <div class="section-head">
        <div>
            <p class="backoffice-kicker">Tableau de bord</p>
            <h2>Dashboard</h2>
        </div>
    </div>

    <h3 class="small-muted">Indicateurs</h3>
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-label">Régimes</div>
            <div class="kpi-value"><?= htmlspecialchars((string) ($stats['total_regimes'] ?? 0)) ?></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Utilisateurs</div>
            <div class="kpi-value"><?= htmlspecialchars((string) ($stats['total_utilisateurs'] ?? 0)) ?></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Achats</div>
            <div class="kpi-value"><?= htmlspecialchars((string) ($stats['total_achats'] ?? 0)) ?></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Codes validés</div>
            <div class="kpi-value"><?= htmlspecialchars((string) ($stats['codes_valides'] ?? 0)) ?></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Codes en attente</div>
            <div class="kpi-value"><?= htmlspecialchars((string) ($stats['codes_en_attente'] ?? 0)) ?></div>
        </div>
    </div>

    <div class="charts-row">
        <div class="chart-card">
            <h3 class="small-muted">Achats par régime</h3>
            <canvas id="achatsByRegime"></canvas>
        </div>
        <div class="chart-card">
            <h3 class="small-muted">Codes (validés / attente)</h3>
            <canvas id="codesStatus"></canvas>
        </div>
    </div>

    <?php
    // Préparer les données JSON pour JS
    $labels = [];
    $dataAchats = [];
    foreach ($achatsParRegime as $ligne) {
        $labels[] = (string) ($ligne['nom_regime'] ?? '');
        $dataAchats[] = (int) ($ligne['total_achats'] ?? 0);
    }

    $codesValides = (int) ($stats['codes_valides'] ?? 0);
    $codesAttente = (int) ($stats['codes_en_attente'] ?? 0);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function(){
            const achatsCtx = document.getElementById('achatsByRegime').getContext('2d');
            const labels = <?= json_encode($labels, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT) ?>;
            const data = <?= json_encode($dataAchats) ?>;

            new Chart(achatsCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Achats',
                        data: data,
                        backgroundColor: labels.map(()=> 'rgba(111,123,67,0.85)'),
                        borderColor: labels.map(()=> 'rgba(85,97,54,0.95)'),
                        borderWidth: 1,
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision:0 } }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            const codesCtx = document.getElementById('codesStatus').getContext('2d');
            new Chart(codesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Validés','En attente'],
                    datasets: [{
                        data: [<?= $codesValides ?>, <?= $codesAttente ?>],
                        backgroundColor: ['rgba(111,123,67,0.9)', 'rgba(178,75,63,0.9)'],
                        hoverOffset: 8
                    }]
                },
                options: { plugins: { legend: { position: 'bottom' } }, responsive:true, maintainAspectRatio:false }
            });
        })();
    </script>

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