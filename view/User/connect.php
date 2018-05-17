<form method="post" action="index.php?controller=user&action=connected">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Connexion</h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="text_input">
                <i class="material-icons">person</i>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input"
                           value="<?php if (isset($_COOKIE['login'])) echo htmlspecialchars($_COOKIE['login']) ?>"
                           type="email" id="login" name="login" required>
                    <label class="mdl-textfield__label" for="login">E-mail</label>
                </div>
            </div>

            <div class="text_input">
                <i class="material-icons">lock</i>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" value="" type="password" id="mdp" name="mdp" required>
                    <label class="mdl-textfield__label" for="mdp">Mot de passe</label>
                </div>
            </div>

            <div class="save">
                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="switch-1">
                    <input type="checkbox" id="switch-1" name="save" class="mdl-switch__input" checked>
                    <span class="mdl-switch__label">Enregistrer son e-mail</span>
                </label>
            </div>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'connected') {
    echo '<div class="snackbar">
    <div class="snackbar__text">Mauvais mot de passe</div>
</div>';
}
?>