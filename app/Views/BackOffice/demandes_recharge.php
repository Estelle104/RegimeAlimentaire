<?= $this->extend('BackOffice/modele') ?>

<?= $this->section('content') ?>
    <section class="content-card">
        <div class="section-head">
            <div>
                <p class="backoffice-kicker">Recharges</p>
                <h1>Validation des codes de recharge</h1>
            </div>
        </div>

        <?php if(session()->getFlashdata('success')): ?>
            <p class="kpi-card small-muted" style="color:green;font-weight:700;"><?= session()->getFlashdata('success') ?></p>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <p class="kpi-card small-muted" style="color:red;font-weight:700;"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID Demande</th>
                    <th>Utilisateur</th>
                    <th>Valeur Code</th>
                    <th>Montant</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($demandes_en_attente)): ?>
                <?php foreach($demandes_en_attente as $demande): ?>
                    <tr>
                        <td><?= esc($demande['id']) ?></td>
                        <td><?= esc($demande['id_utilisateur']) ?></td>
                        <td><?= esc($demande['valeur_code']) ?></td>
                        <td><?= esc($demande['montant']) ?> Ariary</td>
                        <td>
                            <a class="action-link action-link--accept" href="<?= base_url('backoffice/recharges/valider/' . $demande['id']) ?>">Valider</a>
                            <a class="action-link action-link--delete" href="<?= base_url('backoffice/recharges/refuser/' . $demande['id']) ?>" style="margin-left:8px;">Refuser</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">Aucune demande en attente.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </section>

<?= $this->endSection() ?>
