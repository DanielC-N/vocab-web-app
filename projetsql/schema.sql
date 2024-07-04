CREATE DATABASE IF NOT EXISTS traduction;

USE traduction;

CREATE TABLE vocabulaire (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    mot_fr TEXT NOT NULL,
    mot_en TEXT NOT NULL,
    category TEXT NOT NULL,
    note TEXT NULL,
    modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO vocabulaire (mot_fr,mot_en,note) VALUES
("pharisiens","pharisees","essai"),
("juifs","Jews","essai"),
("Flavius Josèphe","Flavius Josephus","essai"),
("Gethsémané","Gethsemane","essai");

CREATE TABLE log_words (

    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    user TEXT NOT NULL,
    classe TEXT NOT NULL,
    mot_en TEXT NOT NULL, 
    mot_fr TEXT NOT NULL,
    note TEXT NULL,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_approved TEXT NULL
);

INSERT INTO log_words (user, classe, mot_en, mot_fr, note, is_approved) VALUES
("Emma", "ajouter", "sun", "soleil", "", "");
