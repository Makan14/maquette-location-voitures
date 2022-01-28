<?php require_once('inc/header.php'); 

$afficheVehicules = $pdo->query("SELECT * FROM vehicule ORDER BY created_at DESC LIMIT 0,10");



?>

<div class="jumbotron">
    <h1 class="text-center text-danger my-5">Votre voiture.com</h1>
    <p class="lead">Vendez, achetez, louez une voiture facilement avec voiture.com !</p>
    <hr class="my-5">
    <div class="row">
        <img src="img/background.jpg" alt="">
    </div>
    <div class="row text-center mt-5">
        <p class="col-12">
            <a class="btn btn-outline-danger btn-lg me-5" href="add.php" role="button">J'ajoute mon annonce !</a>
            <a class="btn btn-danger btn-lg ms-5" href="list.php" role="button">Voir la liste des annonces</a>
        </p>
    </div>
</div>

<h1 class="mt-5">Nos 10 dernières annonces ajoutées</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Annonce</th>
            <th>Lieu</th>
            <th>Prix et type</th>
        </tr>
    </thead>
    <tbody>
        <?php while($vehicule = $afficheVehicules->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td>
                    <strong><?= strtoupper($vehicule['title']) ?></strong>
                    <p>
                        <small>
                            <?= $vehicule['description'] ?>
                        </small>
                    </p>
                </td>
                <td>
                    <?= $vehicule['code_postal']?>
                    <?= $vehicule['city'] ?>   
                </td>
                <td>
                    <span class="badge bg-primary"><?= $vehicule['type'] ?></span>
                    <span class="badge bg-secondary"><?= $vehicule['price'] ?> €</span>
                </td>
            </tr>
        <?php endwhile ?>;
    </tbody>
</table>

<?php require_once('inc/footer.php');