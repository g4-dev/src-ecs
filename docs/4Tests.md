[&larr; retour au **Git flow**](3GitFlow.md) &nbsp;&nbsp; | &nbsp;&nbsp; [**Astuces** &rarr;](5Tips)

# Tests

### Comptes utilisateurs

Pour se connecter sur le back office [/admin](ecoservice.coom/admin) avec les ids
`admin@domain.tld` / `s3cr3t`

Pour les utilisateurs front office créer le votre avec un faux mail


### Intégration continue 

Pas encore fait, on ne va pas trop écrire de tests on aura pas tellement le temps

Actuellement simple vérif du `composer install`

Cela permet d'éviter des erreurs comme :
- De mauvais push de branche cassant d'autres fonctionnalités
- Oubli d'un bundle par non synchronisation d'un fichier
 comme `composer.lock` ou `yarn.lock` (et les `.json`)

---
### <center>[Retour au sommaire &#8617;](0Sommaire.md)</center>