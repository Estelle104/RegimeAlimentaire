const form = document.getElementById('connexionForm');
const email = document.getElementById('email');
const motDePasse = document.getElementById('mot_de_passe');

form.addEventListener('submit', function (event) {
    event.preventDefault();

    const data = {
        email: email.value,
        mot_de_passe: motDePasse.value
    };

    const xhr = new XMLHttpRequest();

    xhr.open('POST', form.action, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            let response;

            try {
                response = JSON.parse(xhr.responseText);
            } catch (error) {
                alert('Erreur serveur, reponse invalide.');
                return;
            }

            if (xhr.status === 200) {
                alert(response.message || 'Connexion reussie');
            } else {
                alert(response.message || 'Erreur de connexion');
            }
        }
    };

    xhr.send(JSON.stringify(data));
});
