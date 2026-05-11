const form = document.getElementById('adminConnexionForm');
const username = document.getElementById('username');
const password = document.getElementById('password');

form.addEventListener('submit', function (event) {
    event.preventDefault();

    const data = {
        username: username.value,
        password: password.value
    };

    const xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState !== 4) {
            return;
        }

        let response;
        try {
            response = JSON.parse(xhr.responseText);
        } catch (error) {
            alert('Erreur serveur, reponse invalide.');
            return;
        }

        if (xhr.status === 200) {
            alert(response.message || 'Connexion admin reussie');
            if (response.redirect) {
                window.location.href = response.redirect;
            }
            return;
        }

        alert(response.message || 'Identifiants invalides');
    };

    xhr.send(JSON.stringify(data));
});
