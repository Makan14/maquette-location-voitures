<?php require_once('inc/header.php'); 

$afficheVehicules = $pdo->query("SELECT * FROM vehicule ORDER BY created_at DESC LIMIT 0,10");


?>


<h1 class="text-center text-danger my-5">Consultez toutes nos annonces</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Annonce</th>
            <th>Lieu</th>
            <th>Prix et type</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php while($vehicule = $afficheVehicules->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td>
                    <strong></strong>
                    <p>
                        <small>
                        <?= $vehicule['description'] ?>
                            
                        </small>
                    </p>
                </td>
                <td>
                    <?= $vehicule['code_postal']?>
                    <?= $vehicule['city'] ?>
                <?php if(!empty($vehicule['reservation_message'])):?>
                    <span class="badge bg-success">Ce bien a déjà été réservé !</span>
                <?php endif ?>                   
                </td>
                <td>
                    <span class="badge bg-danger"><?= $vehicule['type'] ?></span>
                    <span class="badge bg-warning"><?= $vehicule['price'] ?> €</span>
                </td>
                <td>
                    <a href="show.php?id=<?= $vehicule['id'] ?>" class="btn btn-danger">Voir l'annonce</a>
                </td>
            </tr>
        <?php endwhile ?>;
    </tbody>
</table>

<?php require_once('inc/footer.php');