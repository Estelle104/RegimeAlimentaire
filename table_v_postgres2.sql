CREATE TABLE demandes_recharge (
    id SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_code_recharge INT NOT NULL,
    est_valide INT DEFAULT 0,
    date_demande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES users(id_utilisateur),
    FOREIGN KEY (id_code_recharge) REFERENCES codes_recharge(id)
);

