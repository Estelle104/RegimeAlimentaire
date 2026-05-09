# Systeme de gestion de regime alimentaire

## Table 


BASE DE DONNÉES


users :
- id_utilisateur
- nom
- email
- mot_de_passe
- genre
- solde
- est_gold

details_sante :
- id
- id_utilisateur
- taille
- poids
- imc


objectifs :
- id
- libelle

objectifs_utilisateurs :
- id
- id_utilisateur
- id_objectif


categories_aliments :
- id
- libelle

aliments :
- id
- libelle
- id_categorie_aliment
- prix_par_calorie

apports :
- id
- libelle

apports_aliments :
- id
- id_aliment
- id_apport
- valeur_calorie


sports :
- id
- libelle


regimes :
- id
- libelle
- pourcentage_viande
- pourcentage_poisson
- pourcentage_volaille

details_regimes :
- id
- id_regime
- duree_jours
- prix
- variation_poids_kg


suggestions_programmes :
- id
- id_objectif
- id_regime
- id_sport
- duree


codes_recharge :
- id
- valeur_code
- montant
- statut

achats_regimes :
- id
- id_utilisateur
- id_regime
- prix_paye

types_abonnements :
- id
- libelle
- pourcentage_remise


## A faire
### Objectif
- Le client recoit un regime avec le delais de temps pour le faire et le prix du regime


### Front Office
- Inscription / Login
    - Separation en 2 form  1 perso , 1 sante
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