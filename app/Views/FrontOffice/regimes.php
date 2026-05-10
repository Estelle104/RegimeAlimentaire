<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Régimes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .regime-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .regime-card h4 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .prix {
            font-weight: bold;
            font-size: 18px;
            color: #28a745;
        }
        .prix-remise {
            text-decoration: line-through;
            color: #999;
            margin-right: 10px;
        }
        .btn {
            padding: 8px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .gold-badge {
            background-color: gold;
            color: black;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
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
    <a href="<?= base_url('frontoffice/profil') ?>" style="padding: 10px 15px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 5px;">Retour au profil</a>
</body>
</html>
