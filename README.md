# DDD sans douleur avec API Platform
# Painless DDD with API Platform

Ce projet est une démonstration des concepts présentés lors du meetup AFUP Montpellier du 19 novembre 2024 sur le thème "DDD sans douleur : Optimiser les coûts d'une architecture complexe avec API Platform".

This project is a demonstration of concepts presented during the AFUP Montpellier meetup on November 19, 2024, on "Painless DDD: Optimizing costs of complex architecture with API Platform".

[Lien vers la présentation / Link to presentation](https://github.com/mdavid-dev/afup-montpellier-ddd/tree/main/presentation)

## À propos / About

Ce projet est basé sur [API Platform 3.3.7](https://github.com/api-platform/api-platform/releases/tag/v3.3.7) et intègre le Maker Bundle DDD, un outil permettant de générer rapidement du code suivant les principes du Domain-Driven Design.

This project is based on [API Platform 3.3.7](https://github.com/api-platform/api-platform/releases/tag/v3.3.7) and includes the Maker Bundle DDD, a tool for quickly generating code following Domain-Driven Design principles.

### Fonctionnalités principales / Main features

- Maker Bundle DDD pour la génération de code
- Infrastructure de tests optimisée
- Exemples concrets de patterns DDD :
    - Value Objects
    - Aggregates
    - Communication Infrastructure/Application via CQRS
    - Provider/Processor pattern

- DDD Maker Bundle for code generation
- Optimized test infrastructure
- Concrete examples of DDD patterns:
    - Value Objects
    - Aggregates
    - Infrastructure/Application communication through CQRS
    - Provider/Processor pattern

## Installation

```bash
# Construire les images Docker / Build Docker images
docker compose build --no-cache

# Lancer les containers / Start containers
docker compose up -d
```

## Utilisation / Usage

### Maker Bundle DDD

Pour voir la liste des commandes disponibles :
To see available commands:

```bash
docker compose exec php bin/console make:ddd
```

### API Documentation

La documentation Swagger est accessible à :
Swagger documentation is available at:
https://localhost/docs#/

### Tests

Pour lancer les tests avec PHPUnit :
To run PHPUnit tests:

```bash
docker compose exec php bin/phpunit --testdox
```

## Architecture

Le projet démontre une architecture DDD complète avec :
The project demonstrates a complete DDD architecture with:

- Séparation claire des couches (Domain, Application, Infrastructure)
- Implementation de CQRS
- Utilisation de Value Objects et d'Aggregates
- Infrastructure de tests complète

- Clear layer separation (Domain, Application, Infrastructure)
- CQRS implementation
- Value Objects and Aggregates usage
- Complete test infrastructure