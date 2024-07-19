CREATE DATABASE IF NOT EXISTS traduction;

USE traduction;

CREATE TABLE vocabulaire (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    mot_fr TEXT NOT NULL DEFAULT (''),
    mot_en TEXT NOT NULL,
    glossary TEXT NOT NULL,
    note TEXT NULL,
    modified TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- INSERT INTO vocabulaire (mot_fr,mot_en,note,glossary) VALUES
-- ("pharisiens","pharisees","essai", "biblica key terms"),
-- ("juifs","Jews","essai", "biblica key terms"),
-- ("Flavius Josèphe","Flavius Josephus","essai", "biblica key terms"),
-- ("Gethsémané","Gethsemane","essai", "biblica key terms");

CREATE TABLE log_words (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    user TEXT NOT NULL,
    classe TEXT NOT NULL,
    glossary TEXT NOT NULL,
    mot_en TEXT NOT NULL, 
    mot_fr TEXT NOT NULL,
    note TEXT NULL,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_approved TEXT NULL
);

-- INSERT INTO log_words (user, classe, glossary,mot_en, mot_fr, note, is_approved) VALUES
-- ("Emma", "ajouter", "biblica key terms" , "sun", "soleil", "", "");

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rights ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE glossNames (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_id VARCHAR(255) NOT NULL,
    real_name VARCHAR(255) NOT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO glossNames (name_id, real_name) VALUES ("","");
INSERT INTO glossNames (name_id, real_name) VALUES
("biblica key terms", "Biblica Key Terms"),
("glossaire unfoldingword", "Glossaire unfoldingWord"),
("nom propres", "Noms propres traduction ressources"),
("repetitives uw","Phrases répétitives uW TNotes");
("anglicismes","Anglicismes à ne pas faire");


LOAD DATA INFILE 'biblica_key_terms.csv' INTO TABLE vocabulaire FIELDS TERMINATED BY '\t' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\n' (mot_en, mot_fr, glossary);

LOAD DATA INFILE 'uw.csv' INTO TABLE vocabulaire FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\n' (mot_en, mot_fr, glossary);

LOAD DATA INFILE 'nom_propres.csv' INTO TABLE vocabulaire FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\n' (mot_en, mot_fr, note,glossary);
LOAD DATA INFILE 'anglicismes.csv' INTO TABLE vocabulaire FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\n' (mot_en, mot_fr, note,glossary);

repetitives uw :
INSERT INTO vocabulaire (mot_en,mot_fr,note,glossary) VALUES ("See:","Voir :","","repetitives uw");
INSERT INTO vocabulaire (mot_en,mot_fr,note,glossary) VALUES ("Alternate translation:","Traduction alternative :","Toujours laisser au singulier, même lorsque plusieurs traductions alternatives sont proposées (car ces propositions sont exclusives).","repetitives uw");
INSERT INTO vocabulaire (mot_en,mot_fr,note,glossary) VALUES ("If it would be helpful in your language, you could use an equivalent expression from your language or state the meaning plainly.","Si c’est utile dans votre langue, vous pouvez utiliser une expression équivalente dans votre langue, ou formuler la chose de façon explicite.","","repetitives uw");
INSERT INTO vocabulaire (mot_en,mot_fr,note,glossary) VALUES ("If it would be helpful in your language, you could [...]", "Si c'est utile dans votre langue, vous pouvez", "C'est un début de phrase habituel dans les uW TNotes. Il y a plusieurs variantes possibles pour la suite de la phrase. En tout cas, ne pas conserver de formes conditionnelles « si c'était... vous pourriez... ».", "repetitives uw");