<form method="post" action="index.php?controller=departement&action=<?php echo $_GET['action'] . 'd' ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($dep->getCodeDepartement()) ?>"
                       type="text" id="codeDepartement" name="codeDepartement"
                       required <?php if ($_GET['action'] == 'update') echo 'disabled' ?>>
                <label class="mdl-textfield__label" for="codeDepartement">Code du département</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($dep->getNomDepartement()) ?>"
                       type="text" id="nomDepartement" name="nomDepartement" required>
                <label class="mdl-textfield__label" for="nomDepartement">Nom</label>
            </div>

            <label class="select" for="nomBatiment">Batiment</label>
            <select style="display: block;" required name="nomBatiment" id="nomBatiment">
                <?php foreach ($batiments as $batiment) {
                    echo '<option value"' . $batiment->getnomBatiment().'"';
                    if($dep->getnomBatiment() == $batiment) echo ' selected';
                    echo '>' . $batiment->getnomBatiment() . '</option>';
                }
                ?>
            </select>

            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="codeDepartement" value="' . $_GET['codeDepartement'] . '">'
            ?>

            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>

