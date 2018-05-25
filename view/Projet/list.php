<div class="detailBatiment1" style="justify-content: center;">
    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Rechercher un projet</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <form method="post" action="index.php?controller=projet&action=searchBy">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="codeProjet" name="codeProjet">
                    <label class="mdl-textfield__label" for="codeProjet">Acronyme</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="nomProjet" name="nomProjet">
                    <label class="mdl-textfield__label" for="nomProjet">Nom du projet</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="dateDepot" name="dateDepot">
                    <label class="mdl-textfield__label" for="dateDepot">Année de dépot</label>
                </div>
                <label class="select" for="codeEntite">Entité EDF</label>
                <select style="display: block;" id="codeEntite" name="codeEntite">
                    <option></option>
                    <?php foreach ($tabEntite as $entite) {
                        echo '<option value="' . $entite->getCodeEntite() . '"';
                        echo '>' . $entite->getNomEntite() . '</option>';
                    }
                    ?>
                </select>
                <label class="select" for="codeTheme">Thème</label>
                <select style="display: block;" id="codeTheme" name="codeTheme">
                    <option></option>
                    <?php foreach ($tabTheme as $theme) {
                        echo '<option value="' . $theme->getCodeTheme() . '"';
                        echo '>' . $theme->getNomTheme() . '</option>';
                    }
                    ?>
                </select>
                <label class="select" for="statut">Statut du projet</label>
                <select style="display: block;" id="statut" name="statut">
                    <option></option>
                    <option value="Accepté">Accepté</option>
                    <option value="Refusé">Refusé</option>
                    <option value="Déposé">Déposé</option>
                    <option value="En cours de montage">En cours de montage</option>
                </select>
                <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                    <i class="material-icons">send</i>
                </button>
            </form>
        </div>
    </div>
</div>
<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Intitulé</th>
            <th class="mdl-data-table__cell--non-numeric">Source de financement</th>
            <th class="mdl-data-table__cell--non-numeric">Statut</th>
            <th class="mdl-data-table__cell--non-numeric">Modifier</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            $sourceFin = ModelSourceFin::select($value->getCodeSourceFin());

            echo '<tr>
                        <td><a href="index.php?controller=projet&action=read&codeProjet=' . htmlspecialchars($value->getCodeProjet()) . '">'. htmlspecialchars($value->getNomProjet()).'</a></td>
                        <td class="mdl-data-table__cell--non-numeric">'; if($sourceFin == false) {
                            echo 'Inconnue';
                        }else {
                            echo htmlspecialchars($sourceFin->getNomSourceFin());
                        }
                        echo '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getStatut()).'</td>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=projet&action=update&codeProjet=' . htmlspecialchars($value->getCodeProjet()).'"><i class="material-icons">edit</i></a></td>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>

<!--
<a href="index.php?controller=departement&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>

-->
<a href="index.php?controller=projet&action=create" class="new">
    <button id="demo-menu-top-right"
            class="mdl-button mdl-js-button mdl-button--fab">
        <i class="material-icons">add</i>
    </button>

    <!--<ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect"
        for="demo-menu-top-right">
        <a href="index.php?controller=departement&action=create"><li class="mdl-menu__item">Ajouter un nouveau projet</li></a>
        <a href="index.php?controller=diplome&action=create"><li class="mdl-menu__item">Créer un diplome</li></a>
        <a href="index.php?controller=uniteDEnseignement&action=create"><li class="mdl-menu__item">Créer une unité d'enseignement</li></a>
    </ul>-->
</a>