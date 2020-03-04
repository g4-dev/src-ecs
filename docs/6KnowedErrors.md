[&larr; retour aux **tips**](5Tips.md) &nbsp;&nbsp; | &nbsp;&nbsp; [**Sommaire** &rarr;](0Sommaire.md)

# Erreurs connues
> *Liste d'erreurs possibles avant de demander de l'aide:* 

### Deployment

- Classes non retrouvées `deployment` > `options` > Enlever `**/vendor/**` et clic droit > deployment > download www/
- Vérifier les mappings dans `deployment` > `ecs` > `onglet mappings` (paths à `/`)
- Vérifier `deployment` > `options` > `always` sur `Upload changed files every...`

### Lors du provision

#### `Device or resource busy: '/data/ecs/www'` : 

- Fermer PHPStorm 
- Relancez avec `vagrant --provision`
- Réouvrir PHPStorm *une fois le provision fini*

**Il est possible que cette erreur soit due au NFS: Suivez cette [étape](#Erreurssystemedefichier)**

- VM cassé (on ne sais plus quoi faire): `vagrant destroy` puis `vagrant up`

## Installation

> Erreurs lors de l'installation

### Les sources ne s'upload pas

Allez dans `paramètres` > `deployment` > `options` > `cocher Always save`

### SSH errors

```
SSH authentication failed! This is typically caused by the public/private
keypair for the SSH user not being properly set on the guest VM. Please
verify that the guest VM is setup with the proper public key, and that
the private key path for Vagrant is setup properly as well.
```

- Executer cette commande : `ssh-keygen -m PEM -t rsa -b 4096 -C "votre-adresse@mail.com"`
- Sur votre machine `cat ~/.ssh/id_rsa.pub`  
- Ensuite `vagrant ssh` pour entrer dans la VM
- `rm ~/.ssh/authorized_keys` et `vi ~/.ssh/authorized_keys` puis copier (ajouter au fichier sans supprimer ce qu'il restait) le contenu de votre nouvelle clé obtenue avec la commande précédente.

##### Le protocole utilisé par ssh n'utilise plus le même algorithme de cryptographie sur la dernière maj windows

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
