<?= $this->extend('FrontOffice/modele') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('assets/frontOffice/css/profil.css') ?>">

<div class="profile-container">
    <!-- Header -->
    <div class="profile-header">
        <h1 class="profile-title">Mon Profil</h1>
        <p class="profile-subtitle">Gestion de votre compte et paramètres</p>
        <?php if(!empty($user['est_gold']) && ($user['est_gold'] === 't' || $user['est_gold'] == 1)): ?>
            <span class="gold-status active"><i class="fas fa-star"></i> Membre Gold</span>
        <?php else: ?>
            <span class="gold-status"><i class="fas fa-circle-check"></i> Compte Standard</span>
        <?php endif; ?>
    </div>

    <!-- Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div style="background: linear-gradient(135deg, #4caf50 0%, #45a049 100%); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);">
            ✓ <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div style="background: linear-gradient(135deg, #f44336 0%, #e53935 100%); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; box-shadow: 0 4px 12px rgba(244, 67, 54, 0.2);">
            ✕ <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('info')): ?>
        <div style="background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; box-shadow: 0 4px 12px rgba(33, 150, 243, 0.2);">
            ℹ <?= session()->getFlashdata('info') ?>
        </div>
    <?php endif; ?>

    <!-- Profile Cards -->
    <div class="profile-cards">
        <div class="profile-card">
            <div class="card-title"><span class="card-icon"><i class="fas fa-wallet"></i></span>Solde Actuel</div>
            <div class="card-value"><?= number_format((float) ($user['solde'] ?? 0), 0, ',', ' ') ?></div>
            <div style="color: var(--color-muted); font-size: 0.85rem; margin-top: 0.5rem;">Ariary</div>
        </div>
        <div class="profile-card">
            <div class="card-title"><span class="card-icon"><i class="fas fa-user"></i></span>Nom</div>
            <div class="card-value" style="font-size: 1.3rem;"><?= esc($user['nom'] ?? 'N/A') ?></div>
        </div>
        <div class="profile-card">
            <div class="card-title"><span class="card-icon"><i class="fas fa-envelope"></i></span>Email</div>
            <div class="card-value" style="font-size: 1rem; color: #555;"><?= esc($user['email'] ?? 'N/A') ?></div>
        </div>
    </div>

    <!-- Recharge Code Form -->
    <div class="form-section">
        <h3><i class="fas fa-credit-card"></i> Recharger mon porte-monnaie</h3>
        <form action="<?= base_url('frontoffice/recharge') ?>" method="post">
            <div class="form-group">
                <label for="code">Code de recharge</label>
                <input type="text" id="code" name="code" placeholder="Ex: CODE50A" required style="text-transform: uppercase;">
            </div>
            <div class="actions-section" style="margin-top: 1.5rem;">
                <button type="submit" class="btn-submit">Valider le code</button>
            </div>
            <p style="font-size: 0.85rem; color: var(--color-muted); margin-top: 1rem;">
                <strong>Codes de test disponibles :</strong> CODE10A, CODE50A, CODE100A, CODE200A
            </p>
        </form>
    </div>

    <!-- Gold Membership Form -->
    <div class="form-section gold-code-form">
        <h3><i class="fas fa-crown"></i> Devenir membre GOLD</h3>
        <?php if(empty($user['est_gold']) || ($user['est_gold'] !== 't' && $user['est_gold'] != 1)): ?>
            <p style="margin-bottom: 1rem; color: var(--color-text);">
                Profitez de <strong style="color: var(--color-gold-dark);">15% de réduction</strong> sur tous les régimes et accédez à des avantages exclusifs.
            </p>
            <p style="margin-bottom: 1.5rem; color: var(--color-muted); font-size: 0.95rem;">
                <strong>Tarif :</strong> 50 000 Ariary (une seule fois)
            </p>
            <form action="<?= base_url('frontoffice/devenir-gold') ?>" method="post">
                <div class="actions-section" style="margin: 0;">
                    <button type="submit" class="btn-submit">Upgrader mon compte</button>
                </div>
            </form>
        <?php else: ?>
            <div style="padding: 1.5rem; background: rgba(255, 215, 0, 0.1); border-radius: 8px; border-left: 4px solid var(--color-gold-dark);">
                <p style="margin: 0; color: var(--color-primary); font-weight: 600;">
                    <i class="fas fa-star"></i> Vous êtes membre GOLD !
                </p>
                <p style="margin: 0.5rem 0 0 0; color: var(--color-muted); font-size: 0.9rem;">
                    Vous bénéficiez d'une réduction de 15% sur tous les régimes.
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
