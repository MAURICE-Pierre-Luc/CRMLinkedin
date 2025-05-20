# CRMLinkedin

CRMLinkedin est une application Symfony conçue pour automatiser la collecte et la gestion des contacts LinkedIn dans un CRM.

## Prérequis

Assurez-vous d'avoir les éléments suivants installés sur votre machine :

- **PHP 8.2** ou supérieur, avec les extensions suivantes activées : `Ctype`, `iconv`, `PCRE`, `Session`, `SimpleXML`, `Tokenizer`
- **Composer** pour la gestion des dépendances PHP
- **Symfony CLI** (facultatif mais recommandé)
- **PostgreSQL** ou un autre système de gestion de base de données compatible

## Installation

1. **Cloner le dépôt**

```bash
git clone https://github.com/MAURICE-Pierre-Luc/CRMLinkedin.git
cd CRMLinkedin
```
2. **Installer les dépendances**

```bash
composer install
```
3. **Configurer les variables d'environnement**

Copiez le fichier .env.exemple en .env et ajustez les paramètres selon votre environnement, notamment la connexion à la base de données.
```bash
cp .env.exemple .env
```

4. **Configurer la base de données**

Créez la base de données et appliquez les migrations :
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. **Lancer le serveur de développement**

Utilisez la CLI Symfony pour démarrer le serveur :

```bash
symfony server:start
```

6. **Accéder à l'application**

Ouvrez votre navigateur et rendez-vous sur : http://localhost:8000

Structure du projet :

bin/ : Scripts exécutables, notamment la console Symfony

config/ : Fichiers de configuration de l'application

migrations/ : Fichiers de migration de la base de données

public/ : Répertoire public accessible via le serveur web

src/ : Code source principal de l'application

templates/ : Fichiers de templates Twig pour les vues

front/ : Contenu front-end (à confirmer selon le projet)

.env : Fichier de configuration des variables d'environnement
