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


objectif_user

    id
    id_user
    id_objectif


categorie_aliment

    id
    libele


aliment

    id
    libele
    id_cat_aliment
    prix_par_calorie


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
    id_duree
    prix


type_abonnement

    id
    libele
    pourcentage_remise


## A faire
### Objectif
- Le client recoit un regime avec le delais de temps pour le faire et le prix du regime


### Front Office
- Inscription / Login
    - Separation en 2 form = 1 perso , 1 sante
- Profil de l'user
- Choix d'objectif
- Suggestion de regime et sa duree selon le choix et profil user
    - a exporter en pdf
- Ajouter un code
    - 
- Choix mode de paiement
    - Gold (-15%)
        - a acheter une fois pour tout le regime
        - mode d'acces  
    - Non


### Back Office
- Authentification
- Dashboard, Statistiques
- CRUD regime
    - liste avec update et delete
    - create
    - prix en fonction de la duree
    - poids varie en focntion de la duree
- CRUD des activites sportives 
    - liste avec update et delete
    - create
- Validation des codes
    - Il y a une notification de demande de code
        -> Il faut accepter et le lui donner 
- CRUD des parametres 