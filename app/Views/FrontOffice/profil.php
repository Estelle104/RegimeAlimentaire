<?= $this->extend('FrontOffice/modele') ?>

<?= $this->section('content') ?>
    <section class="content-card">
        <div class="section-head">
            <div>
                <p class="backoffice-kicker">Gestion de compte</p>
                <h1>Mon Profil</h1>
            </div>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <p style="color:green;font-weight:700;margin:0 0 14px;">✓ <?= session()->getFlashdata('success') ?></p>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <p style="color:red;font-weight:700;margin:0 0 14px;">✕ <?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>
        <?php if(session()->getFlashdata('info')): ?>
            <p style="color:#2d3328;font-weight:700;margin:0 0 14px;">ℹ <?= session()->getFlashdata('info') ?></p>
        <?php endif; ?>

        <div class="kpi-grid" style="margin-bottom:22px;">
            <div class="kpi-card">
                <div class="kpi-label">Solde</div>
                <div class="kpi-value"><?= number_format((float) ($user['solde'] ?? 0), 0, ',', ' ') ?></div>
                <div class="small-muted">Ariary</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Statut</div>
                <div class="kpi-value" style="font-size:1.4rem;"><?= (!empty($user['est_gold']) && ($user['est_gold'] === 't' || $user['est_gold'] == 1)) ? '⭐' : '✓' ?></div>
                <div class="small-muted"><?= (!empty($user['est_gold']) && ($user['est_gold'] === 't' || $user['est_gold'] == 1)) ? 'Gold' : 'Standard' ?></div>
            </div>
        </div>

        <h3 class="small-muted">Recharger mon porte-monnaie</h3>
        <form action="<?= base_url('frontoffice/recharge') ?>" method="post" style="display:grid;gap:12px;max-width:400px;">
            <div>
                <label for="code">Code de recharge</label>
                <input type="text" id="code" name="code" placeholder="Ex: CODE50A" required>
            </div>
            <button type="submit" class="backoffice-main button">Valider le code</button>
        </form>
        <p class="small-muted" style="font-size:0.85rem;margin-top:8px;">Codes de test : CODE10A, CODE50A, CODE100A, CODE200A</p>

        <hr style="margin:22px 0;border:none;border-top:1px solid var(--bo-border);">

        <h3 class="small-muted">Devenir membre GOLD</h3>
        <p>Profitez de <strong>15% de réduction</strong> sur tous les régimes</p>
        <p class="small-muted">Tarif : <strong>50 000 Ariary</strong> (une seule fois)</p>
        <form action="<?= base_url('frontoffice/devenir-gold') ?>" method="post">
            <button type="submit" class="action-link action-link--edit" style="font-size:1rem;padding:12px 18px;">Mettre à niveau mon compte</button>
        </form>
    </section>
<?= $this->endSection() ?>
