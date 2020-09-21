-- als database project1 bestaat drop (delete)
--  Aanmaken van de database project1
CREATE DATABASE IF NOT EXSISTS project1;
-- USE houd in dat de volgende statements gebruikt gaan worden in deze database (project1)
USE project1;
-- Tabel account aanmaken met primary key ID die tabel persoon gaat gebruiken om het account aan de persoon te  koppelen
CREATE TABLE Account(

    id INT NOT NULL AUTO_INCREMENT,
    email NOT NULL VARCHAR(255) UNIQUE,
    password NOT NULL VARCHAR(255),
    PRIMARY KEY(id)
);
-- Tabel persoon aanmaken waar de foreign key op account id zit zodat account aan persoon gekoppeld wordt
CREATE TABLE Persoon(

    id INT NOT NULL AUTO_INCREMENT,
    username NOT NULL VARCHAR(255),
    voornaam NOT NULL VARCHAR(255),
    tussenvoegsel VARCHAR(255),
    achternaam NOT NULL VARCHAR(255),
    PRIMARY KEY(id),
	FOREIGN KEY(id) REFERENCES Account(id)
);