[&larr; retour aux **tips**](5Tips.md) &nbsp;&nbsp; | &nbsp;&nbsp; [**Sommaire** &rarr;](0Sommaire.md)

# Erreurs connues
> *Liste d'erreurs possibles avant de demander de l'aide:* 

### Lors du provision

#### `Device or resource busy: '/data/ecs/www'` : 
- fermez PHPStorm 
- relancez avec `vagrant --provision`
- Réouvrir PHPStorm *une fois le provision fini*

**Il est possible que cette erreur soit due au NFS: Suivez cette [étape](#Erreurssystemedefichier)**

- VM cassé (on ne sais plus quoi faire): `vagrant destroy` puis `vagrant up`

## Installation

Erreurs lors de l'installation

#### Le **nfs** ne marche pas sur mac os catalina : [solution à suivre](https://stackoverflow.com/a/58547588 )

&rarr; Il est parfois utile de réinstaller vagrant en suivant cette doc : [rebuild vagrant](https://www.vagrantup.com/docs/installation/source.html)

#### Erreurs système de fichier
>Erreur lorsque on reprovisionne la vm avec le NFS activé

**Exécuter** : 
```
rm .vagrant/machines/default/action_provision && vagrant reload --provision
```
---
[&larr; retour aux **tips**](5Tips.md) &nbsp;&nbsp; | &nbsp;&nbsp; [**Sommaire** &rarr;](0Sommaire.md)
