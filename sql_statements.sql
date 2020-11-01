/* als database project1 bestaat drop (delete)
  Aanmaken van de database project1 */
CREATE DATABASE IF NOT EXISTS project1;
-- USE houd in dat de volgende statements gebruikt gaan worden in deze database (project1)
USE project1;
-- Tabel account aanmaken met primary key ID die tabel persoon gaat gebruiken om het account aan de persoon te  koppelen
CREATE TABLE Account(

    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
-- Tabel persoon aanmaken waar de foreign key op account id zit zodat account aan persoon gekoppeld wordt
CREATE TABLE Persoon(

    id INT NOT NULL AUTO_INCREMENT,
    username  VARCHAR(255) NOT NULL,
    voornaam  VARCHAR(255) NOT NULL,
    tussenvoegsel VARCHAR(255),
    achternaam  VARCHAR(255) NOT NULL,
    account_id VARCHAR(255),
    PRIMARY KEY(id),
	FOREIGN KEY(account_id) REFERENCES Account(id)
);
/* inset admin user in account table.*/
INSERT INTO Account (email, password)
VALUES ("2095333@talnet.nl","test123" );

INSERT INTO Persoon (username, voornaam, tussenvoegsel, achternaam)
VALUES ("admin123", "admin", "van", "naamvanachter" );

/**/
ALTER TABLE Persoon
ADD account_id VARCHAR(255) NOT NULL AFTER id;

ALTER TABLE Persoon
ADD FOREIGN KEY (id) REFERENCES Account(id);

ALTER TABLE Persoon 
ADD account_id INT NOT NULL AFTER id, 
ADD FOREIGN KEY (account_id) REFERENCES account(id)


--  fix met nilu voor foreign key issue
ALTER TABLE `project1`.`persoon` ;
DROP FOREIGN KEY `persoon_ibfk_2`,
DROP FOREIGN KEY `persoon_ibfk_1`;
ALTER TABLE `project1`.`persoon` ;



-- deleten van rows in persoon en account voor overzicht
DELETE FROM `persoon` WHERE account_id > 6;
DELETE FROM `account` WHERE id > 3;



-- 06-10-2020
-- deleten van username column zodat hij bij account table kan
ALTER TABLE persoon DROP IF EXISTS username;
ALTER TABLE persoon 
--  add usertype table
CREATE TABLE usertype (

id INT NOT NULL AUTO_INCREMENT,
type VARCHAR(255) UNIQUE,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id)
)

ALTER TABLE persoon
ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP;
ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE account
ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP;
ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP

ALTER TABLE account
ADD username VARCHAR(255) NOT NULL UNIQUE,
ADD type INT NOT NULL,
ADD FOREIGN KEY (type) REFERENCES usertype(id);



-- SQL script wat zonder poes of pas werkt, hierboven had aanpassingen nodig om het werkend te krijgen.
-- db deleten als hij bestaat
-- DROP DATABASE IF EXISTS project1;
-- -- create new db
-- CREATE DATABASE project1;

-- -- default db
-- USE project1;

-- CREATE TABLE usertype(
--     id INT NOT NULL AUTO_INCREMENT,
--     type VARCHAR(255),
--     created_at DATETIME NOT NULL,
--     updated_at DATETIME NOT NULL,
--     PRIMARY KEY(id)
-- );

-- -- create table account
-- CREATE TABLE account(
--     id INT NOT NULL AUTO_INCREMENT,
--     type INT NOT NULL,
--     username VARCHAR(250) UNIQUE,
--     email VARCHAR(250) UNIQUE NOT NULL,
--     password VARCHAR(250) NOT NULL,
--     created_at DATETIME NOT NULL,
--     updated_at DATETIME NOT NULL,
--     PRIMARY KEY(id),
--     FOREIGN KEY(type) REFERENCES usertype(id)
-- );

-- create table persoon
-- CREATE TABLE persoon(
--     id INT NOT NULL AUTO_INCREMENT,
--     account_id INT NOT NULL,
--     voornaam VARCHAR(250) NOT NULL,
--     tussenvoegsel VARCHAR(250),
--     achternaam VARCHAR(250) NOT NULL,
--     created_at DATETIME NOT NULL,
--     updated_at DATETIME NOT NULL,
--     PRIMARY KEY(id),
--     FOREIGN KEY(account_id) REFERENCES account(id)
-- );

-- admin en user 'roles' toevoegen zodat we laten onderscheid kunnen maken. 
-- INSERT INTO usertype VALUES (NULL, 'admin', now(), now()), (NULL, 'user', now(), now());

