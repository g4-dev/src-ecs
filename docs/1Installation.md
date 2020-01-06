[&larr; retour au **Sommaire**](0Sommaire.md) &nbsp;&nbsp;| &nbsp;&nbsp;[**Stacks et bonnes pratiques** &rarr;](2Stack.md)

# 1. initialisation du projet

### Requis
- vagrant 2.2.+
- VirtualBox 6.0.8

## Installation et lancement de la vm

- Ajouter sa clé ssh sur **Github**: [doc ici](https://help.github.com/en/github/authenticating-to-github/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent#generating-a-new-ssh-key)
- Lancer la VM avec `vagrant up`

> Un script assez long va se charger d'installer tous les outils et de configurer l'environment du projet<br>

- Après `vagrant ssh` | Consulter la liste des commandes shells : [Ici](5Tips)
- [localhost:81](http://localhost:81)

### Le nom de domaine
Il est intéressant de dissocier les url de projet et donc pour cela on peut utiliser le domaine personnalisé :
[**ecoservice.dev**](https://ecoservice.dev) <br>
Pour utiliser ce domaine on peut ajouter manuellement [**ce certificat**](full_certificat.pfx) dans notre navigateur.<br><br>

**Tuto** : (FF ou Chrome) > `paramètres` > rechercher `ssl` > Gérér les certificats > Importer le fichier [`.pfx`](cert/full.pfx) ou [`pem`](cert/certificat.pem)

---
Sinon on peut toujours se contenter de [localhost:81](http://localhost:81)

## Base de donnée
Cette base de donnée est hébergée à distance afin que l'on puisse travailler avec les mêmes datas

- mysql_host: `remotemysql.com`
- mysql_user: `EmwnLitSLR`
- mysql_pw: `Gk0qCm6hFI`
- mysql_db: `eEmwnLitSLR`
### [**lien vers Phpmyadmin**](https://remotemysql.com/phpmyadmin/index.php) 

# NFS
Le NFS est un système de partage de fichier haute performance compatible avec Linux et Mac<br>

#### Sur mac
- Donner l'accès complès au disque pour le terminal dans `sécurité & confidentialité`
Petite amélioration de performance avec : `git config core.preloadindex true`

#### Sur linux (debian/ubuntu)
`apt install nfs-kernel-server nfs-common`

### Erreurs connues

- Le **nfs** ne marche pas sur mac os catalina : [solution à suivre](https://stackoverflow.com/a/58547588 )

- Le **certificat** n'est toujours pas bon, pour récupérer le bon éxecuter à la racine du projet: 
> `scp -P 22 root@ecoservice.dev:/etc/ssl/ecoservice.dev/pkcs12.pfx docs/cert/` (mdp: vagrant)

- lorsque on reprovisionne la vm avec le NFS activé: <br>
    **Exécuter** : 
    ```
    rm .vagrant/machines/default/action_provision && vagrant reload --provision
    ```

---
### <center>[Retour au sommaire &#8617;](docs/0Sommaire.md)</center>