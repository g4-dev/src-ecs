# Ecoservice

## [Lire la documentation !](docs/0Sommaire.md)

### Sur votre navigateur :

- [ecoservice.coom](http://ecoservice.coom)
- [localhost:8080](http://localhost:8080)

## Environement

- Projet sur `/data/ecs/www`

- Synchro des fichiers automatique sur phpStorm

- N'utilisez pas VScode

- N'oublier pas de mettre à jour le schema quand vous modifiez des entités

## Le flux de travail

- Je créer une branche à partir de celle demandée par mon ticket ou je demande
- Je code une feature `front` / `back` / `fullstack`
- Je download `composer.json` et `package.json`, les `.lock` aussi
- Je met à jour ma branche : [Mettre a jour sa branche](docs/3GitFlow.md#majbranche)
- Je créer une PR [Faire une PR](docs/3GitFlow.md#environments)
- J'envoie le lien de ma PR sur `#conversation`
- Je me fait review par les autres membres de l'équipe
- On merge

## Règles d'or
- Le code est la meilleure documentation.

- Vos variables/constantes doivent être nommées en sorte que quelqu'un ne connaissant rien en informatique puisse comprendre votre code`

## Conventions

- Suivre l'architecture :

```
- Core (code utilisé dans tout les espaces comme les mails/ connexion...)
- FrontOffice : Interface utilisateur et récupération des donnée avec API
- Admin : Pages d'administration et de gestion des contenus
```

## Tests / debug

Pour se connecter sur le back office [/admin](ecoservice.coom/admin) avec les ids
`admin@domain.tld` / `s3cr3t`

Pour les utilisateurs front office créer le votre avec un faux mail
