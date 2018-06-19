<form method="post" enctype="multipart/form-data" action="index.php?controller=note&action=<?php echo $_GET['action'] . 'd' ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
        	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($note->getComment()) ?>"
                       type="text" id="comment" name="comment" required>
                <label class="mdl-textfield__label" for="comment">Commentaire</label>
                <span class="mdl-textfield__error">Veuillez rentrer un commentaire</span>
            </div>
            <input type="hidden" name="dateNote" value="<?php echo htmlspecialchars($dateNote) ?>"/>
        	<input type="hidden" name="codeProjet" value="<?php echo $projet->getCodeProjet() ?>"/>
            <input type="hidden" name="mailUser" value="<?php echo htmlspecialchars($user->getMailUser()) ?>"/>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submit" name="upload" value="add">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>
</form>