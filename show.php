<?php require_once('inc/header.php'); ?>

<h1 class="text-center text-danger my-5"></h1>

<a href="list.php"><button class="btn btn-outline-danger">Retour à la liste des biens</button></a>
<hr>
<div class="card">
    <div class="card-header">Le véhicule  est disponible à  (code postal: )</div>
    <div class="card-body">
        
    </div>
    <div class="card-footer">
        <p>
            Ce véhicule est une  proposée à un tarif de  €.
        </p>
    </div>
</div>

<hr>
<p>
    
        <p>
            <strong>
                Ce véhicule n'est pas réservé ! Soyez les premiers à laisser un message afin que le propriétaire vous recontacte.
            </strong>

            <form action="show.php" method="post">
                <div class="form-group">
                    <label for="formReservationMessage">Message de réservation</label>
                    <textarea name="reservation_message" id="formReservationMessage" rows="5" class="form-control" placeholder="Donnez un maximum de coordonnées pour que le propriétaire vous recontacte !"></textarea>
                </div>

                <button class="btn btn-outline-danger mt-3">Je réserve ce véhicule !</button>
            </form>
        </p>
    
        <div class="alert alert-warning">
            <p>
                Ce véhicule a été reservé, voici le message du futur conducteur :
                <hr>
                <em></em>
            </p>
        </div>
    
</p>

<?php require_once('inc/footer.php');