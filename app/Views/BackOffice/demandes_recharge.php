<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - Recharges</title>
    <style>table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; }</style>
</head>
<body>
    <h1>Administration : Validation des codes de recharge</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green; font-weight: bold;"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <p style="color: red; font-weight: bold;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID Demande</th>
            <th>ID Utilisateur</th>
            <th>Valeur Code</th>
            <th>Montant</th>
            <th>Actions</th>
        </tr>
        <?php if(!empty($demandes_en_attente)): ?>
            <?php foreach($demandes_en_attente as $demande): ?>
                <tr>
                    <td><?= esc($demande['id']) ?></td>
                    <td><?= esc($demande['id_utilisateur']) ?></td>
                    <td><?= esc($demande['valeur_code']) ?></td>
                    <td><?= esc($demande['montant']) ?> Ariary</td>
                    <td>
                        <a href="<?= base_url('backoffice/recharges/valider/' . $demande['id']) ?>" style="color: green;">Valider</a> | 
                        <a href="<?= base_url('backoffice/recharges/refuser/' . $demande['id']) ?>" style="color: red;">Refuser</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Aucune demande en attente.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
