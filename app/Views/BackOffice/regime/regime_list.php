<?php
$regimes = isset($regimes) ? $regimes : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des régimes</title>
</head>

<body>
    <h1>Liste des régimes</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Libellé</th>
                <th>Pourcentage de viande</th>
                <th>Pourcentage de poisson</th>
                <th>Pourcentage de volaille</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($regimes as $regime): ?>
                <tr>
                    <td><?= $regime['id'] ?></td>
                    <td><?= $regime['libelle'] ?></td>
                    <td><?= $regime['pourcentage_viande'] ?></td>
                    <td><?= $regime['pourcentage_poisson'] ?></td>
                    <td><?= $regime['pourcentage_volaille'] ?></td>
                    <td>
                        <a href="<?= base_url('backoffice/regimes/update/' . $regime['id']) ?>">
                            Update
                        </a>

                        |
                        
                        <a href="<?= base_url('backoffice/regimes/delete/' . $regime['id']) ?>"
                            onclick="return confirm('Supprimer ce régime ?')">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>