<?php
$user = $user ?? [];
$details = $details ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier profil</title>
</head>
<body>
    <h1>Modifier le profil</h1>

    <form id="profileEditForm" method="post" action="<?= base_url('frontoffice/profile') ?>">
        <div>
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?= esc($user['nom'] ?? '') ?>" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= esc($user['email'] ?? '') ?>" required>
        </div>

        <div>
            <label for="genre">Genre</label>
            <select id="genre" name="genre">
                <option value="">Choisir</option>
                <option value="Homme" <?= (isset($user['genre']) && $user['genre'] === 'Homme') ? 'selected' : '' ?>>Homme</option>
                <option value="Femme" <?= (isset($user['genre']) && $user['genre'] === 'Femme') ? 'selected' : '' ?>>Femme</option>
            </select>
        </div>

        <div>
            <label for="taille">Taille (cm)</label>
            <input type="number" id="taille" name="taille" value="<?= esc($details['taille'] ?? '') ?>" min="0">
        </div>

        <div>
            <label for="poids">Poids (kg)</label>
            <input type="number" id="poids" name="poids" value="<?= esc($details['poids'] ?? '') ?>" min="0">
        </div>

        <button type="submit">Enregistrer</button>
        <a href="<?= base_url('frontoffice/profile') ?>">Annuler</a>
    </form>

    <script>
    const form = document.getElementById('profileEditForm');

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const data = {
            nom: document.getElementById('nom').value,
            email: document.getElementById('email').value,
            genre: document.getElementById('genre').value,
            taille: document.getElementById('taille').value,
            poids: document.getElementById('poids').value
        };

        const xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        xhr.onreadystatechange = function () {
            if (xhr.readyState !== 4) {
                return;
            }

            let response = {};
            try {
                response = JSON.parse(xhr.responseText);
            } catch (error) {
                alert('Erreur serveur, reponse invalide.');
                return;
            }

            if (xhr.status === 200) {
                alert(response.message || 'Profil mis a jour');
                window.location.href = '<?= base_url('frontoffice/profile') ?>';
                return;
            }

            alert(response.message || 'Erreur de mise a jour');
        };

        xhr.onerror = function () {
            alert('Erreur reseau');
        };

        xhr.send(JSON.stringify(data));
    });
    </script>
</body>
</html>
