# ECF_SFGarage

     lien github :https://github.com/AnissaK-B
     lien trello : https://trello.com/b/1wVWf62s/garage-parrot
     Lien Figma : https://www.figma.com/file/nULvZIkEh2hiygxyHYhPUA/Wireframing-(Garrage-parrot)?type=design&node-id=0- 
     1&mode=design&t=1Yh6y8V14HTNkWio-0
=======
    
# Environnement technique
    server web Wampserver
    Mysql 8.0
    php 8.0
    symfony 6.3
    Bootstrap 5.3
    easyadmin 4.7
    VsCode
    webpack Encore


# Configuration
    creation d'un fichier .env.local
 

 # Connexion à la Base de données
    Dans fichier .env.local se trouve
    DATABASE_URL="mysql://root:@127.0.0.1:3306/garage_parrot?serverVersion=8.0.32&charset=utf8mb4"

    on cree la base de donnée: php bin/ console doctrine:database:create:garage_parrot
   
#  Installation
     composer :https://getcomposer.org/download

     symfony cli
     https://symfony.com/download
    Installation des dependances :composer install
    lancement du server commande :symfony serve ou symfony server:start
    ouverture du navigateur sur localhost8000


 
