-- Active: 1765826464238@@127.0.0.1@3306@mabagnole
drop DATABASE IF EXISTS MaBagnole;

CREATE DATABASE MaBagnole;

USE MaBagnole;

CREATE Table Utilisateurs (
    idUtilisateur int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nomUtilisateur varchar(255) NOT NULL,
    prenomUtilisateur varchar(255) NOT NULL,
    telephone varchar(255) UNIQUE,
    ville varchar(255),
    email varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    role ENUM('admin', 'client') DEFAULT 'client',
    statusClient INT NOT NULL DEFAULT 1,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Constraint check_statusClient check (statusClient between 0 and 1)
);

CREATe Table Categories (
    idCategorie int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    titreCategorie varchar(255) NOT NULL,
    descriptionCategorie varchar(255) NOT NULL
);

CREATE table Vehicules (
    idVehicule int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    marqueVehicule varchar(255) NOT NULL,
    modeleVehicule varchar(255) NOT NULL,
    anneeVehicule varchar(255) NOT NULL,
    imageVehicule varchar(255) NOT NULL,
    typeBoiteVehicule ENUM('manuelle', 'automatique'),
    typeCarburantVehicule ENUM(
        'essence',
        'diesel',
        'electrique',
        'hybride'
    ),
    statusVehicule INT NOT NULL DEFAULT 1,
    couleurVehicule varchar(255) NOT NULL,
    prixVehicule DECIMAL(10, 2) NOT NULL,
    idCategorie int(11) NOT NULL,
    Constraint check_statusVehicule check (
        statusVehicule between 0 and 1
    ),
    FOREIGN KEY (idCategorie) REFERENCES Categories (idCategorie)
);

CREATE table Reservations (
    idReservation int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    dateReservation DATETIME DEFAULT CURRENT_TIMESTAMP,
    dateDebutReservation DATETIME NOT NULL,
    dateFinReservation DATETIME NOT NULL,
    lieuChange varchar(255) NOT NULL,
    idVehicule int(11) NOT NULL,
    statusReservation ENUM(
        'confirmer',
        'en cours',
        'annuler'
    ) DEFAULT 'en cours',
    idClient int(11) NOT NULL,
    FOREIGN KEY (idVehicule) REFERENCES Vehicules (idVehicule),
    FOREIGN KEY (idClient) REFERENCES Utilisateurs (idUtilisateur)
);

CREATE table Option (
    idOption int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    titreOption varchar(255) NOT NULL,
    descriptionOption varchar(255) NOT NULL,
    prixOption DECIMAL NOT NULL
);

CREATE Table optionReservation (
    idReservation int(11) NOT NULL,
    idOption int(11) NOT NULL,
    PRIMARY KEY (idReservation, idOption),
    FOREIGN KEY (idReservation) REFERENCES Reservations (idReservation),
    FOREIGN KEY (idOption) REFERENCES Option (idOption)
);


CREATE table Avis (
    idAvis int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    commentaireAvis varchar(255) NOT NULL,
    noteAvis int(1) NOT NULL,
    datePublicationAvis TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    idReservation int(11) NOT NULL,
    statusAvis ENUM("0", "1") DEFAULT 1,
    idClient int(11) NOT NULL,
    constraint check_noteAvis check (noteAvis between 1 and 5),
    FOREIGN KEY (idReservation) REFERENCES Reservations (idReservation),
    FOREIGN KEY (idClient) REFERENCES Utilisateurs (idUtilisateur)
);

CREATE Table Favoris (
    idClient int(11) NOT NULL,
    idVehicule int(11) NOT NULL,
    PRIMARY KEY (idClient, idVehicule),
    FOREIGN KEY (idClient) REFERENCES Utilisateurs (idUtilisateur),
    FOREIGN KEY (idVehicule) REFERENCES Vehicules (idVehicule)
);

CREATE Table reagirAvis (
    idAvis int(11) NOT NULL,
    idClient int(11) NOT NULL,
    statusReagirAvis ENUM("0", "1") DEFAULT 1,
    PRIMARY KEY (idAvis, idClient),
    FOREIGN KEY (idAvis) REFERENCES Avis (idAvis),
    FOREIGN KEY (idClient) REFERENCES Utilisateurs (idUtilisateur)
);


DROP PROCEDURE IF EXISTS AjouterReservation;
DELIMITER //

CREATE PROCEDURE AjouterReservation(
    IN idClient INT,
    IN idVehicule INT,
    IN dateDebut DATETIME,
    IN dateFin DATETIME,
    IN lieuChange VARCHAR(255)
)
BEGIN
    IF dateDebut >= dateFin THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La date de début iinférieure la date de fin.';
    
    -- 2. Check  (statusVehicule = 1)
    ELSEIF (SELECT statusVehicule FROM Vehicules WHERE idVehicule = idVehicule LIMIT 1) = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = ' pas disponible.';
        
    ELSE
        -- 3. Insert  reservation
        INSERT INTO Reservations (
            dateDebutReservation, 
            dateFinReservation, 
            lieuChange, 
            idVehicule, 
            idClient
        ) 
        VALUES (
            dateDebut, 
            dateFin, 
            lieuChange, 
            idVehicule, 
            idClient
        );
    END IF;
END //
DELIMITER ;

DROP PROCEDURE if EXISTS confirmerReservation;

CREATE Procedure confirmerReservation(
    IN reservationId INT
)
BEGIN
    UPDATE Reservations
    SET statusReservation = 'confirmer'
    WHERE idReservation = reservationId;
    UPDATE vehicules
    SET statusVehicule = 0
    WHERE idVehicule = (SELECT idVehicule FROM Reservations WHERE idReservation = reservationId);
END;    
