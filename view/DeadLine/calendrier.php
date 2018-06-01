<h3>Calendrier</h3>
<div class="detailProjet">
    <?php
        foreach ($dates as $value) {
            list($year, $month, $day) = explode('-', $value->getDateDeadLine());
            $tab = ModelDeadLine::selectByDate($value->getDateDeadLine());
            echo '<div class="demo-card-square mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-card--expand">
                        <h2 class="mdl-card__title-text">'.$day.'/'.$month.'/'.$year.'</h2>
                    </div>
                  <div class="mdl-card__actions mdl-card--border">';
            foreach ($tab as $deadLine) {
                $projet = ModelProjet::select($deadLine->getCodeProjet());
                if ($deadLine->getDateDeadLine() == $value->getDateDeadLine()) {
                    echo '
                        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="index.php?controller=projet&action=read&codeProjet='.$deadLine->getCodeProjet().'">'.$projet->getNomProjet().'</a> - '.$deadLine->getNomDeadLine().'<a class="deleteDate" id="'.$deadLine->getCodeDeadLine().'" href=""><i class="material-icons">delete</i></a> ';
                }
            }
            echo '</div>
            </div>';
        }
    ?>
    
</div>

<!--
<a href="index.php?controller=departement&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>


<a href="index.php?controller=deadLine&action=create&codeProjet=<?php echo $projet->getCodeProjet()?>" class="new">
    <button id="demo-menu-top-right"
            class="mdl-button mdl-js-button mdl-button--fab">
        <i class="material-icons">add</i>
    </button>

    <!--<ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect"
        for="demo-menu-top-right">
        <a href="index.php?controller=departement&action=create"><li class="mdl-menu__item">Ajouter un nouveau projet</li></a>
        <a href="index.php?controller=diplome&action=create"><li class="mdl-menu__item">Créer un diplome</li></a>
        <a href="index.php?controller=uniteDEnseignement&action=create"><li class="mdl-menu__item">Créer une unité d'enseignement</li></a>
    </ul>
</a>-->