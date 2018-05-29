<div class="detailProjet">
    <!--<div class="mdl-card mdl-shadow--2dp detailBatiment2">-->
        <div>
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            Nom : <?php echo $participant->getNomParticipant() ?><br>
            Nationalité : <?php echo $participant->getNationalite() ?><br>
            <?php
                if ($participant->getMailParticipant() != null) {
                    echo "Adresse mail : ". $participant->getMailParticipant();
                }
                if ($participant->getAffiliation() != null) {
                    echo 'Affiliation : '. $participant->getAffiliation();
                }
            ?>
        </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=participant&action=update&codeParticipant=<?php echo htmlspecialchars($participant->getCodeParticipant()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
            <a href="index.php?controller=participant&action=delete&codeParticipant=<?php echo htmlspecialchars($participant->getCodeParticipant()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">delete</i>
                </button>
            </a>
        </div>
    </div>
    <!--</div>-->

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
        <thead>
        <tr>
            <th>Nom du projet</th>
            <th>Budget</th>
            <th>Coordinateur</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($tabProjet as $projet) {
            $participation = ModelParticipation::select($projet->getCodeProjet(),$participant->getCodeParticipant());
            $coordinateur = ModelParticipation::selectCoordinateur($projet->getCodeProjet());
            echo '    <tr>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=projet&action=read&codeProjet='.$projet->getCodeProjet().'">'.$projet->getNomProjet().'</a></td>
                        <td class="mdl-data-table__cell--non-numeric">'.$participation->getBudget().'</td>
                        <td class="mdl-data-table__cell--non-numeric">';
            if ($participant->getCodeParticipant()==$coordinateur->getCodeParticipant()) {
                echo '<i class="material-icons">thumb_up</i>';
            }
                echo '</td>
                </tr>';
        }
        ?>
        </tbody>
    </table>

</div>

<a href="index.php?controller=Participant&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>