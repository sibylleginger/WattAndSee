<script type="text/javascript">
    $(function() {
        var membreEDF = $('#membreEDF');
        var isRD = $('#isRD');
        var isEDF = $('#isEDF');
        var notMembre = $('#notMembre');
        var selectEntite = $('#codeEntite');
        var selectedOption = $('#codeEntite option:selected').val();
        isRD.hide();
        if(isEDF.is(':checked')) {
            notMembre.hide();
            membreEDF.show();
            if(selectedOption == 15) {
                isRD.css("display", "block");
            } else {
                isRD.css("display", "none");
            }
        } else {
            isRD.hide();
            membreEDF.hide();
            notMembre.show();
        }
        isEDF.click(function() {
            if(isEDF.is(':checked')) {
                notMembre.hide();
                membreEDF.show();
                var selectedOption = $('#codeEntite option:selected').val();
                if(selectedOption == 15) {
                    isRD.show();
                } else {
                    isRD.hide();
                }
            } else {
                isRD.hide();
                membreEDF.hide();
                notMembre.show();
            }
        });
        selectEntite.change(function() {
            if(selectEntite.val() == 15) {
                isRD.show();
            } else {
                isRD.hide();
            }
        });
    });
</script>
<form method="post" action="index.php?controller=contact&action=<?php echo $_GET['action'] . 'd';
    if(isset($_GET['codeSourceFin'])) echo '&codeSourceFin='.$codeSourceFin;
    elseif(isset($_GET['codeProjet'])) echo '&codeProjet='.$codeProjet ?>">

    <div class="mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($contact->getNomContact()) ?>"
                       type="text" id="nomContact" name="nomContact" required>
                <label class="mdl-textfield__label" for="nomContact">Nom</label>
                <span class="mdl-textfield__error">Veuillez rentrer un nom</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($contact->getPrenomContact()) ?>"
                       type="text" id="prenomContact" name="prenomContact" required>
                <label class="mdl-textfield__label" for="prenomContact">Prénom</label>
                <span class="mdl-textfield__error">Veuillez rentrer un prénom</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($contact->getMail()) ?>"
                       type="mail" id="mail" name="mail">
                <label class="mdl-textfield__label" for="mail">mail</label>

            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($contact->getTelephone()) ?>"
                       type="number" id="telephone" name="telephone">
                <label class="mdl-textfield__label" for="telephone">Numéro de téléphone</label>

            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($contact->getAffiliation()) ?>"
                       type="text" id="affiliation" name="affiliation">
                <label class="mdl-textfield__label" for="affiliation">Affiliation</label>
            </div>

            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="isEDF">
                <input type="checkbox" id="isEDF" class="mdl-checkbox__input" <?php if($contact->getCodeSourceFin() == null && !isset($_GET['codeSourceFin'])) echo 'checked' ?> >
                <span class="mdl-checkbox__label">Membre de EDF</span>
            </label>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="notMembre">
                <label class="select" for="codeSourceFin">Programme de financement</label>
                <select  id="codeSourceFin" name="codeSourceFin">
                    <option value=""></option>
                    <?php
                    foreach ($tabSourceFin as $value) {
                        echo '<option value="'. $value->getCodeSourceFin().'" ';
                        if ($value->getCodeSourceFin() == $contact->getCodeSourceFin() || (isset($_GET['codeSourceFin']) && $value->getCodeSourceFin() == $_GET['codeSourceFin'])) {
                            echo 'selected';
                        }
                        echo '>'.htmlspecialchars($value->getNomSourceFin()).'</option>';
                    }

                    ?>
                </select>
            </div>

            <div id="membreEDF">
            <label class="select" for="codeEntite">Entité EDF</label>
            <select id="codeEntite" name="codeEntite">
                <option value=""></option>
                <?php
                foreach ($tabEntite as $value) {
                    echo '<option value="'. $value->getCodeEntite().'" ';
                        if ($value->getCodeEntite() == $contact->getCodeEntite()) {
                            echo 'selected';
                        }
                    echo '>'.htmlspecialchars($value->getNomEntite()).'</option>';
                }

                ?>
            </select>
            </div>
            <div id="isRD">
            <label class="select" for="codeDepartement">Département EDF</label>
            <select id="codeDepartement" name="codeDepartement">
                <option value=""></option>
                <?php
                foreach ($tabDepartement as $value) {
                    echo '<option value="'.$value->getCodeDepartement().'" ';
                        if ($value->getCodeDepartement() == $contact->getCodeDepartement()) {
                            echo 'selected';
                        }
                    echo '>'.$value->getNomDepartement().'</option>';
                }

                ?>
            </select>
            </div>

            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="codeContact" value="' . $_GET['codeContact'] . '">';
            if (isset($_GET['codeProjet'])) {
                echo '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chefProjet">
                        <input type="checkbox" id="chefProjet" name="chefProjet" value="1" class="mdl-checkbox__input">
                        <span class="mdl-checkbox__label" for="chefProjet">Chef du projet</span>
                    </label><br>';
            }
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>
