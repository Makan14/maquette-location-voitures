<?php

//PDO = surcouche de PHP permet d interagir avc la BDD
//Ns avons plsrs fonctions prédefinies prpre à la classe PDO
//pr pouvoir ls exploiter, je dois créer 1 objet $pdo de ma classe PDO
//je ne suis pas obliger de l appelr ainsi. $bdd s affiche parfois
//pr me connecter à la BDD je renseigne le host. Cmme ns sommes en local, ça sera localhost
//le dbname, cst le nom de ma BDD (ns avns choisis voiture)
//root est le  nom du dbuser (identifiant de l utilisateur) en localhost
//le quotes vides '' snt pr le dbpassword (mot de passe pr la BDD). 
//en local il doit stay vide. Ps de mot de passe
$pdo = new PDO('mysql:host=localhost;dbname=voiture' , 'root', '', array(
    
    //dns ce array/tableau je défini 2 parametres
    //le 1er concerne le mode d erreur que je veux recevoir en affichage. je choice le mode warning
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, //je demande le type d erreur (ERRMODE = mode d erreur)
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', 
) );

// j initialise cs 2 variables a vide(ne rien mettre entre ls quotes mm pas 1 space car je vais en avoir bsoin sur ttes mes pages du sites)
$erreur = '';
$content = '';


?>