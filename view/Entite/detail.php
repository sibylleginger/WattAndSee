<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Salle : <?php echo htmlspecialchars($_GET['nomBatiment'] . '_' . $_GET['numSalle']) ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            Capacité : <?php echo htmlspecialchars($salle->getCapacite())?><br>
            Type : <?php echo htmlspecialchars($salle->getTypeSalle())?><br>
            Taux d'occupation : <?php echo htmlspecialchars($salle->getTauxOccupation())?>
        </div>
        <div class = "mdl-card__menu">
            <button class = "mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                <a href="index.php?controller=salle&action=update&nomBatiment=<?php echo htmlspecialchars($_GET['nomBatiment']) ?>&numSalle=<?php echo htmlspecialchars($_GET['numSalle']) ?>"><i class = "material-icons">edit</i></button></a>
        </div>
    </div>

</div>