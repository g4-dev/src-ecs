[&larr; retour aux **tests**](4Tests.md) &nbsp;&nbsp; | &nbsp;&nbsp; [**Erreurs connues** &rarr;](6KnowedErrors.md)

# Trucs et astuces

### Sur le terminal de la VM
Le shell est un `bash` classique qui est toutefois un peu tuné.

## Voici une liste de commandes shell

`h` &rarr; pour chercher dans son historique de commandes<br>
`la` &rarr; Afficher les fichiers cachés<br>
`folders` &rarr; Voir la taille des fichiers<br>
`f` &rarr; Pour chercher un fichier

### projet :
`www` &rarr; pour directement aller au projet<br>
`sf` équivaut à `php bin/console`<br>
`sfcache` pour clear le cache Symfony <br>
`dschema` = `sf doctrine:schema:update`

### Composer :
`cr` &rarr; `composer require`<br>
`crd` &rarr; `composer require-dev` <br>
`ci` &rarr; `composer install` <br>

### Node :
`yw` &rarr; `yarn watch` <br>
`yd` &rarr; `yarn dev`<br>
`yi` &rarr; `yarn add` <br>
`yt` &rarr; `yarn test` <br>

### Conseil de Shell
- [Installer Cygwin](https://www.cygwin.com/) pour windows
- Lors du processus d'installation selectionnez les packages `wget` &nbsp; `curl` &nbsp; `lynx` &nbsp; `git` &nbsp; `vim` &nbsp; `fish`
> Attention à celui que vous prenez (nom exactes ci dessus)
- Lancer le terminal et faire `echo 'fish' >> .bash_profile`
- Run `lynx -source rawgit.com/transcode-open/apt-cyg/master/apt-cyg > apt-cyg`
- install `apt-cyg /bin`

Redémarrez votre shell et puis laisser la magie opérer en écrivant la commande `fish_config`

### Bonus : 
Installez la police [Fira Code dispo ici](https://github.com/tonsky/FiraCode/releases/download/1.206/FiraCode_1.206.zip) en faisant `clic droit` > `paramètres` sur votre shell
Vous pouvez l'installer

Puis :
```
curl https://git.io/fisher --create-dirs -sLo ~/.config/fish/functions/fisher.fish;
fish
fisher add hauleth/agnoster
```
---
### <center>[Retour au sommaire &#8617;](0Sommaire.md)</center>