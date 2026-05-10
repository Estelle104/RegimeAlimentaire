<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil (Test)</title>
</head>
<body>
    <h1>Mon Profil</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green; font-weight: bold;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <p style="color: red; font-weight: bold;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>
    <?php if(session()->getFlashdata('info')): ?>
        <p style="color: blue; font-weight: bold;"><?= session()->getFlashdata('info') ?></p>
    <?php endif; ?>

    <h3>Informations</h3>
    <p><strong>Solde actuel :</strong> <?= esc($user['solde'] ?? 0) ?> Ariary</p>
    <p><strong>Statut Gold :</strong> <?= (!empty($user['est_gold']) && ($user['est_gold'] === 't' || $user['est_gold'] == 1)) ? 'Oui (15% de remise activée)' : 'Non' ?></p>
    
    <hr>

    <h3>Recharger mon porte-monnaie</h3>
    <form action="<?= base_url('frontoffice/recharge') ?>" method="post">
        <label>Entrez votre code (ex: CODE50A) :</label><br>
        <input type="text" name="code" required>
        <button type="submit">Valider le code</button>
    </form>
    <br>
    <i>Codes de test dispo : CODE10A, CODE50A, CODE100A, CODE200A...</i>

    <hr>

    <h3>Devenir membre GOLD</h3>
    <p>Prix pour devenir Gold : <strong>50 000 Ariary</strong> (en une seule fois)</p>
    <form action="<?= base_url('frontoffice/devenir-gold') ?>" method="post">
        <button type="submit" style="background: gold; padding: 10px; font-weight: bold;">Mettre à niveau mon compte</button>
    </form>
</body>
</html>
