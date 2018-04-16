<form method="post" action="index.php?controller=module&action=<?php echo $_GET['action'] . 'd' ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($module->getNUE()->getCodeDiplome()->nommer()) ?>"
                       type="text" id="nomDepartement" name="nomDepartement" disabled>
                <label class="mdl-textfield__label" for="nomDepartement">Diplome</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($module->getNUE()->getSemestre()) ?>"
                       type="number" id="semestre" name="semestre" disabled>
                <label class="mdl-textfield__label" for="semestre">Semestre</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($module->getNUE()->getIdUE()) ?>"
                       type="text" id="idUE" name="idUE" disabled>
                <label class="mdl-textfield__label" for="idUE">Numéro d'unité d'enseignement</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($module->getNumModule()) ?>"
                       type="number" id="numModule" name="numModule" required>
                <label class="mdl-textfield__label" for="numModule">Numéro du module</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($module->getNomModule()) ?>"
                       type="text" id="nomModule" name="nomModule" required>
                <label class="mdl-textfield__label" for="nomModule">Nom du module</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($module->getHeuresTP()) ?>"
                       type="number" id="heuresTP" name="heuresTP" required>
                <label class="mdl-textfield__label" for="heuresTP">Heures de TP à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($module->getHeuresTD()) ?>"
                       type="number" id="heuresTD" name="heuresTD" required>
                <label class="mdl-textfield__label" for="heuresTD">Heures de TD à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($module->getHeuresCM()) ?>"
                       type="number" id="heuresCM" name="heuresCM" required>
                <label class="mdl-textfield__label" for="heuresCM">Heures de CM à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="codeModule" value="' . $_GET['codeModule'] . '">';
            if ($_GET['action'] == 'create') echo '<input type="hidden" name="nUE" value="' . $_GET['nUE'] . '">';
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>

