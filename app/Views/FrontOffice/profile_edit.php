<?php
$user = $user ?? [];
$details = $details ?? [];
?>

<?= $this->extend('FrontOffice/modele') ?>

<?= $this->section('content') ?>
    <section class="content-card">
        <div class="section-head">
            <div>
                <p class="backoffice-kicker">Maintenance de compte</p>
                <h1>Modifier le profil</h1>
            </div>
        </div>

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

            <div style="display:flex;gap:10px;margin-top:16px;">
                <button type="submit" class="backoffice-main button">Enregistrer</button>
                <a href="<?= base_url('frontoffice/profile') ?>" class="action-link action-link--delete">Annuler</a>
            </div>
        </form>
    </section>

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
                if (xhr.readyState !== 4) return;
                let response = {};
                try { response = JSON.parse(xhr.responseText); } catch (e) { alert('Erreur serveur.'); return; }
                if (xhr.status === 200) {
                    alert(response.message || 'Profil mis à jour');
                    window.location.href = '<?= base_url('frontoffice/profile') ?>';
                    return;
                }
                alert(response.message || 'Erreur de mise à jour');
            };
            xhr.onerror = function () { alert('Erreur réseau'); };
            xhr.send(JSON.stringify(data));
        });
    </script>
<?= $this->endSection() ?>
