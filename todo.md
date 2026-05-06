# Systeme de gestion de regime alimentaire

## Table 

user

    id
    nom
    email
    genre
    taille
    poids


objectif

    id
    libele


categorie_aliment

    id
    libele


aliment

    id
    libele
    id_cat_aliment


apport

    id
    libele


apport_aliment

    id
    id_aliment
    id_apport
    calorie


sport

    id
    libele


regime

    id
    id_aliment