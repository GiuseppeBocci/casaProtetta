CREATE DATABASE casap;

USE casap;

CREATE TABLE utenti (
idutente INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(30) NOT NULL,
cognome VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL,
password VARCHAR(255) NOT NULL,
motivazione VARCHAR(255) NOT NULL,
maxcert INT(2) UNSIGNED DEFAULT 2, /*numero certificati massimi generabili per l'utente*/
attivo BOOLEAN DEFAULT false NOT NULL
);

CREATE TABLE utentivpn (
idutentevpn INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
utentevpn VARCHAR(30) NOT NULL,
idutente INT(6) UNSIGNED,
nome VARCHAR(30) NOT NULL,
CONSTRAINT FK_1 FOREIGN KEY (idutente) REFERENCES utenti(idutente)
);

CREATE TABLE cams (
idcam INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
ip VARCHAR(15) NOT NULL,
nome VARCHAR(30) NOT NULL
);

/*Inserire i propri dati qui*/
INSERT INTO utenti (nome, cognome, email, password, motivazione, maxcert, attivo)
VALUES ("Giuseppe", "Bocci", "peppebocci13@gmail.com", "*****", "", 10, true);
/*Default vpn account*/
INSERT INTO utentivpn (utentevpn, idutente, nome)
VALUES ("admin", 1, "mycert");
