<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp import" style="width: auto;">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Statut : <br><?php echo htmlspecialchars($statut->nommer()) ?></h2>
        </div>
        <div class="mdl-card__supporting-text mdl-card--border">
            Statut v1 : <?php echo htmlspecialchars($statut->getStatut()) ?><br>
            Statut v2 : <?php echo htmlspecialchars($statut->getTypeStatut()) ?><br>
            Nombre d'heures à faire : <?php echo htmlspecialchars($statut->getNombresHeures()) ?><br>
        </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=statutEnseignant&action=update&codeStatut=<?php echo htmlspecialchars($statut->getCodeStatut()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
            <a href="index.php?controller=statutEnseignant&action=delete&codeStatut=<?php echo htmlspecialchars($statut->getCodeStatut()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">delete</i>
                </button>
            </a>
        </div>
    </div>

</div>