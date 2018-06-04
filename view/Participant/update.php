<form method="post" action="index.php?controller=participant&action=<?php echo $_GET['action'] . 'd';
    if(isset($_GET['codeProjet'])) echo '&codeProjet='.$_GET['codeProjet'] ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($participant->getAffiliation()) ?>"
                       type="text" id="affiliation" name="affiliation" required>
                <label class="mdl-textfield__label" for="affiliation">Affiliation</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($participant->getNomParticipant()) ?>"
                       type="text" id="nomParticipant" name="nomParticipant">
                <label class="mdl-textfield__label" for="nomParticipant">Nom</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nom</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($participant->getNationalite()) ?>"
                       type="text" id="nationalite" name="nationalite">
                <label class="mdl-textfield__label" for="nationalite">Nationalité</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($participant->getMailParticipant()) ?>"
                       type="mailParticipant" id="mailParticipant" name="mailParticipant">
                <label class="mdl-textfield__label" for="mail">Mail</label>

            </div>

            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="codeParticipant" value="' . $_GET['codeParticipant'] . '">';
            if (isset($_GET['codeProjet'])) {
                echo '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="coordinateur">
                        <input type="checkbox" id="coordinateur" name="coordinateur" value="1" class="mdl-checkbox__input"';
                if ($participant->isCoordinateur($_GET['codeProjet'])) {
                    echo 'checked';
                }
                echo '>
                        <span class="mdl-checkbox__label" for="coordinateur">Coordinateur du consortium</span>
                    </label>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="number" value="'.$participation->getBudget(). '" id="budget" name="budget">
                        <label class="mdl-textfield__label" for="budget">Budget</label>
                    </div>';
            }
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>
