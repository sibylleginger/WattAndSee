<form method="post" action="index.php?controller=uniteDEnseignement&action=<?php echo $_GET['action'] . 'd' ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($Contact->getNomContact()) ?>"
                       type="text" id="nomContact" name="nomContact" required>
                <label class="mdl-textfield__label" for="nomContact">Nom</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nom</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($Contact->getPrenomContact()) ?>"
                       type="text" id="prenomContact" name="prenomContact" required>
                <label class="mdl-textfield__label" for="prenomContact">Prénom</label>
                <span class="mdl-textfield__error">Veuillez rentrer un prénom</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($Contact->getMail()) ?>"
                       type="mail" id="mail" name="mail" required>
                <label class="mdl-textfield__label" for="mail">mail</label>
                <span class="mdl-textfield__error">Veuillez rentrer un mail</span>
            </div>

            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="isEDF">
                <input type="checkbox" id="isEDF" class="mdl-checkbox__input" onchange="majContent()">
                <span class="mdl-checkbox__label">Membre de EDF</span>
            </label>

            <div id="membreEDF">
            <label class="select" for="codeEntite">Entité EDF</label>
            <select style="display: block;" required id="codeEntite" name="codeEntite">
                <?php
                foreach ($tabEntite as $value) {
                    echo '<option value="'.$value->getCodeEntite().'"';
                    if($Contact->getCodeEntite()==$value->getCodeEntite()) echo ' selected ';
                        echo '>'.$entite->getNomEntite().'</option>';
                    echo '</optgroup>';
                }

                ?>
            </select>
            <label class="select" for="codeDepartement">Département EDF R&D</label>
            <select style="display: block;" required id="codeDepartement" name="codeDepartement">
                <?php
                foreach ($tabDepartement as $value) {
                    echo '<option value="'.$value->getCodeEntite().'"';
                    if($Contact->getCodeEntite()==$value->getCodeEntite()) echo ' selected ';
                        echo '>'.$entite->getNomEntite().'</option>';
                    echo '</optgroup>';
                }

                ?>
            </select>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="notMembre">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($Contact->getPrenomContact()) ?>"
                       type="text" id="affiliation" name="affiliation">
                <label class="mdl-textfield__label" for="affiliation">Affiliation</label>
            </div>

            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="nUE" value="' . $_GET['nUE'] . '">'
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>
