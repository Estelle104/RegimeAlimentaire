<?= $this->extend('FrontOffice/modele') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Régimes Recommandés</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="success-message"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="error-message"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="solde-info">
        <span class="label">Solde actuel</span>
        <span class="amount"><?= esc($user['solde']) ?> Ar</span>
    </div>
    
    <?php if($est_gold): ?>
        <div class="gold-badge">Membre Gold — Bénéficiez de 15% de réduction</div>
    <?php endif; ?>

    <?php if(isset($currentIMC)): ?>
        <div class="imc-state <?= ($currentIMC < 18.5) ? 'imc-warning' : (($currentIMC > 25) ? 'imc-danger' : 'imc-ideal'); ?>">
            <div class="imc-header">
                <strong>Indice de Masse Corporelle</strong>
                <span class="imc-value"><?= number_format($currentIMC, 2) ?></span>
            </div>
            <?php 
                if ($currentIMC < 18.5) {
                    echo '<p>Poids insuffisant — Vous devez <strong>prendre du poids</strong> pour atteindre l\'IMC idéal (18.5-25)</p>';
                } elseif ($currentIMC > 25) {
                    echo '<p>Surpoids — Vous devez <strong>perdre du poids</strong> pour atteindre l\'IMC idéal (18.5-25)</p>';
                } else {
                    echo '<p>Votre IMC est idéal — Continuez à maintenir cette plage (18.5-25)</p>';
                }
            ?>
        </div>
    <?php endif; ?>

    <div class="divider"></div>

    <?php if(!empty($suggestions)): ?>
        <div class="regimes-grid">
            <?php foreach($suggestions as $regime): ?>
                <div class="regime-card">
                    <div class="regime-header">
                        <h3><?= esc($regime['regime']) ?></h3>
                        <span class="sport-tag"><?= esc($regime['sport']) ?></span>
                    </div>
                    
                    <div class="regime-content">
                        <div class="info-row">
                            <span class="label">Durée du programme</span>
                            <span class="value"><?= esc($regime['duree'] ?? $regime['duree_jours']) ?> jours</span>
                        </div>

                        <div class="info-row">
                            <span class="label">Variation pondérale</span>
                            <span class="value <?php 
                                $variation = (float) $regime['variation_poids_kg'];
                                echo ($variation < 0) ? 'negative' : (($variation > 0) ? 'positive' : 'neutral');
                            ?>">
                                <?php 
                                    $variation = (float) $regime['variation_poids_kg'];
                                    if ($variation < 0) {
                                        echo abs($variation) . ' kg (perte)';
                                    } elseif ($variation > 0) {
                                        echo '+' . $variation . ' kg (gain)';
                                    } else {
                                        echo 'Maintien';
                                    }
                                ?>
                            </span>
                        </div>
                        
                        <?php if(!empty($regime['jours_pour_imc']) && $idObjectifs == 3): ?>
                            <div class="info-row highlight">
                                <span class="label">Durée IMC idéal</span>
                                <span class="value"><?= esc($regime['jours_pour_imc']) ?> jours</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="regime-footer">
                        <div class="prix-section">
                            <?php 
                                if($est_gold && isset($regime['prix_final'])) {
                                    echo '<span class="prix-original">' . number_format($regime['prix'], 0) . ' Ar</span>';
                                    echo '<span class="prix-final">' . number_format($regime['prix_final'], 0) . ' Ar</span>';
                                } else {
                                    echo '<span class="prix-final">' . number_format($regime['prix_final'] ?? $regime['prix'], 0) . ' Ar</span>';
                                }
                            ?>
                        </div>

                        <form action="<?= base_url('frontoffice/acheter-regime/' . $regime['id']) ?>" method="post">
                            <button type="submit" class="btn-primary">Acheter</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-results">
            <p>Aucun régime recommandé trouvé.</p>
            <p>Assurez-vous que votre profil est complet et que vous avez un objectif assigné.</p>
        </div>
    <?php endif; ?>

    <div class="divider"></div>
    
    <div class="footer-actions">
        <a href="<?= base_url('frontoffice/profile') ?>" class="btn-secondary">Profil</a>
        <a href="<?= base_url('frontoffice/exporter-pdf') ?>" class="btn-secondary">Télécharger PDF</a>
    </div>
</div>
<?= $this->endSection() ?>
