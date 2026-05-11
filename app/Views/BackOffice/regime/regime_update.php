<?php $regime = $regime ?? []; ?>
<?= $this->extend('BackOffice/modele') ?>

<?= $this->section('content') ?>
    <h1>Mis a jour de Regime</h1>
    <?php if (! empty($regime['id'])): ?>
        <form action="<?= base_url('backoffice/regimes/update/' . ($regime['id'] ?? '')) ?>" method="post">

            <label for="libelle">Libellé:</label>
            <input type="text" id="libelle" name="libelle" value="<?= $regime['libelle'] ?? '' ?>" required><br>

            <label for="pourcentage_viande">Pourcentage de viande:</label>
            <input type="number" id="pourcentage_viande" name="pourcentage_viande" value="<?= $regime['pourcentage_viande'] ?? '' ?>" required><br>

            <label for="pourcentage_poisson">Pourcentage de poisson:</label>
            <input type="number" id="pourcentage_poisson" name="pourcentage_poisson" value="<?= $regime['pourcentage_poisson'] ?? '' ?>" required><br>

            <label for="pourcentage_volaille">Pourcentage de volaille:</label>
            <input type="number" id="pourcentage_volaille" name="pourcentage_volaille" value="<?= $regime['pourcentage_volaille'] ?? '' ?>" required><br>

            <h3>Effet / Détails du régime</h3>

            <label for="duree_jours">Durée (jours):</label>
            <input type="number" id="duree_jours" name="duree_jours" value="<?= isset($detail['duree_jours']) ? $detail['duree_jours'] : '' ?>"><br>

            <label for="prix">Prix:</label>
            <input type="number" id="prix" name="prix" step="0.01" value="<?= isset($detail['prix']) ? $detail['prix'] : '' ?>"><br>

            <label for="variation_poids_kg">Variation poids (kg):</label>
            <input type="number" id="variation_poids_kg" name="variation_poids_kg" step="0.01" value="<?= isset($detail['variation_poids_kg']) ? $detail['variation_poids_kg'] : '' ?>"><br>

            <button type="submit">Mettre à jour</button>
        </form>
    <?php else: ?>
        <p>Erreur : aucun régime sélectionné</p>
    <?php endif; ?>

    <p>
        <a href="<?= base_url('backoffice/regimes') ?>">Retour à la liste</a>
    </p>
<?= $this->endSection() ?>