<form method="post" enctype="multipart/form-data" action="index.php?controller=document&action=<?php echo $_GET['action'] . 'd' ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            <input class="mdl-textfield__input" type="file" id="namePJ" name="namePJ" required>
            <label for="namePJ">Ajouter un document</label>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($document->getTitre()) ?>"
                       type="text" id="titre" name="titre" required>
                <label class="mdl-textfield__label" for="nomContact">Titre</label>
                <span class="mdl-textfield__error">Veuillez rentrer un titre</span>
            </div>
        	<input type="hidden" name="codeProjet" value="<?php echo $projet->getCodeProjet() ?>"/>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submit" name="upload" value="add">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>
</form>