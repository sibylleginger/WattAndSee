<form method="post" action="index.php?controller=statutEnseignant&action=<?php echo $_GET['action'] . 'd' ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($statut->getStatut()) ?>"
                       type="text" id="statut" name="statut" required>
                <label class="mdl-textfield__label" for="statut">Statut</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($statut->getTypeStatut()) ?>"
                       type="text" id="typeStatut" name="typeStatut" required>
                <label class="mdl-textfield__label" for="typeStatut">Type Statut</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" pattern="-?[0-9]*(\.[0-9]+)?"
                       value="<?php echo htmlspecialchars($statut->getNombresHeures()) ?>"
                       type="text" id="nombresHeures" name="nombresHeures" required>
                <label class="mdl-textfield__label" for="nombresHeures">Volume horaire</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="codeStatut" value="' . $_GET['codeStatut'] . '">'
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>
