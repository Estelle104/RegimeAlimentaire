<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>BackOffice</title>
	<link rel="stylesheet" href="<?= base_url('assets/backOffice/css/backoffice.css') ?>">
</head>
<body>
	<div class="backoffice-shell">
		<aside class="backoffice-sidebar">
			<div class="backoffice-brand">
				<p class="backoffice-kicker">BackOffice</p>
				<h1>Regime Alimentaire</h1>
				<p class="backoffice-subtitle"></p>
			</div>

			<nav class="backoffice-nav" aria-label="Navigation backoffice">
				<a href="<?= base_url('backoffice/dashboard') ?>">Dashboard</a>
				<a href="<?= base_url('backoffice/regimes') ?>">Liste des régimes</a>
				<a href="<?= base_url('backoffice/recharges') ?>">Demandes de recharge</a>
				<!-- <a href="<?= base_url('/') ?>">Retour au site</a> -->
			</nav>
		</aside>

		<div class="backoffice-content">
			<header class="backoffice-topbar">
				<div>
					<p class="backoffice-kicker">Espace d'administration</p>
					<h2>Tableau de bord</h2>
				</div>
			</header>

			<main class="backoffice-main">
				<?= $this->renderSection('content') ?>
			</main>
		</div>
	</div>
</body>
</html>
