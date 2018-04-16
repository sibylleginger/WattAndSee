<form method="post" action="index.php?controller=diplome&action=<?php echo $_GET['action'] . 'd' ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <label class="select">Département</label>
            <select style="display: block;" required name="codeDepartement">
                <?php foreach ($departements as $departement) {
                    echo '<option value="' . $departement->getCodeDepartement().'"';
                    if($diplome->getCodeDepartement() == $departement) echo ' selected';
                    echo '>' . $departement->getNomDepartement() . '</option>';
                }
                ?>
            </select>
            <br>
            <label class="select">Type diplome</label>
            <select style="display: block;" required name="typeDiplome">
                <option value="D" <?php if($diplome->getLettreTypeDiplome()=='D') echo ' selected' ?>>DUT</option>
                <option value="P" <?php if($diplome->getLettreTypeDiplome()=='P') echo ' selected' ?>>License Pro</option>
                <option value="U" <?php if($diplome->getLettreTypeDiplome()=='U') echo ' selected' ?>>DU</option>
                <option value="A" <?php if($diplome->getLettreTypeDiplome()=='A') echo ' selected' ?>>Année Spéciale</option>
            </select>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($diplome->getNumLP()) ?>"
                       type="text" id="numLP" name="numLP">
                <label class="mdl-textfield__label" for="numLP">Numéro de la License Pro (facultatif)</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($diplome->getNomDiplome()) ?>"
                       type="text" id="nomDiplome" name="nomDiplome">
                <label class="mdl-textfield__label" for="nomDiplome">Nom Diplome (facultatif)</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($diplome->getHeuresTP()) ?>"
                       type="number" id="heuresTP" name="heuresTP" required>
                <label class="mdl-textfield__label" for="heuresTP">Heures de TP à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($diplome->getHeuresTD()) ?>"
                       type="number" id="heuresTD" name="heuresTD" required>
                <label class="mdl-textfield__label" for="heuresTD">Heures de TD à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($diplome->getHeuresCM()) ?>"
                       type="number" id="heuresCM" name="heuresCM" required>
                <label class="mdl-textfield__label" for="heuresCM">Heures de CM à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($diplome->getHeuresStage()) ?>"
                       type="number" id="heuresStage" name="heuresStage" required>
                <label class="mdl-textfield__label" for="heuresStage">Heures de Stage à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($diplome->getHeuresProjet()) ?>"
                       type="number" id="heuresProjet" name="heuresProjet" required>
                <label class="mdl-textfield__label" for="heuresProjet">Heures de Projet à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="codeDiplome" value="' . $_GET['codeDiplome'] . '">'
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>

