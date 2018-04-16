<?php include_once File::build_path(array('model','ModelErreurExport.php'))?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="./style/material.min.css">
    <script src="./style/material.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <link rel="stylesheet" href="./style/materialize.css">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
    <link rel="stylesheet" href="https://getmdl.io/templates/dashboard/styles.css">
    <link rel="stylesheet" href="./style/styles.css">
    <?php
    if(isset($script)) echo $script;
    ?>
</head>
<body>
<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">WATT AND SEE</span>
            <div class="mdl-layout-spacer"></div>
            <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
                <i class="material-icons">more_vert</i>
            </button>
            <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
                <li class="mdl-menu__item">Contact</li>
                <a href="https://github.com/MFrizzy/GestionHeuresEnseignementIUT">
                    <li class="mdl-menu__item">Github</li>
                </a>
            </ul>
        </div>
    </header>
    <div class="demo-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
        <header class="demo-drawer-header">
            <!--<i class="material-icons demo-avatar">person</i>-->
            <?php if (isset($_SESSION['login'])) echo '
            <div class="demo-avatar-dropdown">
                <span>' . $_SESSION['login'] . '</span>
                <div class="mdl-layout-spacer"></div>
                <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
                    <i class="material-icons" role="presentation">arrow_drop_down</i>
                    <span class="visuallyhidden">Accounts</span>
                </button>
                <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
                    <a href="index.php?controller=user&action=read"><li class="mdl-menu__item">Voir mon profil</li></a>
                    <a href="index.php?controller=user&action=deconnect"><li class="mdl-menu__item">Se déconnecter</li></a>
                    <!--<li class="mdl-menu__item"><i class="material-icons">add</i>Add another account...</li>-->
                </ul>
            </div>';
            ?>
        </header>
        <nav class="demo-navigation mdl-navigation mdl-color--blue-grey-800">
            <a class="mdl-navigation__link" href="index.php"><i class="mdl-color-text--blue-grey-400 material-icons"
                                                                role="presentation">home</i>Accueil</a>
            <?php
            if (isset($_SESSION['login'])) {
                echo '<a class="mdl-navigation__link" href="index.php?controller=projet&action=readAll"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">school</i>Projets</a>';
                echo '<a class="mdl-navigation__link" href="index.php?controller=AAP&action=readAll"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">business</i>Appels à projets</a>';
                echo '<a class="mdl-navigation__link" href="index.php?controller=projet&action=readAll"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>Tableau de bord</a>';
                echo '<a class="mdl-navigation__link" href="index.php?controller=projet&action=extract"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">file_upload</i>Statistiques</a>';
                
            }
            ?>

            <?php
            if (isset($_SESSION['login']) && $_SESSION['is_admin']) {
                echo '<a class="mdl-navigation__link" href="index.php?controller=user&action=readAll"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">face</i>Utilisateurs</a>';
            }
            ?>
            <div class="mdl-layout-spacer"></div>
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons"
                                                       role="presentation">help_outline</i><span class="visuallyhidden">Help</span></a>
        </nav>
    </div>
    <main class="mdl-layout__content mdl-color--grey-100">
        <div class="page-content">
            <?php
            $filepath = File::build_path(array("view", static::$object, "$view.php"));
            require $filepath;
            ?>
        </div>
    </main>
</div>

</body>
</html>