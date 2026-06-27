# E-Class - Application Web de Gestion des Classes en Ligne

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

Une application web dédiée à la gestion de classes en ligne permettant aux enseignants de gérer leurs cours et aux étudiants d'accéder aux ressources pédagogiques. 

Développé dans le cadre du module Programmation Web 2 à la Faculté des Sciences d'El Jadida (Université Chouaib Doukkali) pour l'année universitaire 2025-2026.

## À Propos du Projet

L'intégration des outils numériques dans l'enseignement nécessite un prolongement pour le partage de ressources et la communication. La gestion classique d'un cours par e-mail ou réseaux sociaux pose des problèmes de dispersion des supports et de manque de centralisation.

Cette application propose une plateforme web centralisée permettant de dématérialiser les échanges pédagogiques de manière légère et ergonomique, contrairement aux solutions lourdes existantes.

## Architecture & Choix Techniques

Ce projet a intégré une phase complète de génie logiciel pour structurer l'architecture avant le développement :

*   **Architecture Serveur :** Utilisation de PHP pour la flexibilité, l'interaction avec la base de données, le traitement des formulaires et la gestion sécurisée des sessions utilisateurs.
*   **Base de Données Relationnelle (MySQL) :** Conception stricte utilisant des clés primaires et étrangères pour garantir l'intégrité référentielle. La base gère des relations complexes de type "Un à Plusieurs" et "Plusieurs à Plusieurs" via des tables d'association.
*   **Modélisation UML :** Analyse préalable incluant la création de diagrammes de cas d'utilisation et de classes via Astah UML pour assurer la cohérence et la fiabilité du système.

## Fonctionnalités Principales

### Espace Professeur
*   **Gestion des Classes :** Création de classes virtuelles.
*   **Administration :** Suivi des demandes d'inscription avec la possibilité de les accepter ou de les refuser de manière centralisée.
*   **Ressources Pédagogiques :** Téléversement de fichiers (ex: PDF) pour mettre le contenu des cours en ligne et le rendre immédiatement accessible.
*   **Communication :** Publication d'annonces à destination des étudiants pour informer sur les examens ou les événements liés aux modules.
*   **Évaluations :** Création et attribution de devoirs en précisant une date limite de soumission et une description détaillée.
*   **Interactions & Profil :** Consultation et réponse aux questions posées par les étudiants. Gestion du compte personnel, avec la possibilité de retirer un étudiant d'une classe.

### Espace Étudiant
*   **Accès aux Cours :** Recherche et inscription aux classes existantes via un code fourni par l'enseignant.
*   **Ressources & Devoirs :** Consultation et téléchargement des supports de cours mis en ligne, ainsi que l'accès détaillé aux devoirs à rendre.
*   **Suivi Pédagogique :** Consultation chronologique de toutes les annonces publiées par les enseignants pour rester informé en temps réel.
*   **Questions / Réponses :** Envoi de questions directes aux professeurs et suivi des réponses fournies.
*   **Gestion de Profil :** Possibilité de se désinscrire d'un cours ou de supprimer son compte.

## Environnement de Développement

*   **Langages Back-end :** PHP et requêtes SQL.
*   **Langages Front-end :** Structure HTML5, mise en forme CSS3, et intégration de JavaScript.
*   **Serveur Local & SGBD :** Environnement XAMPP incluant Apache et MySQL (MariaDB).
*   **Outils :** IDE PhpStorm (édition de code) et logiciel Astah UML (conception).

## Installation & Déploiement

1. Installez l'environnement de développement XAMPP.
2. Clonez ce dépôt dans le répertoire `htdocs` de votre installation XAMPP.
3. Démarrez les services Apache et MySQL via le panneau de contrôle.
4. Importez la base de données relationnelle MySQL (fichier `.sql` fourni) dans votre environnement local.
5. Accédez à l'application via votre navigateur Web à l'adresse `http://localhost/nom-du-dossier`.

## Licence

**All Rights Reserved.**
Le code source de ce projet est partagé publiquement uniquement à des fins de consultation et de portfolio. Toute reproduction, modification ou distribution non autorisée est strictement interdite.

---
*Réalisé par MOHAMMED ATIR.*
