<?php
$regimes = isset($regimes) ? $regimes : [];
?>

<?= $this->extend('BackOffice/modele') ?>

<?= $this->section('content') ?>
    <section class="content-card">
        <div class="section-head">
            <div>
                <p class="backoffice-kicker">Gestion des régimes</p>
                <h1>Liste des régimes</h1>
            </div>
            <a href="<?= base_url('backoffice/regimes/add') ?>" class="action-link action-link--edit">Ajouter un régime</a>
        </div>

        <?php if (! empty($regimes)): ?>
            <div class="regime-grid">
                <?php foreach ($regimes as $regime): ?>
                    <?php
                        $nomRegime = trim((string) ($regime['libelle'] ?? 'Régime sans nom'));
                        $imageValue = trim((string) ($regime['images'] ?? ''));
                        $imageSource = '';

                        if ($imageValue !== '') {
                            if (preg_match('#^https?://#i', $imageValue)) {
                                $imageSource = $imageValue;
                            } else {
                                $candidatePath = ltrim($imageValue, '/');
                                if (is_file(FCPATH . $candidatePath)) {
                                    $imageSource = base_url($candidatePath);
                                }
                            }
                        }
                    ?>
                    <article class="regime-card">
                        <div class="regime-card__media">
                            <?php if ($imageSource !== ''): ?>
                                <img src="<?= esc($imageSource) ?>" alt="<?= esc($nomRegime) ?>">
                            <?php else: ?>
                                <div class="regime-card__fallback"><?= esc($nomRegime) ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="regime-card__body">
                            <div class="regime-card__title-row">
                                <h2><?= esc($nomRegime) ?></h2>
                                <span class="regime-badge">#<?= esc((string) ($regime['id'] ?? '')) ?></span>
                            </div>

                            <div class="regime-meta">
                                <span><strong>Viande</strong> <?= esc((string) ($regime['pourcentage_viande'] ?? '')) ?>%</span>
                                <span><strong>Poisson</strong> <?= esc((string) ($regime['pourcentage_poisson'] ?? '')) ?>%</span>
                                <span><strong>Volaille</strong> <?= esc((string) ($regime['pourcentage_volaille'] ?? '')) ?>%</span>
                            </div>

                            <div class="regime-actions">
                                <a class="action-link action-link--edit" href="<?= base_url('backoffice/regimes/update/' . $regime['id']) ?>">Modifier</a>
                                <a class="action-link action-link--delete" href="<?= base_url('backoffice/regimes/delete/' . $regime['id']) ?>" onclick="return confirm('Supprimer ce régime ?')">Supprimer</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="empty-state">Aucun régime disponible pour le moment.</p>
        <?php endif; ?>
    </section>
<?= $this->endSection() ?>