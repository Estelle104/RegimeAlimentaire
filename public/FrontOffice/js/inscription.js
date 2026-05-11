
const nom = document.getElementById('nom');
const email = document.getElementById('email');
const motDePasse = document.getElementById('mot_de_passe');
const genre = document.getElementById('genre');

const taille = document.getElementById('taille');
const poids = document.getElementById('poids');

nom.addEventListener('blur', validateNom);
email.addEventListener('blur', validateEmail);
motDePasse.addEventListener('blur', validateMotDePasse);
genre.addEventListener('blur', validateGenre);

taille.addEventListener('blur', validateTaille);
poids.addEventListener('blur', validatePoids);

function setError(input, errorId, message){

    input.classList.add('input-error');

    const errorEl = document.getElementById(errorId);
    errorEl.innerText = message;
    errorEl.classList.add('show');

}

function clearError(input, errorId){

    input.classList.remove('input-error');

    const errorEl = document.getElementById(errorId);
    errorEl.innerText = '';
    errorEl.classList.remove('show');

}

function validateNom(){

    if(nom.value.trim() === ''){

        setError(nom, 'nomError',
        'Nom obligatoire');

        return false;
    }

    clearError(nom, 'nomError');
    return true;

}

function validateEmail(){

    let regex =
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(email.value.trim() === ''){

        setError(email,
        'emailError',
        'Email obligatoire');

        return false;
    }

    if(!regex.test(email.value)){

        setError(email,
        'emailError',
        'Email invalide');

        return false;
    }

    clearError(email, 'emailError');

    return true;

}

function validateGenre(){

    if(genre.value === ''){

        setError(genre,
        'genreError',
        'Choisissez un genre');

        return false;
    }

    clearError(genre, 'genreError');

    return true;

}



function validateTaille(){

    if(taille.value <= 0){

        setError(taille,
        'tailleError',
        'Taille invalide');

        return false;
    }

    clearError(taille,
    'tailleError');

    return true;

}

function validatePoids(){

    if(poids.value <= 0){

        setError(poids,
        'poidsError',
        'Poids invalide');

        return false;
    }

    clearError(poids,
    'poidsError');

    return true;

}

function goToStep2(){

    let valid = true;

    if(!validateNom()) valid = false;
    if(!validateEmail()) valid = false;
    if(!validateMotDePasse()) valid = false;
    if(!validateGenre()) valid = false;

    if(!valid){
        return;
    }

    document.getElementById('step1')
    .classList.add('hidden');

    document.getElementById('step2')
    .classList.remove('hidden');

}

function register(){

    let valid = true;

    if(!validateTaille()) valid = false;
    if(!validatePoids()) valid = false;

    if(!valid){
        return;
    }

    let data = {

        nom: nom.value,
        email: email.value,
        mot_de_passe: motDePasse.value,
        genre: genre.value,
        taille: taille.value,
        poids: poids.value

    };

    let xhr = new XMLHttpRequest();

    xhr.open(
        "POST",
        "http://localhost:8080/frontoffice/inscription",
        true
    );

    xhr.setRequestHeader(
        "Content-Type",
        "application/json"
    );

    xhr.onreadystatechange = function(){

        if(xhr.readyState === 4){

            let response =
            JSON.parse(xhr.responseText);

            if(xhr.status === 200){

                alert(response.message);
                if (response.redirect) {
                    window.location.href = response.redirect;
                }

            }else{

                alert(response.message);

            }

        }

    };

    xhr.send(JSON.stringify(data));

}

function validateMotDePasse(){

    if(motDePasse.value.trim() === ''){

        setError(motDePasse,
        'motDePasseError',
        'Mot de passe obligatoire');

        return false;
    }

    if(motDePasse.value.length < 6){

        setError(motDePasse,
        'motDePasseError',
        'Minimum 6 caracteres');

        return false;
    }

    clearError(motDePasse, 'motDePasseError');

    return true;

}