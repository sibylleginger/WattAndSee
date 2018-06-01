<div class="detailProjet">
    <div class="demo-card-square mdl-card mdl-shadow--2dp projetPres">
    <div class="mdl-card__title mdl-card--expand">
        <h3><?php echo $projet->getNomProjet() ?></h3>
    </div>
    <div class="mdl-card__supporting-text">
        Statut du projet : <?php echo $projet->getStatut() ?><br>
        Programme de financement : 
        <?php
        if ($sourceFin == false) {
            echo "Inconnue<br>";
        }else {
            echo '<a href="index.php?controller=sourceFin&action=read&codeSourceFin='.$sourceFin->getCodeSourceFin().'">'.$sourceFin->getNomSourceFin().'</a><br>';  
        }
        ?>
        Date de dépôt du dossier : <?php echo $projet->getDateDepot();?> <br>
        <?php if ($projet->getDateReponse() != null) { ?>
            Date de réponse : <?php echo $projet->getDateReponse();
        }?> <br>
    </div>
    <div class="mdl-card__actions mdl-card--border">
        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="index.php?controller=projet&action=read&codeProjet=<?php echo $projet->getCodeProjet() ?>">Détails du projet</a>
        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="index.php?controller=note&action=readAllByProjet&codeProjet=<?php echo $projet->getCodeProjet() ?>">Commentaires sur le projet</a>
    </div>
    </div>

    <div class="content">
        <h4>Documents</h4>
        <ul>
            <?php
                foreach ($tabDoc as $key => $value) {
                    echo '<li><a href="./docs/'.$value->getNamePJ().'">'.$value->getTitre().'</a><a href="index.php?controller=document&action=delete&codeProjet&='.$projet->getCodeProjet().'&codeDocument='.$value->getNamePJ().'"><i class="material-icons">delete</i></a></li>';
                }
            ?>
        </ul>
    </div>
</div>
<a href="index.php?controller=document&action=create&codeProjet=<?php echo $projet->getCodeProjet()?>">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>