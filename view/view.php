<?php //include_once File::build_path(array('model','ModelErreurExport.php'))?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="./style/material.css">
    <script src="./style/material.min.js"></script>
    <script src="./jQuery/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <link rel="stylesheet" href="./style/materialize.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="./script.js"></script>
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

      <div class="android-header mdl-layout__header mdl-layout__header--waterfall">
        <div class="mdl-layout__header-row">
          <span class="android-title mdl-layout-title watt">WATT AND SEE</span>
          <!-- Add spacer, to align navigation to the right in desktop -->
          <div class="android-header-spacer mdl-layout-spacer"></div>
          <!--<div class="android-search-box mdl-textfield mdl-js-textfield mdl-textfield--expandable mdl-textfield--floating-label mdl-textfield--align-right mdl-textfield--full-width">
            <label class="mdl-button mdl-js-button mdl-button--icon" for="search-field">
              <i class="material-icons">search</i>
            </label>
            <div class="mdl-textfield__expandable-holder">
              <input class="mdl-textfield__input" type="text" id="search-field">
            </div>
          </div>-->
          <!-- Navigation -->
          <div class="android-navigation-container">
            <nav class="android-navigation mdl-navigation">

              <a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php">Accueil</a>
                <?php
                if (isset($_SESSION['login'])) {
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=projet&action=readAll">Projets</a>';
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=sourcefin&action=readAll">Programmes</a>';
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=projet&action=extract">Statistiques</a>';
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=contact&action=readAll">Contacts</a>';
                    
                }
                ?>

                <?php
                if (isset($_SESSION['login']) && $_SESSION['is_admin']) {
                    echo '<a class="mdl-navigation__link" href="index.php?controller=user&action=readAll"><i class="material-icons" role="presentation">face</i></a>';
                }
                ?>
            </nav>
          </div>
          <span class="android-mobile-title mdl-layout-title">
            <span class="android-logo-image">WATT AND SEE</span>
          </span>
          <button class="android-more-button mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect" id="more-button">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right mdl-js-ripple-effect" for="more-button">
            <a href="index.php?controller=user&action=read"><li class="mdl-menu__item">Voir mon profil</li></a>
            <a href="index.php?controller=user&action=deconnect"><li class="mdl-menu__item">Se déconnecter</li></a>
                        <!--<li class="mdl-menu__item"><i class="material-icons">add</i>Add another account...</li>-->
            <li class="mdl-menu__item">Contact</li>
                <a href="https://github.com/sibylleginger/WattAndSee">
                    <li class="mdl-menu__item">Github</li>
                </a>
          </ul>
        </div>
        <?php if ($view=='detail') {
            echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller='.self::$object.'&action=readAll"><i class="material-icons" style="color: black;">arrow_back</i>Retour liste</a>';
        }
        ?>
      </div>

      <div class="android-drawer mdl-layout__drawer">
        <span class="mdl-layout-title">
          WATT AND SEE
        </span>
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php">Accueil</a>
                <?php
                if (isset($_SESSION['login'])) {
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=projet&action=readAll">Projets</a>';
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=sourcefin&action=readAll">Programmes</a>';
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=projet&action=extract">Statistiques</a>';
                    
                }
                ?>

                <?php
                if (isset($_SESSION['login']) && $_SESSION['is_admin']) {
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=user&action=readAll">Utilisateurs</a>';
                }
                ?>  
          <div class="android-drawer-separator"></div>
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