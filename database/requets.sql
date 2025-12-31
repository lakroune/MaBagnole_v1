-- Active: 1765826464238@@127.0.0.1@3306@mabagnole
drop DATABASE IF EXISTS MaBagnole;
CREATE DATABASE MaBagnole;
USE MaBagnole;

CREATE Table Utilisateurs (
    idUtilisateur int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nomUtilisateur varchar(255) NOT NULL,
    prenomUtilisateur varchar(255) NOT NULL,
    telephone varchar(255),
    ville varchar(255),
    email varchar(255) NOT NULL,
    paword varchar(255) NOT NULL,
    role ENUM('admin', 'client') DEFAULT 'client',
    statusUtilisateur ENUM('0', '1') DEFAULT 1,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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
    couleurVehicule varchar(255) NOT NULL,
    prixVehicule varchar(255) NOT NULL,
    idCategorie int(11) NOT NULL,
    FOREIGN KEY (idCategorie) REFERENCES Categories (idCategorie)
);

CREATE table Reservations (
    idReservation int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    dateDebutReservation date NOT NULL,
    dateFinReservation date NOT NULL,
    lieuChange varchar(255) NOT NULL,
    idVehicule int(11) NOT NULL,
    statusReservation ENUM(
        'en cours',
        'terminee',
        'annulee'
    ),
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
    commmentaireAvis varchar(255) NOT NULL,
    noteAvis int(11) NOT NULL,
    datePublicationAvis TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    idReservation int(11) NOT NULL,
    statusAvis ENUM("0", "1") DEFAULT 1,
    idClient int(11) NOT NULL,
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