[&larr; retour au **Git flow**](3GitFlow.md) &nbsp;&nbsp; | &nbsp;&nbsp; [**Astuces** &rarr;](5Tips.md)

# Tests

### Comptes utilisateurs

Pour se connecter sur le back office [/admin](ecoservice.coom/admin) avec les ids
`admin@domain.tld` / `s3cr3t`

Pour les utilisateurs front office créer le votre avec un faux mail

Mettez toujours des utilisateurs avec le mdp `Azerty69`
pour que tout le monde puissent les utiliser

Liste (à compléter avec vos users):
- `test-ecs@yopmail.com` `Azerty69`

##### Pourquoi pas générer des fixtures avec `faker` et `doctrine fixtures`

### Intégration continue 

Circle CI permet de vérifier si l'on a fait des erreurs dans notre code php
> Si un build fail vous devez vérifier en consultant la console du build qui ne passe pas<br>
Normalement ce n'est rien de trop compliqué

Actuellement simple vérif du `composer install` / `yarn install` / `yarn dev`

Cela permet d'éviter des erreurs comme :

- De mauvais push de branche cassant d'autres fonctionnalités
- Oubli d'un bundle par non synchronisation d'un fichier
 comme `composer.lock` ou `yarn.lock` (et les `.json`)
- Des typos qui cassent le projet 

---
[&larr; retour au **Git flow**](3GitFlow.md) &nbsp;&nbsp; | &nbsp;&nbsp; [**Astuces** &rarr;](5Tips.md)
