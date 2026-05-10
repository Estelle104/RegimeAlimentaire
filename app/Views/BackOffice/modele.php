<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>BackOffice</title>
</head>
<body>
	<header>
		<h1>BackOffice</h1>

		<nav>
			<form action="<?= base_url('/') ?>" method="get">
				<button type="submit">Accueil</button>
			</form>

			<form action="<?= base_url('backoffice/regimes') ?>" method="get">
				<button type="submit">Liste des regimes</button>
			</form>

            <form action="<?= base_url('backoffice/dashboard') ?>" method="get">
                <button type="submit">Dashboard</button>
            </form>
		</nav>
		<hr>
	</header>

	<main>
		<?= $this->renderSection('content') ?>
	</main>
</body>
</html>
