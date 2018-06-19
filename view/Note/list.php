<div class="detailProjet">
    <div class="demo-card-square mdl-card mdl-shadow--2dp projetPres">
    <div class="mdl-card__title mdl-card--expand">
        <h3><?php echo htmlspecialchars($projet->getNomProjet()) ?></h3>
    </div>
    <div class="mdl-card__supporting-text">
        <b>Statut du projet :</b> <?php echo $projet->getStatut() ?><br>
        <b>Programme de financement :</b> 
        <?php
        if ($sourceFin == false) {
            echo "Inconnue<br>";
        }else {
            echo '<a href="index.php?controller=sourceFin&action=read&codeSourceFin='.$sourceFin->getCodeSourceFin().'">'.htmlspecialchars($sourceFin->getNomSourceFin()).'</a><br>';  
        }
        ?>
        <b>Date de dépôt du dossier :</b> <?php list($year, $month, $day) = explode('-', $projet->getDateDepot());
                        echo $day.'/'.$month.'/'.$year; ?> <br>
        <?php if ($projet->getDateReponse() != null) { ?>
            <b>Date de réponse :</b> <?php list($year, $month, $day) = explode('-', $projet->getDateReponse());
                        echo $day.'/'.$month.'/'.$year.'<br>';
        }
        ?>
    </div>
    <div class="mdl-card__actions mdl-card--border">
        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="index.php?controller=projet&action=read&codeProjet=<?php echo $projet->getCodeProjet() ?>">Détails du projet</a>
        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="index.php?controller=document&action=readAllByProjet&codeProjet=<?php echo $projet->getCodeProjet() ?>">Documents du projet</a>
    </div>
    </div>

    <div class="content">
        <h4>Commentaires</h4>
        <div class="mdl-card__supporting-text">
            <?php
                foreach ($tabComment as $value) {
                    echo '<div class="mdl-card mdl-shadow--2dp comment">
                            <div class="mdl-card__supporting-text">
                                <p>'.htmlspecialchars($value->getComment()).'</p>
                            </div>
                            <div class="mdl-card__actions mdl-card--border commentHeader">
                            <p>';
                    list($year, $month, $day) = explode('-', $value->getDateNote());
                    echo $day.'/'.$month.'/'.$year.'</p>
                            <p>'.htmlspecialchars($value->getMailUser()).'</p>
                            <a href="index.php?controller=note&action=delete&codeProjet='.$projet->getCodeProjet().'&codeNote='.$value->getCodeNote().'"><i class="material-icons">delete</i></a>
                        </div></div>';
                }
            ?>
        </div>
    </div>
</div>
<a href="index.php?controller=note&action=create&codeProjet=<?php echo $projet->getCodeProjet()?>" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
    <i class="material-icons">add</i>
</a>