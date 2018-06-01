<div>
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text">Rechercher un projet</h2>
    </div>
    <div class="mdl-card__supporting-text detailProjet">
        <form method="post" action="index.php?controller=projet&action=searchBy" class="horizontal">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="nomProjet" name="nomProjet">
                <label class="mdl-textfield__label" for="nomProjet">Nom du projet</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="dateDepot" name="dateDepot">
                <label class="mdl-textfield__label" for="dateDepot">Année de dépot</label>
            </div>
            <div>
                <label class="select" for="codeEntite">Entité EDF</label>
                <select style="display: block;" id="codeEntite" name="codeEntite">
                    <option></option>
                    <?php foreach ($tabEntite as $entite) {
                        echo '<option value="' . $entite->getCodeEntite() . '"';
                        echo '>' . $entite->getNomEntite() . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div>
                <label class="select" for="codeTheme">Thème</label>
                <select style="display: block;" id="codeTheme" name="codeTheme">
                    <option></option>
                    <?php foreach ($tabTheme as $theme) {
                        echo '<option value="' . $theme->getCodeTheme() . '"';
                        echo '>' . $theme->getNomTheme() . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div>
                <label class="select" for="statut">Statut du projet</label>
                <select style="display: block;" id="statut" name="statut">
                    <option></option>
                    <option value="Accepté">Accepté</option>
                    <option value="Refusé">Refusé</option>
                    <option value="Déposé">Déposé</option>
                    <option value="En cours de montage">En cours de montage</option>
                </select>
            </div>
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </form>
    </div>
</div>
<?php
if (!$tab) {
    echo '<h4>Il n\'y a pas de projet';
}else {
?>
<div class="page-content">

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Intitulé</th>
            <th class="mdl-data-table__cell--non-numeric">Source de financement</th>
            <th class="mdl-data-table__cell--non-numeric">Statut</th>
            <th class="mdl-data-table__cell--non-numeric">Chef de projet</th>
            <th class="mdl-data-table__cell--non-numeric">Entité</th>
            <th class="mdl-data-table__cell--non-numeric">Modifier</th>
            <th class="mdl-data-table__cell--non-numeric">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            $sourceFin = ModelSourceFin::select($value->getCodeSourceFin());
            $chef = ModelImplication::selectChef($value->getCodeProjet());
            if($chef) $entite = ModelEntite::select($chef->getCodeEntite());
            echo '<tr>
                        <td><a href="index.php?controller=projet&action=read&codeProjet=' . htmlspecialchars($value->getCodeProjet()) . '">'. htmlspecialchars($value->getNomProjet()).'</a></td>
                        <td class="mdl-data-table__cell--non-numeric">';
                        if($sourceFin == false) {
                            echo 'Inconnue';
                        }else {
                            echo '<a href="index.php?controller=sourceFin&action=read&codeSourceFin='.htmlspecialchars($sourceFin->getCodeSourceFin()).'">' .htmlspecialchars($sourceFin->getNomSourceFin()).'</a>';
                        }
                        echo '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getStatut()).'</td>';
                        if (!$chef) {
                            echo '<td class="mdl-data-table__cell--non-numeric">Inconnu</td>
                            <td class="mdl-data-table__cell--non-numeric">Inconnue</td>';
                        }else {
                            echo '<td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=read&codeContact='.htmlspecialchars($chef->getCodeContact()).'">'. htmlspecialchars($chef->getNomContact().' '.$chef->getPrenomContact()).'</a></td>
                            <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=entite&action=read&codeEntite='.htmlspecialchars($entite->getCodeEntite()).'">'.htmlspecialchars($entite->getNomEntite()).'</a></td>';
                        }
                        echo '<td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=projet&action=update&codeProjet=' . htmlspecialchars($value->getCodeProjet()).'"><i class="material-icons">edit</i></a>
                                <a href="index.php?controller=projet&action=updateContacts&codeProjet=' . htmlspecialchars($value->getCodeProjet()).'"><i class="material-icons">people</i></a></td>
                            <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=projet&action=delete&codeProjet=' . htmlspecialchars($value->getCodeProjet()).'"><i class="material-icons">delete</i></a></td>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>
<?php
if ($_GET['action']=='readAll') {
    $before = intval($p)-1;
    $after = intval($p)+1;
    $nav = '<div style="margin: auto; text-align: center; margin-bottom: 15px;">
    <a class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect" href="index.php?controller=projet&action=readAll&p='. $before .'"';
    if ($p <= 1) $nav .= ' disabled';
    $nav .= '><i class="material-icons">navigate_before</i>
    </a>
    <a class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect"
       href="index.php?controller=projet&action=readAll&p='.$after.'"';
    if ($p >= $max) $nav .= ' disabled';
    $nav .= '><i class="material-icons">navigate_next</i>
    </a>
    </div>';
    echo $nav;
}
}
?>
<a href="index.php?controller=projet&action=create">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>