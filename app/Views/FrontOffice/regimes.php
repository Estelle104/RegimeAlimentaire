<?= $this->extend('FrontOffice/modele') ?>

<?= $this->section('content') ?>
        <h1>Mes Régimes Recommandés</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green; font-weight: bold;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <p style="color: red; font-weight: bold;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <p><strong>Solde actuel :</strong> <?= esc($user['solde']) ?> Ariary</p>
    <?php if($est_gold): ?>
        <p style="background-color: gold; padding: 10px; border-radius: 5px; font-weight: bold;">⭐ Vous êtes Gold ! Bénéficiez de 15% de réduction sur tous les régimes.</p>
    <?php endif; ?>

    <hr>

    <?php if(!empty($suggestions)): ?>
        <?php foreach($suggestions as $regime): ?>
            <div class="regime-card">
                <h4><?= esc($regime['regime']) ?></h4>
                <p><strong>Sport recommandé :</strong> <?= esc($regime['sport']) ?></p>
                <p><strong>Durée :</strong> <?= esc($regime['duree']) ?> jours</p>
                <p><strong>Perte de poids estimée :</strong> <?= esc($regime['variation_poids_kg']) ?> kg</p>
                
                <div class="prix">
                    <?php 
                        $prixFinal = $regime['prix'];
                        if($est_gold) {
                            $prixRemise = $regime['prix'] * 0.85;
                            echo '<span class="prix-remise">' . number_format($regime['prix'], 2) . '</span>';
                            echo number_format($prixRemise, 2) . ' Ariary';
                        } else {
                            echo number_format($regime['prix'], 2) . ' Ariary';
                        }
                    ?>
                </div>

                <form action="<?= base_url('frontoffice/acheter-regime/' . $regime['id']) ?>" method="post" style="margin-top: 10px;">
                    <button type="submit" class="btn">Acheter ce régime</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #999;">Aucun régime recommandé trouvé. Complétez votre profil avec vos objectifs pour voir les recommandations.</p>
    <?php endif; ?>

    <hr>
    <div style="margin-top: 20px;">
        <a href="<?= base_url('frontoffice/profile') ?>" style="padding: 10px 15px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px;">Retour au profil</a>
        <a href="<?= base_url('frontoffice/exporter-pdf') ?>" style="padding: 10px 15px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">📥 Telecharger en PDF</a>
    </div>
<?= $this->endSection() ?>
