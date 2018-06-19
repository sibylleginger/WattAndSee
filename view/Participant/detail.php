<div class="detailProjet">
    <div class="demo-card-square mdl-card mdl-shadow--2dp projetPres">
        <div class="mdl-card__title mdl-card--expand">
            <h3><?php echo htmlspecialchars($pagetitle) ?></h3>
        </div>
        <div class="mdl-card__supporting-text">
            <?php
            if ($participant->getAffiliation() != null) {
                echo('<b>Affiliation :</b> '.htmlspecialchars($participant->getAffiliation()).'<br>');
            }
            if ($participant->getNomParticipant() != null) {
                echo('<b>Nom :</b> '.htmlspecialchars($participant->getNomParticipant()).'<br>');
            }
            if ($participant->getMailParticipant() != null) {
                echo "<b>Adresse mail :</b> ".htmlspecialchars($participant->getMailParticipant()).'<br>';
            }
            ?>
            <b>Nationalité :</b> <?php echo htmlspecialchars($participant->getNationalite()) ?><br>
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
<a href="index.php?controller=participant&action=create" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
    <i class="material-icons">add</i>
</a>