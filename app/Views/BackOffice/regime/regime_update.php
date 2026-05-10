<?php $regime = $regime ?? []; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis a jour de Regime</title>
</head>

<body>
    <h1>Mis a jour de Regime</h1>
    <form action="<?= base_url('backoffice/regimes/update/' . ($regime['id'] ?? '')) ?>" method="post">
        <?php if (!empty($regime['id'])): ?>

            <label for="libelle">Libellé:</label>
            <input type="text" id="libelle" name="libelle" value="<?= $regime['libelle'] ?? '' ?>" required><br>

            <label for="pourcentage_viande">Pourcentage de viande:</label>
            <input type="number" id="pourcentage_viande" name="pourcentage_viande" value="<?= $regime['pourcentage_viande'] ?? '' ?>" required><br>

            <label for="pourcentage_poisson">Pourcentage de poisson:</label>
            <input type="number" id="pourcentage_poisson" name="pourcentage_poisson" value="<?= $regime['pourcentage_poisson'] ?? '' ?>" required><br>

            <label for="pourcentage_volaille">Pourcentage de volaille:</label>
            <input type="number" id="pourcentage_volaille" name="pourcentage_volaille" value="<?= $regime['pourcentage_volaille'] ?? '' ?>" required><br>

            <button type="submit">Mettre à jour</button>
            </form>
            <?php else: ?>
                <p>Erreur : aucun régime sélectionné</p>
            <?php endif; ?>

            <p>
                <a href="<?= base_url('backoffice/regimes') ?>">Retour à la liste</a>
            </p>
</body>

</html>