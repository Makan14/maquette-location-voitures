<?php require_once('inc/header.php'); 

//je vérifie que je reçois dns L URL (avc $_GET) 1 valeur (avc isset), qu elle est de type numérique (avc ctype_digit) et qu elle ne soit ps inf à 1 (la valeur minimal pr 1 id auto-incrémenté)
if (!isset($_GET['id']) || !ctype_digit($_GET['id']) || $_GET['id'] < 1) {
    
    //si ce n est pas le cas, j empeche d acceder a la page show avc 1 mauvaise valeur en renvoyant vers la page list.php
    header('location:list.php'); //header pr la redirection et location renvoie vers la page list.php
}

if ($_POST) {
    //je verif le contenu du champs reservation_msg 
    //qu il existe et qu il n a pas reçu moins de 3 caracteres et pls de 200 sinn je génère 1 msg d erreur
    if(!isset($_POST['reservation_message']) || iconv_strlen($_POST['reservation_message']) < 3 || iconv_strlen($_POST['reservation_message'])> 200) {
        $erreur .= '<div class="alert alert-danger"role="alert">Erreur format message !</div>'; //.= (opération de concaténation qui affecte une valeur)
    }

    //si aucun msg d erreur n a été généré cst que $erreur n a ps reçu de contenu je peux dnc enclencher la procédure d envoi ds données en BDD
    if (empty($erreur)) {
        //j utilisie mn objet $pdo pr interagir avc la BDD
        //je fais 1 requete préparé pr sécuriser l envoie ds données
        //je vais faire 1 modif en BDD d ou l usage de la requete UPDATE 
        //je fais correspondre ls indices concernés en BDD avc son équivalent avc 1 marqueur nommé
        //le WHERE sert à faire correspondre le véhicule qui a cet id (dns cette page) avc le véhicule qui a le mm id en BDD
        $ajoutMessage = $pdo->prepare("UPDATE vehicule SET id = :id, reservation_message = :reservation_message WHERE id = :id");
        // je code les bindValue pour faire correspondre le l'indice/pointeur nommé ( : ) avec la valeur reçue du formulaire + j'indique le type de cette valeur (PARRAM_INT pour type integer en parametre)
        $ajoutMessage->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $ajoutMessage->bindValue(':reservation_message', $_POST['reservation_message'], PDO::PARAM_STR);
        $ajoutMessage->execute();
    }
}

//on select tte ls infos du vehicule avc l objet $pdo. je le fais avc 1 requete de type query.
//je demnde à $pdo de cibler l id qui sera égal à l id pris dns l URL ($_GET['id'])
$afficheInformations = $pdo->query("SELECT * FROM vehicule WHERE id = $_GET[id]"); 
$information = $afficheInformations->fetch(PDO::FETCH_ASSOC);
//fetch = search tte ls infos en BDD

//je calcul le délai entre le jour ou l user voit l annonce et le day ou elle a été publiée
//la date de publication je peut l avoir en crochetant à l indice ['created_at'] présent en base de données
//je dois utiliser strtotime() pr convertir 7 valeur, qui est stockée en tnt que string vers 1 type numérique 
//cette valeur désormais numérique aura cmme unité de valeurs ds secondes.
$date_debut = strtotime($information['created_at']);
$date_fin = time();
//je vais dnc soustraire la valeur de date_fin à date_début, puis convertir ce résultat exrimé en seconde et en jours.
$delai = round(($date_fin - $date_debut) / 86400); //round = arrondir
//86400 = pr avoir la conversion de seconde en jours (60s x 60mn x 24h)
//j tutilise la fonction round() pr arrondir le résultat de cette sstraction au chiffre en dessous
//il existe 1 autre fonction pr arrondir au chiffre supérieur cst ceil()
?>

<!-- je met entre crochet l indice du tableau 'title' dont j'ai besoin pr avoir 1 h1 dynamique. le titre généré sera diff selon la voiture sur laquelle on aura cliqué -->
<h1 class="text-center text-danger my-5">Voiture <?=$information['title']?> en <?= $information['type'] ?></h1>

<?php $erreur ?>

<a href="list.php"><button class="btn btn-outline-danger">Retour à la liste des biens</button></a>
<hr>
<div class="card col-md-6 my-5 border border-warning text-center">
    <div class="card-header">
    Le véhicule <?= $information['title'] ?> est disponible à <?= $information['city'] ?> (code postal: <?= $information['code_postal'] ?> )
    </div>
    <div class="card-body">
        <h5 class="card-title">Ce véhicule est proposé à la <?= $information['type'] ?>  au prix de
         <!-- je fais 1 condition pr avoir 1 affichage diff pr le prix si cst 1 vente ou 1 location -->
        <?php if($information['type'] == 'vente'){
            echo $information['price'] . " €";
        } else {
            echo $information['price'] . " €/j";
        }       
        ?>
        </h5>
        <p class="card-text"></p>
    </div>
    <div class="card-footer text-muted">
        <!-- je fais 1 condition pr prendre en compte 2 cas de figure : -->
        <!-- si le nombre de jrs écoulés depuis la publication de l annonce est égal à 0 -->
        <?php if ($delai == 0) {
            // alors je ne veux ps afficher 0 jrs, mais ojd
            echo "Annonce postée Aujourd'hui";
        }else {
            echo "<p>Annonce postée il ya " . $delai . " jour(s)</p>" ;
        }
    
    ?></p> 
    </div>

    
    <?php if(empty($information['reservation_message'])): ?>
        <p>
            <strong>
                Ce véhicule n'est pas réservé ! Soyez les premiers à laisser un message afin que le propriétaire vous recontacte.
            </strong>

            <form class="mx-5" action="" method="post">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <div class="form-group">
                    <label for="formReservationMessage">Message de réservation</label>
                    <textarea name="reservation_message" id="formReservationMessage" rows="5" class="form-control" placeholder="Donnez un maximum de coordonnées pour que le propriétaire vous recontacte !"></textarea>
                </div>

                <button class="btn btn-outline-danger mt-3">Je réserve ce véhicule !</button>
            </form>
        </p>
    <?php else: ?>
        <div class="alert alert-warning">
            <p>               
                <hr>
                <em></em>
                Ce véhicule a été reservé, voici le message du futur conducteur:
            </p>
        </div>
    <?php endif; ?>
    
</div>

<?php require_once('inc/footer.php');