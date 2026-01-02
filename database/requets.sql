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
    commmentaireAvis varchar(255) NOT NULL,
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

--insert admin
insert into
    Utilisateurs (
        nomUtilisateur,
        prenomUtilisateur,
        email,
        password,
        role
    )
values (
        'admin',
        'admin',
        'admin@admin.com',
        '$2y$10$NjdjKf8cL4qvDtjE4ApGF.lq742z0QDrdJyWxn5.fRJaVFGWJgtYS',
        'admin'
    );

--inser client 3
INSERT INTO
    utilisateurs (
        nomUtilisateur,
        prenomUtilisateur,
        email,
        password
    )
VALUES (
        'client',
        'client',
        'client@client.com',
        '$2y$10$NjdjKf8cL4qvDtjE4ApGF.lq742z0QDrdJyWxn5.fRJaVFGWJgtYS'
    );

INSERT INTO
    utilisateurs (
        nomUtilisateur,
        prenomUtilisateur,
        email,
        password
    )
VALUES (
        'client',
        'client',
        'client1@client.com',
        '$2y$10$NjdjKf8cL4qvDtjE4ApGF.lq742z0QDrdJyWxn5.fRJaVFGWJgtYS'
    );

insert into
    Utilisateurs (
        nomUtilisateur,
        prenomUtilisateur,
        email,
        password
    )
values (
        'client',
        'client',
        'client2@client.com',
        '$2y$10$NjdjKf8cL4qvDtjE4ApGF.lq742z0QDrdJyWxn5.fRJaVFGWJgtYS'
    );
--insert categorie
insert into
    Categories (
        titreCategorie,
        descriptionCategorie
    )
values (
        'Voiture',
        'Voiture de tourisme'
    );

insert into
    Categories (
        titreCategorie,
        descriptionCategorie
    )
values ('Moto', 'Moto de tourisme');

insert into
    Categories (
        titreCategorie,
        descriptionCategorie
    )
values (
        'Camion',
        'Camion de tourisme'
    );

--insert int vehicule 4

insert INTO
    vehicules (
        idCategorie,
        marqueVehicule,
        modeleVehicule,
        anneeVehicule,
        imageVehicule,
        typeBoiteVehicule,
        typeCarburantVehicule,
        couleurVehicule,
        prixVehicule
    )
VALUES (
        1,
        'Mercedes',
        'C63',
        2019,
        'https://images.unsplash.com/photo-1503376780353-7e6692767b70',
        'Moteur 6 cylindres',
        'Essence',
        'Noir',
        100000
    );

--insert reservation
insert into
    Reservations (
        dateDebutReservation,
        dateFinReservation,
        lieuChange,
        idVehicule,
        idClient
    )
values (now(), now(), 'Lieu', 1, 2);

INSERT INTO
    `reservations` (
        `dateDebutReservation`,
        `dateFinReservation`,
        `lieuChange`,
        `idVehicule`,
        `idClient`
    )
VALUES (
        '2026-01-01 10:00:00',
        '2026-01-05 12:00:00',
        'Lieu',
        1,
        1
    );
-- inser reservation confirmed
insert into
    Reservations (
        dateDebutReservation,
        dateFinReservation,
        lieuChange,
        idVehicule,
        idClient,
        statusReservation
    )
values (
        now(),
        '2026-01-05 12:00:00',
        'Lieu',
        1,
        2,
        'confirmer'
    );
--insert option

insert into
    Option (
        titreOption,
        descriptionOption,
        prixOption
    )
values (
        'Option 1',
        'Description option 1',
        1000
    );

insert into
    Option (
        titreOption,
        descriptionOption,
        prixOption
    )
values (
        'Option 2',
        'Description option 2',
        2000
    );

insert into
    Option (
        titreOption,
        descriptionOption,
        prixOption
    )
values (
        'Option 3',
        'Description option 3',
        3000
    );

--insert int avis
insert into
    Avis (
        commmentaireAvis,
        noteAvis,
        idReservation,
        idClient
    )
values ('super', 5, 1, 2);

SELECT * from vehicules