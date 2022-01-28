<?php require_once('inc/header.php');

//if($_POST) dit à PHP de s occuper du traitement slement dns le cs ou ls infos auront été send dns le formulaire. Sinn il ne fait rien
//!isset = existe (vrai ou faux, existe ou pas)
if($_POST){
    //je vérifie 2 choses ici. la 1er cst que le champ est bien renseigné (avc isset, s il ne l est ps, alors causera 1 erreur). Le second parametre concerne la longueur de chaines de caracteres (avc icon_strlen). Si elle est < à 3 ou > à 20 cela causera 1 erreur 
    if (!isset($_POST['title']) || iconv_strlen($_POST['title']) <= 3 || iconv_strlen($_POST['title']) > 20) {
        $erreur .= '<div class="alert alert-danger" role>Erreur format Titre/marque !</div>';
    }

    //je fais la mm vérif que précédemment, si la donnée existe, et la longueur de la chaine de caractères, sauf que j autorise que cette longueur soit pls 1portante
    if (!isset($_POST['description']) || iconv_strlen($_POST['description']) <= 3 || iconv_strlen($_POST['description']) > 200) {
        $erreur .= '<div class="alert alert-danger" role>Erreur format description/marque !</div>';
    }
    
    //je verifie si l envoi de données a été effectué ou non.
    //!preg_match = dire quel caracter j utilise et dns quel quantités, 
    if (!isset($_POST['code_postal']) || !preg_match("#^[0-9]{5}$#", $_POST['code_postal'])) {
        $erreur .= '<div class="alert alert-danger" role>Erreur format code postal !</div>';
    }
    
    
    if (!isset($_POST['city']) || iconv_strlen($_POST['city']) <= 2 || iconv_strlen($_POST['city']) > 30) {
        $erreur .= '<div class="alert alert-danger" role>Erreur format ville !</div>';
    }

    //je verifie si l envoi de données a été effectué ou non.
    //!preg_match = dire quel caracter j utilise et dns quel quantités, 
    //j autorise ts ls chiffres de 0 à 9 [0-9] j autorise aussi 1 seul chiffre (je loue ma voiture 5e/j jusqu a 7, je sell ma voiture 1M€.) de 1 à 7 {1,7}
    if (!isset($_POST['price']) || !preg_match("#^[0-9]{1,7}$#", $_POST['price'])) {
        $erreur .= '<div class="alert alert-danger" role>Erreur format prix !</div>';
    }

    //vérif du champs selecteur. En pls de la donnée qui existe, 7 donnée ne pooura etre diff de 'location' et 'vente'. Si aucune ds 2 ne correspond, alrs msg d erreur 
    if (!isset($_POST['type']) || $_POST['type'] != 'location' && $_POST['type'] != 'vente') {
        $erreur .= '<div class="alert alert-danger" role>Erreur format type !</div>';
    }

    if (empty($erreur)) {
        //syntaxe de la requete prepare
        $ajoutVehicule = $pdo->prepare("INSERT INTO vehicule (title, description, code_postal, city, price, type, created_at) VALUES (:title, :description, :code_postal, :city, :price, :type, NOW())");
        //: = pointeur nommé
        $ajoutVehicule->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
        $ajoutVehicule->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $ajoutVehicule->bindValue(':code_postal', $_POST['code_postal'], PDO::PARAM_INT);
        $ajoutVehicule->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
        $ajoutVehicule->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
        $ajoutVehicule->bindValue(':type', $_POST['type'], PDO::PARAM_STR);
        $ajoutVehicule->execute();

        $content .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
            <strong>Félicitations !</strong> Ajout du véhicule réussie !
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}

?>

<h1 class="text-center text-danger my-5">Ajouter une annonce</h1>

<?= $erreur ?>

<form class="col-md-6 mb-5" method="post" action="">

    <div class="form-group my-2">
        <label for="title">Titre *</label>
        <input id="title" name="title" type="text" class="form-control" placeholder="La marque de votre véhicule..." required value="">
    </div>

    <div class="form-group my-2">
        <label for="description">Description *</label>
        <textarea id="description" name="description" id="" cols="30" rows="5" class="form-control" placeholder="Une description sincère de l'état du véhicule et de ses équipements !" required></textarea>
    </div>

    <div class="form-group my-2">
        <label for="code_postal">Code postal *</label>
        <input id="code_postal" name="code_postal" type="text" class="form-control" placeholder="code postal" value="" required>
    </div>

    <div class="form-group my-2">
        <label for="city">Ville *</label>
        <input for="city" name="city" type="text" class="form-control" placeholder="Ville" value="" required>
    </div>

    <div class="form-group my-2">
        <label for="price">Tarif *</label>
        <div class="input-group">
            <input id="price" name="price" type="price" class="form-control" placeholder="prix à la location/jour ou prix de vente" required>
            <div class="input-group-append">
                <div class="input-group-text">€</div>
            </div>
        </div>
    </div>

    <div class="form-group my-2">
        <label for="type">Type *</label>
        <select name="type" id="type" class="form-control" required>
            <option value="location" >Location</option>
            <option value="vente" >Vente</option>
        </select>
    </div>

    <button type="submit" class="btn btn-outline-danger mt-5">Créer une annonce</button>

</form>

<?php require_once('inc/footer.php');