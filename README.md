# Pokeshop 🛒

Projet web réalisé dans le cadre du cours de Technologies Internet 2.

## 💡 Description

Pokeshop est une boutique en ligne fictive de cartes Pokémon.  
Elle propose une interface publique pour consulter les produits et une interface d'administration sécurisée pour gérer les utilisateurs et les "displays".

## 🎯 Fonctionnalités principales

### Partie publique
- Consultation des produits disponibles
- Ajout au panier
- Paiement (simulé)
- Inscription / Connexion utilisateur

### Partie administration
- Authentification sécurisée
- Affichage des utilisateurs et des displays (produits)
- Interface protégée par session

## 🔐 Gestion des accès
- Utilisateurs : accès à la boutique et au panier
- Admins : accès à une interface de gestion (dashboard)

## 🧰 Technologies utilisées

- **PHP orienté objet**
- **PostgreSQL**
- **PL/pgSQL** pour les fonctions BD
- **HTML / CSS / Bootstrap**
- **JavaScript / jQuery**
- **Git + GitHub**
- Sitemap XML généré

## 🗃️ Base de données

- Fichier dump disponible : `pokeshop/pokeshopbd.sql`
- Contient les tables : users, admins, displays, etc.

## ⚙️ Architecture

- Architecture en plusieurs pages (`index.php`, `purchase.php`, etc.)
- DAO appliqué (aucune requête SQL dans les pages)
- Modèle MVC allégé

## 🔎 SEO

- Balises `<meta>` et attributs alternatifs présents
- Sitemap généré à `pokeshop/sitemap.xml`

## 📦 Installation

1. Cloner le projet :
   ```bash
   git clone https://github.com/Darliziax/Pokeshop.git
