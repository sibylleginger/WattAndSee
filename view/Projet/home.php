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
                </select>
                <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                    <i class="material-icons">send</i>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="mdl-card mdl-shadow--2dp" style="width: 500px; margin: 0px 15px 15px 15px">
    <div class="mdl-card__title">
        <h2 class="mdl-card__title-text">Répartitions des enseignants par statut</h2>
    </div>
    <div class="mdl-card__supporting-text mdl-card--border">
        <div id="statut" style="width: 500px; height: 250px;"></div>
    </div>
</div>

<a href="index.php?controller=enseignant&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>


