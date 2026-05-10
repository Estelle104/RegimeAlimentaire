<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Inscription</title>
<style>
.hidden{
    display:none;
}

.input-error{
    border:1px solid red;
}

.error{
    color:red;
    font-size:13px;
    margin-top:5px;
}

</style>


</head>
<body>

<div class="container">

    <!-- ETAPE 1 -->
    <div id="step1">

        <h2>Inscription - Étape 1</h2>

        <div class="input-group">
            <input type="text" id="nom" placeholder="Nom">
            <div class="error" id="nomError"></div>
        </div>

        <div class="input-group">
            <input type="email" id="email" placeholder="Email">
            <div class="error" id="emailError"></div>
        </div>

        <div class="input-group">
            <input type="password" id="mot_de_passe" placeholder="Mot de passe">
            <div class="error" id="motDePasseError"></div>
        </div>

        <div class="input-group">
            <select id="genre">
                <option value="">Genre</option>
                <option>Homme</option>
                <option>Femme</option>
            </select>
            <div class="error" id="genreError"></div>
        </div>
        <button onclick="goToStep2()">
            Suivant
        </button>

    </div>


    <!-- ETAPE 2 -->
    <div id="step2" class="hidden">

        <h2>Informations Santé</h2>

        <div class="input-group">
            <input type="number" id="taille"
            placeholder="Taille (cm)">
            <div class="error" id="tailleError"></div>
        </div>

        <div class="input-group">
            <input type="number" id="poids"
            placeholder="Poids (kg)">
            <div class="error" id="poidsError"></div>
        </div>

        <button onclick="register()">
            S'inscrire
        </button>

    </div>

</div>

<script src="<?= base_url('FrontOffice/js/inscription.js') ?>"></script>


</body>
</html>