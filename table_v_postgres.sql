CREATE TABLE users (
    id_utilisateur SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    genre VARCHAR(20) NOT NULL,
    solde DECIMAL(10,2) DEFAULT 0,
    est_gold BOOLEAN DEFAULT FALSE
);

CREATE TABLE details_sante (
    id SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    taille DECIMAL(5,2) NOT NULL,
    poids DECIMAL(5,2) NOT NULL,
    imc DECIMAL(5,2),
    FOREIGN KEY (id_utilisateur) REFERENCES users(id_utilisateur)
);

CREATE TABLE objectifs (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
);

CREATE TABLE objectifs_utilisateurs (
    id SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_objectif INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES users(id_utilisateur),
    FOREIGN KEY (id_objectif) REFERENCES objectifs(id)
);

CREATE TABLE categories_aliments (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
);

CREATE TABLE aliments (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    id_categorie_aliment INT NOT NULL,
    prix_par_calorie DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_categorie_aliment) REFERENCES categories_aliments(id)
);

CREATE TABLE apports (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
);

CREATE TABLE apports_aliments (
    id SERIAL PRIMARY KEY,
    id_aliment INT NOT NULL,
    id_apport INT NOT NULL,
    valeur_calorie DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_aliment) REFERENCES aliments(id),
    FOREIGN KEY (id_apport) REFERENCES apports(id)
);

CREATE TABLE sports (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
);

CREATE TABLE regimes (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    pourcentage_viande INT NOT NULL,
    pourcentage_poisson INT NOT NULL,
    pourcentage_volaille INT NOT NULL
);

CREATE TABLE details_regimes (
    id SERIAL PRIMARY KEY,
    id_regime INT NOT NULL,
    duree_jours INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    variation_poids_kg DECIMAL(5,2) NOT NULL,
    FOREIGN KEY (id_regime) REFERENCES regimes(id)
);

CREATE TABLE suggestions_programmes (
    id SERIAL PRIMARY KEY,
    id_objectif INT NOT NULL,
    id_regime INT NOT NULL,
    id_sport INT NOT NULL,
    duree INT NOT NULL,
    FOREIGN KEY (id_objectif) REFERENCES objectifs(id),
    FOREIGN KEY (id_regime) REFERENCES regimes(id),
    FOREIGN KEY (id_sport) REFERENCES sports(id)
);

CREATE TABLE codes_recharge (
    id SERIAL PRIMARY KEY,
    valeur_code VARCHAR(50) NOT NULL UNIQUE,
    montant DECIMAL(10,2) NOT NULL,
    statut INT DEFAULT 0
);

CREATE TABLE achats_regimes (
    id SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_regime INT NOT NULL,
    prix_paye DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES users(id_utilisateur),
    FOREIGN KEY (id_regime) REFERENCES regimes(id)
);

CREATE TABLE types_abonnements (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    pourcentage_remise DECIMAL(5,2) NOT NULL
);