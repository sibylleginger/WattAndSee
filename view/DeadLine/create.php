<form method="post" enctype="multipart/form-data" action="index.php?controller=deadLine&action=<?php echo $_GET['action'] . 'd&codeProjet='.$projet->getCodeProjet() ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
        	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($deadLine->getNomDeadLine()) ?>"
                       type="text" id="nomDeadLine" name="nomDeadLine" required>
                <label class="mdl-textfield__label" for="nomDeadLine">Nom de l'échéance</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nom</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($deadLine->getDateDeadLine()) ?>"
                       type="date" id="dateDeadLine" name="dateDeadLine" required>
                <label class="mdl-textfield__label" for="dateDeadLine">Date de l'échéance</label>
                <span class="mdl-textfield__error">Veuillez rentrer une date</span>
            </div>
        	<input type="hidden" name="codeProjet" value="<?php echo $projet->getCodeProjet() ?>"/>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submit" name="upload" value="add">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>
</form>