<form method="post" action="index.php?controller=projet&action=<?php echo $_GET['action'] . 'd' ?>">
    <div style="margin: auto; display: flex; align-items: flex-start;">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($projet->getNomProjet()) ?>"
                       type="text" id="nom" name="nom" required>
                <label class="mdl-textfield__label" for="nom">Nom du projet</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nom</span>
            </div>
            <br>
            <label class="select" for="statut">Statut</label>
            <select style="display: block;" required name="statut" id="statut">
                <option value="Accepté" <?php if ($projet->getStatut()=='Accepté') echo "selected "?> >Accepté</option>';
                <option value="Refusé" <?php if ($projet->getStatut()=='Refusé') echo "selected "?> >Refusé</option>';
                <option value="Déposé" <?php if ($projet->getStatut()=='Déposé') echo "selected "?> >Déposé</option>';
                <option value="En attente" <?php if ($projet->getStatut()=='En attente') echo "selected "?> >En attente</option>';
            </select>

            <label class="select" for="financement">Programme de financement</label>
            <select style="display: block;" required name="financement" id="financement">
                <option value=""></option>
                <?php 
                    foreach ($tabSource as $source) {
                        echo '<option value="'.$source->getCodeSourceFin().'"';
                        if ($projet->getCodeSourceFin()!=null && $projet->getCodeSourceFin()==$source->getCodeSourceFin()) {
                            echo ' selected';
                        }
                        echo '>'.$source->getNomSourceFin().'</option>';
                    }
                ?>
            </select>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($projet->getDateDepot()) ?>"
                       type="date" id="dateDepot" name="dateDepot" required>
                <label class="mdl-textfield__label" for="dateDepot">Date de dépot du dossier</label>
                <span class="mdl-textfield__error">Veuillez rentrer une date de dépot valide</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($projet->getDateReponse()) ?>"
                       type="date" id="dateReponse" name="dateReponse">
                <label class="mdl-textfield__label" for="dateReponse">Date de réponse</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <textarea class="mdl-textfield__input" name="description" id="description" cols="250" rows="5" required><?php echo htmlspecialchars($projet->getDescription()) ?></textarea>
                <label class="mdl-textfield__label" for="description">Description</label>
                <span class="mdl-textfield__error">Veuillez rentrer une description</span>
            </div>
            <br>
            <label class="select" for="theme">Thème</label>
            <a href="index.php?controller=theme&action=create" class="addNew">
                <i class="material-icons">add</i>
            </a>
            <select style="display: block;" required name="theme" id="theme">
                <option value=""></option>
                <?php 
                    foreach ($tabTheme as $theme) {
                        echo '<option value="'.$theme->getCodeTheme().'"';
                        if ($projet->getCodeTheme()==$theme->getCodeTheme()) {
                            echo ' selected';
                        }
                        echo '>'.$theme->getNomTheme().'</option>';
                    }
                //ADD NEW
                ?>
            </select>

            <label class="select" for="role">Role de EDF dans le projet</label>
            <select style="display: block;" required name="role" id="role" value="<?php echo $projet->getRole() ?>">
                <option value="Partenaire" <?php if ($projet->getRole()=='Partenaire') echo "selected "?> >Partenaire</option>';
                <option value="Coordinateur" <?php if ($projet->getRole()=='Coordinateur') echo "selected "?> >Coordinateur</option>';
            </select>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" value="<?php echo htmlspecialchars($projet->getBudgetTotal()) ?>" type="number" id="budgetTotal" name="budgetTotal">
                <label class="mdl-textfield__label" for="budgetTotal">Budget total du projet</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" value="<?php echo htmlspecialchars($projet->getBudgetEDF()) ?>" type="number" id="budgetEDF" name="budgetEDF">
                <label class="mdl-textfield__label" for="budgetEDF">Budget EDF du projet</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" value="<?php echo htmlspecialchars($projet->getSubventionTotal()) ?>" type="number" id="subventionTotal" name="subventionTotal">
                <label class="mdl-textfield__label" for="subventionTotal">Subvention totale du projet</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" value="<?php echo htmlspecialchars($projet->getSubventionEDF()) ?>" type="number" id="subventionEDF" name="subventionEDF">
                <label class="mdl-textfield__label" for="subventionEDF">Subvention EDF du projet</label>
            </div>
            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="isExceptionnel">
                <input type="checkbox" name="isExceptionnel" id="isExceptionnel" value="1" class="mdl-checkbox__input">
                <span class="mdl-checkbox__label">Projet exceptionnel</span>
            </label>

            <!--<label class="mdl-textfield__label" for="contactEDF">Contacts EDF</label>
            <a href="index.php?controller=theme&action=create" class="addNew">
            <button class="mdl-button mdl-js-button mdl-button-raised mdl-button--colored addNew">
                <i class="material-icons">add</i>
            </button>
            </a>-->


            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="codeProjet" value="' . $_GET['codeProjet'] . '">'
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>
