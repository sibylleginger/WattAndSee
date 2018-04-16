<form method="post" action="index.php?controller=extraction&action=updated">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($erreur->getNomEns()) ?>"
                       type="text" id="nomEns" name="nomEns" required>
                <label class="mdl-textfield__label" for="nomEns">Nom Enseignant</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($erreur->getCodeEns()) ?>"
                       type="text" id="codeEns" name="codeEns" required>
                <label class="mdl-textfield__label" for="codeEns">Code Enseignant</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($erreur->getDepartementEns()) ?>"
                       type="text" id="departementEns" name="departementEns" required>
                <label class="mdl-textfield__label" for="departementEns">Departement Enseignant</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($erreur->getStatut()) ?>"
                       type="text" id="statut" name="statut" required>
                <label class="mdl-textfield__label" for="statut">Statut Enseignant</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($erreur->getTypeStatut()) ?>"
                       type="text" id="typeStatut" name="typeStatut" required>
                <label class="mdl-textfield__label" for="typeStatut">Type Statut Enseignant</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($erreur->getDateCours()) ?>"
                       type="text" id="dateCours" name="dateCours" required>
                <label class="mdl-textfield__label" for="dateCours">Date Cours</label>
            </div>


            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($erreur->getDuree()) ?>"
                       type="number" id="duree" name="duree" required>
                <label class="mdl-textfield__label" for="duree">Durée</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($erreur->getActivitee()) ?>"
                       type="text" id="activitee" name="activitee" required>
                <label class="mdl-textfield__label" for="activitee">Code Activité</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($erreur->getTypeActivitee()) ?>"
                       type="text" id="typeActivitee" name="typeActivitee" required>
                <label class="mdl-textfield__label" for="typeActivitee">Type Activité</label>
            </div>

            <?php
            echo '<input type="hidden" name="idErreur" value="' . $_GET['idErreur'] . '">';
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>

