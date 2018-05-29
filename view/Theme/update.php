<form method="post" action="index.php?controller=theme&action=<?php echo $_GET['action'] . 'd' ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($theme->getNomTheme()) ?>"
                       type="text" id="nomTheme" name="nomTheme" required>
                <label class="mdl-textfield__label" for="nomTheme">Nom du thème</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nom</span>
            </div>

            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="codeTheme" value="' . $_GET['codeTheme'] . '">'
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>
