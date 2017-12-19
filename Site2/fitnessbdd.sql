CREATE DATABASE fitness CHARACTER SET 'utf8';

CREATE TABLE utilisateurs (
	id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	nom VARCHAR(40) NOT NULL,
	prenom VARCHAR(70) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	date_naissance DATE NOT NULL,
	tel CHAR(10) NOT NULL UNIQUE,
    sexe CHAR(1) NOT NULL,
    password VARCHAR(255) NOT NULL
)
ENGINE=INNODB;

CREATE TABLE programmes (
	id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	nom VARCHAR(255) NOT NULL,
	commentaire TEXT NOT NULL,
	date_creation DATETIME NOT NULL,
	id_utilisateur INT UNSIGNED NOT NULL,
	CONSTRAINT fk_id_utilisateur
		FOREIGN KEY (id_utilisateur)
		REFERENCES utilisateurs(id)
)
ENGINE=INNODB;
CREATE TABLE exercices (
	id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	nom VARCHAR(70) NOT NULL UNIQUE,
	description TEXT NOT NULL,
	courte_description TEXT NOT NULL,
	difficulte VARCHAR(20) NOT NULL
)
ENGINE=INNODB;

CREATE TABLE contient (
	id_programme INT UNSIGNED NOT NULL,
	id_exercice INT UNSIGNED NOT NULL,
	nbr_repetition INT UNSIGNED NOT NULL DEFAULT 1,
	CONSTRAINT fk_id_programme
		FOREIGN KEY (id_programme)
		REFERENCES programmes(id),
	CONSTRAINT fk_id_exercice
		FOREIGN KEY (id_exercice)
		REFERENCES exercices(id)
)
ENGINE=INNODB;

CREATE TABLE categories (
	id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
	muscle_cibler VARCHAR(100) NOT NULL UNIQUE
)
ENGINE=INNODB;

CREATE TABLE appartient (
	id_exercice INT UNSIGNED NOT NULL,
	id_categorie INT UNSIGNED NOT NULL,
	CONSTRAINT fk_id_exercice_app
		FOREIGN KEY (id_exercice)
		REFERENCES exercices(id),
	CONSTRAINT fk_id_categorie
		FOREIGN KEY (id_categorie)
		REFERENCES categories(id)
)
ENGINE=INNODB;

CREATE FULLTEXT INDEX ind_full_nom
ON exercices (nom);

CREATE VIEW programmes_utilisateur
AS SELECT utilisateurs.id AS no_utilisateur,
	programmes.id AS no_programme, 
	programmes.nom AS nom_programme,
	programmes.commentaire,
    exercices.id AS no_exercice,
	exercices.nom AS nom_exercice,
	contient.nbr_repetition
FROM utilisateurs
INNER JOIN programmes
	ON utilisateurs.id = programmes.id_utilisateur
LEFT JOIN contient
	ON programmes.id = contient.id_programme
LEFT JOIN exercices
	ON exercices.id = contient.id_exercice;


CREATE VIEW exercices_par_categorie
AS SELECT categories.id AS no_categorie,
	categories.muscle_cibler AS muscle,
	exercices.id AS no_exercice,
	exercices.nom AS nom_exercice, 
	exercices.difficulte
FROM categories
INNER JOIN appartient
	ON categories.id = appartient.id_categorie
INNER JOIN exercices
	ON appartient.id_exercice = exercices.id;

CREATE USER 'utilisateur'@'localhost' IDENTIFIED BY 'motdepasse';

GRANT SELECT 
ON fitness.*
TO 'utilisateur'@'localhost' IDENTIFIED BY 'motdepasse';

GRANT UPDATE(password)
ON fitness.utilisateurs
TO 'utilisateur'@'localhost' IDENTIFIED BY 'motdepasse';

GRANT INSERT
ON fitness.programmes
TO 'utilisateur'@'localhost' IDENTIFIED BY 'motdepasse';

GRANT INSERT
ON fitness.contient
TO 'utilisateur'@'localhost' IDENTIFIED BY 'motdepasse';

GRANT INSERT
ON fitness.utilisateurs
TO 'utilisateur'@'localhost' IDENTIFIED BY 'motdepasse';

GRANT DELETE 
ON fitness.contient
TO 'utilisateur'@'localhost' IDENTIFIED BY 'motdepasse';

GRANT DELETE 
ON fitness.programmes
TO 'utilisateur'@'localhost' IDENTIFIED BY 'motdepasse';

CREATE USER 'admin'@'localhost' IDENTIFIED BY 'securitemaximal';

GRANT SELECT, INSERT, UPDATE, DELETE
ON fitness.*
TO 'admin'@'localhost' IDENTIFIED BY 'securitemaximal';