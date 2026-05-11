CREATE DATABASE gestion_regime;

\c gestion_regime;

CREATE TABLE users (
    id_utilisateur SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    genre VARCHAR(20) NOT NULL,
    solde DECIMAL(10,2) DEFAULT 0,
    est_gold BOOLEAN DEFAULT FALSE
);

CREATE TABLE adminUsers (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
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

CREATE TABLE demandes_recharge (
    id SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_code_recharge INT NOT NULL,
    est_valide INT DEFAULT 0,
    date_demande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES users(id_utilisateur),
    FOREIGN KEY (id_code_recharge) REFERENCES codes_recharge(id)
);
-- =========================
-- ADMIN USERS
-- =========================
INSERT INTO adminUsers (username, password) VALUES
('admin', 'admin123'),
('superadmin', 'super456'),
('manager', 'manager789'),
('root', 'rootpassword'),
('andry', 'securepass');

-- =========================
-- USERS
-- =========================
INSERT INTO users (nom, email, mot_de_passe, genre, solde, est_gold) VALUES
('Andry Rakoto', 'andry@gmail.com', 'pass123', 'Homme', 50000, TRUE),
('Sarah Ranaivo', 'sarah@gmail.com', 'pass123', 'Femme', 25000, FALSE),
('Jean Michel', 'jean@gmail.com', 'pass123', 'Homme', 10000, FALSE),
('Laura Smith', 'laura@gmail.com', 'pass123', 'Femme', 75000, TRUE),
('Kevin Paul', 'kevin@gmail.com', 'pass123', 'Homme', 30000, FALSE);

-- =========================
-- DETAILS SANTE
-- =========================
INSERT INTO details_sante (id_utilisateur, taille, poids, imc) VALUES
(1, 1.75, 82, 26.78),
(2, 1.65, 55, 20.20),
(3, 1.80, 95, 29.32),
(4, 1.70, 68, 23.53),
(5, 1.78, 72, 22.72);

-- =========================
-- OBJECTIFS
-- =========================
INSERT INTO objectifs (libelle) VALUES
('Perte de poids'),
('Prise de masse'),
('Maintien IMC ideal');

-- =========================
-- OBJECTIFS UTILISATEURS
-- =========================
INSERT INTO objectifs_utilisateurs (id_utilisateur, id_objectif) VALUES
(1, 1),
(2, 3),
(3, 1),
(4, 2),
(5, 3);

-- =========================
-- CATEGORIES ALIMENTS
-- =========================
INSERT INTO categories_aliments (libelle) VALUES
('Viande'),
('Poisson'),
('Volaille'),
('Legumes'),
('Fruits');

-- =========================
-- ALIMENTS
-- =========================
INSERT INTO aliments (libelle, id_categorie_aliment, prix_par_calorie) VALUES
('Boeuf grille', 1, 0.50),
('Saumon', 2, 0.75),
('Poulet roti', 3, 0.45),
('Brocoli', 4, 0.20),
('Banane', 5, 0.15);

-- =========================
-- APPORTS
-- =========================
INSERT INTO apports (libelle) VALUES
('Proteines'),
('Glucides'),
('Lipides'),
('Fibres');

-- =========================
-- APPORTS ALIMENTS
-- =========================
INSERT INTO apports_aliments (id_aliment, id_apport, valeur_calorie) VALUES
(1, 1, 250),
(2, 1, 220),
(3, 1, 200),
(4, 4, 50),
(5, 2, 120);

-- =========================
-- SPORTS
-- =========================
INSERT INTO sports (libelle) VALUES
('Course à pied'),
('Musculation'),
('Natation'),
('Cyclisme'),
('Football');

-- =========================
-- REGIMES
-- =========================
INSERT INTO regimes (libelle, pourcentage_viande, pourcentage_poisson, pourcentage_volaille) VALUES
('Régime équilibré', 30, 20, 20),
('Régime végétarien', 0, 0, 0),
('Régime riche en protéines', 50, 30, 20),
('Régime minceur', 20, 40, 20),
('Régime prise de masse', 60, 20, 20);

-- =========================
-- DETAILS REGIMES
-- =========================
INSERT INTO details_regimes (id_regime, duree_jours, prix, variation_poids_kg) VALUES
(1, 30, 120000, -1.50),
(2, 60, 100000, -2.00),
(3, 45, 180000, 3.50),
(4, 30, 150000, -4.00),
(5, 60, 200000, 5.00);

-- =========================
-- SUGGESTIONS PROGRAMMES
-- =========================
INSERT INTO suggestions_programmes (id_objectif, id_regime, id_sport, duree) VALUES
(1, 4, 1, 30),
(2, 5, 2, 60),
(3, 1, 3, 45);

-- =========================
-- CODES RECHARGE
-- =========================
INSERT INTO codes_recharge (valeur_code, montant, statut) VALUES
('CODE001', 10000, 0),
('CODE002', 20000, 0),
('CODE003', 30000, 0),
('CODE004', 40000, 0),
('CODE005', 50000, 0),
('CODE006', 60000, 0),
('CODE007', 70000, 0),
('CODE008', 80000, 0),
('CODE009', 90000, 0),
('CODE010', 100000, 0),
('CODE011', 110000, 0),
('CODE012', 120000, 0),
('CODE013', 130000, 0),
('CODE014', 140000, 0),
('CODE015', 150000, 0);

-- =========================
-- ACHATS REGIMES
-- =========================
INSERT INTO achats_regimes (id_utilisateur, id_regime, prix_paye) VALUES
(1, 4, 150000),
(2, 2, 100000),
(4, 5, 200000);

-- =========================
-- TYPES ABONNEMENTS
-- =========================
INSERT INTO types_abonnements (libelle, pourcentage_remise) VALUES
('Standard', 0),
('Gold', 10),
('Premium', 20);

-- =========================
-- DEMANDES RECHARGE
-- =========================
INSERT INTO demandes_recharge (id_utilisateur, id_code_recharge, est_valide) VALUES
(1, 1, 1),
(2, 3, 0),
(3, 5, 1),
(4, 7, 0),
(5, 10, 1);