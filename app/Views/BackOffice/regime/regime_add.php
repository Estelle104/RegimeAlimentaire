<?= $this->extend('BackOffice/modele') ?>

<?= $this->section('content') ?>
    <section class="content-card">
        <div class="section-head">
            <div>
                <p class="backoffice-kicker">Gestion des régimes</p>
                <h1>Ajouter un nouveau régime</h1>
            </div>
        </div>

        <form method="post" action="<?= base_url('backoffice/regimes/create') ?>" style="max-width: 600px;">
            <div style="margin-bottom: 18px;">
                <label for="libelle" style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--bo-text);">Nom du régime</label>
                <input type="text" id="libelle" name="libelle" placeholder="ex: Régime Protéiné" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--bo-border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 18px;">
                <label for="pourcentage_viande" style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--bo-text);">% de viande</label>
                <input type="number" id="pourcentage_viande" name="pourcentage_viande" min="0" max="100" placeholder="0-100" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--bo-border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 18px;">
                <label for="pourcentage_poisson" style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--bo-text);">% de poisson</label>
                <input type="number" id="pourcentage_poisson" name="pourcentage_poisson" min="0" max="100" placeholder="0-100" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--bo-border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 18px;">
                <label for="pourcentage_volaille" style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--bo-text);">% de volaille</label>
                <input type="number" id="pourcentage_volaille" name="pourcentage_volaille" min="0" max="100" placeholder="0-100" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--bo-border); border-radius: 8px;">
            </div>

            <div style="display: flex; gap: 10px; margin-top: 22px;">
                <button type="submit" class="backoffice-main button" style="padding: 12px 24px; background: var(--bo-olive); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Créer le régime</button>
                <a href="<?= base_url('backoffice/regimes') ?>" class="action-link action-link--delete" style="padding: 12px 24px; text-decoration: none; display: inline-block;">Annuler</a>
            </div>
        </form>
    </section>
<?= $this->endSection() ?>
