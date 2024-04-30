CREATE DATABASE IF NOT EXISTS traduction;

USE traduction;

CREATE TABLE vocabulaire (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    mot_fr TEXT NOT NULL,
    mot_en TEXT NOT NULL,
    note TEXT,
    modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)

INSERT INTO vocabulaire (id,mot_fr,mot_en,note,CURRENT_TIMESTAMP) VALUES
("pharisiens", "pharisees"),
("juifs","Jews"),
("Flavius Josèphe","Flavius Josephus"),
("Gethsémané","Gethsemane")

