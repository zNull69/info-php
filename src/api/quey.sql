CREATE TABLE IF NOT EXISTS utenti (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        cognome VARCHAR(50) NOT NULL,
        data_registrazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP)

INSERT INTO utenti (nome, cognome) VALUES ('Francesco', 'Tenerelli');
INSERT INTO utenti (nome, cognome) VALUES ('Luigi', 'Lattanzio');
INSERT INTO utenti (nome, cognome) VALUES ('Luca', 'Coppolecchia');
INSERT INTO utenti (nome, cognome) VALUES ('Raffaele', 'Auriole');
INSERT INTO utenti (nome, cognome) VALUES ('Giovanni', 'Ficarella');
