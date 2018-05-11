<form method="post" action="index.php?controller=uniteDEnseignement&action=<?php echo $_GET['action'] . 'd' ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <label class="select">Diplome</label>
            <select style="display: block;" required name="codeDiplome">
                <?php

                foreach ($departementsXdiplome as $cle => $item) {
                    echo '<optgroup label="' . $cle . '">';
                    foreach ($item as $diplome) {
                        echo '<option value="'.$diplome->getCodeDiplome().'"';
                        if($ue->getCodeDiplome()->getCodeDiplome()==$diplome->getCodeDiplome()) echo ' selected ';
                        echo '>'.$diplome->nommer().'</option>';
                    }
                    echo '</optgroup>';
                }

                ?>
            </select>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($ue->getSemestre()) ?>"
                       type="number" id="semestre" name="semestre" required>
                <label class="mdl-textfield__label" for="semestre">Semestre</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($ue->getIdUE()) ?>"
                       type="number" id="idUE" name="idUE" required>
                <label class="mdl-textfield__label" for="idUE">Numéro d'UE</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($ue->getHeuresTP()) ?>"
                       type="number" id="heuresTP" name="heuresTP" required>
                <label class="mdl-textfield__label" for="heuresTP">Heures de TP à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($ue->getHeuresTD()) ?>"
                       type="number" id="heuresTD" name="heuresTD" required>
                <label class="mdl-textfield__label" for="heuresTD">Heures de TD à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($ue->getHeuresCM()) ?>"
                       type="number" id="heuresCM" name="heuresCM" required>
                <label class="mdl-textfield__label" for="heuresCM">Heures de CM à réaliser</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nombre</span>
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
