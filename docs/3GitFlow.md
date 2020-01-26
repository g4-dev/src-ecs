[**&larr; retour à la Stack**](2Stack.md) &nbsp;&nbsp; | &nbsp;&nbsp; [**Tests** &rarr;](4Tests.md)

# Notre git flow

## Introduction
Les objectifs de ce flux de travail:
 - Pouvoir se répartir le travail à plusieurs
 - Identifiers des objectifs grâce aux releases prévues 
 - Centraliser la gestion des revues et la qualité du code
 - Eviter des bugs

## Index
0. [Mise en place des remotes](#remotes)
1. [Branches](#branches)
2. [Environnement](#environments)
3. [Mettre à jour sa branche](#majbranche)
4. [Pull requests](#environments)

## Remotes

**!! Avant tout !!** il faut bien vérifier qu'on a les bonnes remotes `origin` et `g4-dev`

##### entrez cette commande pour ajouter le repository parent à votre fork et mettre à jour vos branches

```
git remote add g4-dev git@github.com:g4-dev/src-ecs.git
```

On a donc deux repository ou remotes distantes :
- `origin` : notre fork là où l'on peut push
- `g4-dev` : notre repository parent où l'on fusionne le travail de chacun (**interdit de push**)

#### Trois espaces possibles :
  - **Core** (à ne pas trop toucher) &rarr; ***`core`***
  - **Portal** (FrontOffice) &rarr; ***`fo`***
  - **Admin** (BackOffice) &rarr; ***`bo`***

&rarr; exemple `bo_features/products`

- `release/version` - branches for release(production) version;
- `hotfix-*` - branches for release `fixes`;

## Branches

Ces branches son des branches de références sur lesquelles nous **ne travaillons pas**.
On merge seulement dessus des Pull requests correspondant à une branche de ticket.

- `master` - always **stable** and **release ready** branch; (production)
- `develop` - default branch, contains latest **features** and **fixes**, on which developers should orient;
- `<nom-espace>_features/<nom-feature>` - branches feature development and dependencies update;
On utise des prefixes pour identifier un espace concerné.

## MAJ Branche
> Super important de mettre régulièrement à jour sa branche

Avant de travailler sur un projet/ ou de merge une branche sur une des principales on se met à jour avec:

```
git fetch upstream
git rebase upstream <nom-de-la-branche-qui-a-la-maj>
```

Dans le cas d'une PR je dois push cette branche sur mon fork (origin) :

`git push -u origin <nom-branche>`

## Environment

On fonctionne avec deux interface principales :
- `github`
- `clickup`

Sur Clickup on récupère les tâches à faire et ensuite on les éxecute sur github.
>  Les PR/ commits se retrouveront sur clickup si on suit bien la 
convention `#id-ticket[status]` dans les messages de commit et titres de PR.


Voici un exemple de Pull request détaillé :

  1. Je **m'assigne** un ticket avec l'id `#34jeq3`

  ![image_ticket](res/start_ticket.png)

  2. Je créer une branche à partir de la dernière version de `develop` ou de la release` proche` (vérifier sur le ticket)
  
  ```
  git fetch upstream develop:34jeq3
  git checkout 34jeq3
  ```

  3. Je code ma feature

  4. Je créer une PR quand j'ai fini
  
  ![pr-step-1](res/pr-step1.png)
  
  Ensuite je choisis l'option `compare across forks` et sélectionne les bonnes branches avant de faire la PR:
  Ici je veux merge la branche de mon ticket `#34jeq3`
  ##### `g4-dev/develop` << `<mon-pseudo-github>/#<id-mon-ticket>` 
  
  5. Vous ouvrez la PR et changer le titre avec l'id de votre ticket puis vous vous laissez guider par les consigne dans le template de pull request qui s'affiche.
  
  &rarr; **Attention à ne pas oublier le `#` devant le numéro pour que la PR s'affiche sur clickup**

### Supporting readings

1. [Semantic Versioning 2.0.0](http://semver.org/)
2. [Git cheat sheet](https://training.github.com/kit/downloads/github-git-cheat-sheet.pdf)
3. [Github help: user collaborating](https://help.github.com/categories/collaborating/)

### <center>[Retour au sommaire &#8617;](0Sommaire.md)</center>