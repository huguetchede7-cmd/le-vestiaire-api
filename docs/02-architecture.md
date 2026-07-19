# Architecture de l'application

## Vue d'ensemble

Le Vestiaire – Chez Hugues est une application composée de deux parties principales :

- Une application mobile développée avec Flutter pour les clients.
- Une API REST développée avec Laravel qui centralise toute la logique métier.

Les données sont stockées dans une base de données MariaDB.

## Architecture générale

```
        Application Flutter
                │
          HTTP / JSON
                │
        API REST Laravel
                │
        Eloquent ORM
                │
            MariaDB
```

## Description des composants

### Application Flutter

L'application mobile permet aux clients de :

- créer un compte ;
- se connecter ;
- consulter les produits ;
- rechercher un maillot ;
- personnaliser un maillot (flocage, badge, emballage) ;
- ajouter un produit au panier ;
- passer une commande ;
- suivre les commandes ;
- gérer les favoris.

### API Laravel

L'API REST est responsable de :

- l'authentification des utilisateurs ;
- la gestion des produits ;
- la gestion des commandes ;
- la gestion des paiements ;
- la gestion du stock ;
- l'application des codes promotionnels ;
- les notifications.

### Base de données MariaDB

La base de données stocke :

- les utilisateurs ;
- les produits ;
- les catégories ;
- les variantes ;
- les commandes ;
- les paiements ;
- les avis ;
- les favoris ;
- les notifications.

## Sécurité

L'API utilise l'authentification JWT afin de sécuriser les échanges entre l'application mobile et le serveur.