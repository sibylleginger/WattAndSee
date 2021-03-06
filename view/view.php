<?php //include_once File::build_path(array('model','ModelErreurExport.php'))?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $pagetitle; ?></title>
    <script src="./style/material.min.js"></script>
    <script src="./jQuery/jquery-3.3.1.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <link rel="stylesheet" href='https://www.amcharts.com/lib/3/plugins/export/export.css' type='text/css' media='all'/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <link rel="stylesheet" href="./style/materialize.css">
    <link rel="stylesheet" href="./style/material.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="./jQuery/script.js"></script>
    <link rel="stylesheet" href="./style/style.css">
    <?php
    if(isset($script)) echo $script;
    ?>
</head>
<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

      <div class="android-header mdl-layout__header mdl-layout__header--waterfall">
        <div class="mdl-layout__header-row">
          <a href="index.php" class="android-title mdl-layout-title watt">WATT AND SEE</a>
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

                <?php
                if (isset($_SESSION['login'])) {
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=projet&action=readAll&p=1">Projets</a>';
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=sourcefin&action=readAll">Programmes</a>';
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=projet&action=stats">Statistiques</a>';
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=deadLine&action=readAll">Calendrier</a>';
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=contact&action=readAll">Contacts</a>';
                    
                }else {
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=user&action=connect">Se connecter</a>';
                }
                ?>
                <button class="android-more-button mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect" id="contact-button">
                    <i class="material-icons">face</i>
                </button>
                <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right mdl-js-ripple-effect" for="contact-button">
                    <li class="mdl-menu__item"><a href="index.php?controller=contact&action=readAll">Tous les contacts</a></li>
                    <li class="mdl-menu__item"><a href="index.php?controller=participant&action=readAll">Tous les participants</a></li>
                    <?php
                    if (isset($_SESSION['login']) && $_SESSION['is_admin']) {
                        echo '<li class="mdl-menu__item"><a href="index.php?controller=user&action=readAll">Tous les utilisateurs</a></li>';
                    } ?>
                </ul>';
            </nav>
          </div>
          <span class="android-mobile-title mdl-layout-title">
            <a href="index.php" class="android-logo-image">WATT AND SEE</a>
          </span>
          <button class="android-more-button mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect" id="more-button">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right mdl-js-ripple-effect" for="more-button">
            <li class="mdl-menu__item"><a href="index.php?controller=user&action=read">Voir mon profil</a></li>
            <li class="mdl-menu__item"><a href="index.php?controller=user&action=deconnect">Se déconnecter</a></li>
            <li class="mdl-menu__item"><a href="mailto:rouxsibylle@gmail.com">Contact</a></li>
            <li class="mdl-menu__item"><a href="https://github.com/sibylleginger/WattAndSee">Github</a></li>
          </ul>
        </div>
        <?php if ($view=='detail') {
            echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller='.self::$object.'&action=readAll"><i class="material-icons" style="color: black;">arrow_back</i>Voir liste</a>';
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
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=projet&action=stats">Statistiques</a>';
                    echo '<a class="mdl-navigation__link mdl-typography--text-uppercase" href="index.php?controller=deadLine&action=readAll">Calendrier</a>';
                    
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
            $filepath = File::build_path(array("view",ucfirst(static::$object), "$view.php"));
            require_once $filepath;
            ?>
        </div>
    </main>
</div>

</body>
</html>	