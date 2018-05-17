<?php
$action = $_GET['action'] . 'd';
?>

<form method="post" action="index.php?controller=user&action=<?php echo $action; ?>">

    <div class="mdl-card mdl-shadow--2dp import userupdate">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php
                if ($_GET['action'] == 'create')
                    echo 'Création d\'un nouvel utilisateur ';
                else {
                    echo 'Modification du profil';
                }
                ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="text_input">
                <i class="material-icons">mail</i>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" value="<?php echo htmlspecialchars($p->getMailUser()) ?>"
                           type="email" id="mailUser" name="mailUser" required>
                    <label class="mdl-textfield__label" for="mailUser">E-mail</label>
                </div>
            </div>
            <div class="text_input">
                <i class="material-icons">lock</i>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="password" id="passwordUser" name="passwordUser" required>
                    <label class="mdl-textfield__label" for="passwordUser">Mot de passe</label>
                </div>
            </div>
            <div class="text_input">
                <i class="material-icons">lock</i>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="password" id="passwordUser2" name="passwordUser2"
                           required>
                    <label class="mdl-textfield__label" for="passwordUser2">Répéter votre mot de passe</label>
                </div>
            </div>

            <input name="ancienMail" type="hidden" value="<?php echo $p->getMailUser() ?>">

            <?php
            if ($_GET['action'] == 'create') {
                $bouton = "add";
            } else {
                $bouton = "send";
            }
            ?>
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons"><?php echo $bouton; ?></i>
            </button>

        </div>
    </div>

</form>