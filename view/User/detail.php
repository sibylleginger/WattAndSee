<div class="mdl-card mdl-shadow--2dp import">
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text">Informations du compte</h2>
    </div>
    <div class="mdl-card__supporting-text">
        <div class="detail taille">
            <ul class="mdl-list">
                <li class="mdl-list__item">
                <span class="mdl-list__item-primary-content">
                    <i class="material-icons mdl-list__item-icon">email</i>
                    <?php echo htmlspecialchars($user->getMailUser()) ?>
                </span>
                </li>
                <?php if ($user->getAdmin()) echo '
            <li class="mdl-list__item">
                <span class="mdl-list__item-primary-content">
                    <i class="material-icons mdl-list__item-icon">supervisor_account</i>
                    Admin
                </span>
            </li>';
                ?>
            </ul>
        </div>
    </div>
    <div class="mdl-card__actions mdl-card--border">
        <a href="index.php?controller=user&action=update&mailUser=<?php echo htmlspecialchars($user->getMailUser()) ?>"
           class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
            Modifier mes informations
        </a>
        <a href="index.php?controller=user&action=delete&mailUser=<?php echo htmlspecialchars($user->getMailUser()) ?>"
           class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
            Supprimer mon compte
        </a>
    </div>
</div>


<?php
if ($_GET['action'] == 'connected') {
    echo '<div class="snackbar">
    <div class="snackbar__text">Bienvenue</div>
</div>';
}
?>

