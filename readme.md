# Create README.md file with the prepared content

content = """# 🚗 MaBagnole – Plateforme de Location de Véhicules & Blog Auto

**MaBagnole** est une solution web complète conçue pour une agence de location de voitures.  
Elle permet aux clients de réserver des véhicules en ligne et d’interagir avec la plateforme via des fonctionnalités modernes.  
Le projet est développé en **PHP orienté objet (POO)** avec une architecture **SQL robuste**.

---

## 🛠️ Stack Technique

### Backend
- PHP 8.x (Programmation Orientée Objet)

### Base de données
- MySQL (Vues, Procédures stockées, Triggers)

### Frontend
- HTML5  
- CSS3  
- JavaScript (AJAX – filtres sans rechargement)

### Outils & Librairies
- Composer (gestion des dépendances & autoload)
- DataTables (pagination et recherche dynamique)

### Conception
- UML (diagrammes de classes & cas d’utilisation)

---

## 🚀 Fonctionnalités Principales

### 👤 Espace Client
- Réservation intelligente avec sélection de dates
- Recherche & filtres dynamiques par catégorie et modèle (AJAX)
- Avis et notations sur les véhicules loués (Soft Delete)
- Favoris pour sauvegarder des véhicules

### 👨‍💼 Espace Administrateur (Dashboard)
- Gestion complète des véhicules, catégories, réservations et clients
- Statistiques sur les véhicules les plus réservés
- Optimisation avec insertion en masse (Bulk Insert)

---

## 🏗️ Architecture de la Base de Données

- Vue SQL `ListeVehicules` : regroupe véhicules, catégories et moyenne des notes
- Procédure stockée `AjouterReservation` : vérifie la disponibilité avant insertion

---

## 📁 Structure du Projet

MaBagnole/
├── app/
│   ├── Models/
│   ├── Controllers/
│   └── Views/
├── vendor/
├── conception/
├── composer.json
└── database/

---

## ⚙️ Installation

### 1. Cloner le dépôt
git clone https://github.com/lakrouen/mabagnole_v1.git

### 2. Installer les dépendances
composer install  
composer dump-autoload

### 3. Lancer le projet
Utilisez XAMPP, Laragon ou le serveur PHP intégré.

---

## 📊 Conception UML

Architecture UML claire assurant maintenabilité et extensibilité.

---

© 2026 MaBagnole – Projet de module PHP POO
"""

