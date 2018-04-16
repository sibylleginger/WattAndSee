<form method="post" action="index.php?controller=enseignant&action=<?php echo $_GET['action'] . 'd' ?>">

    <div class="mdl-card mdl-shadow--2dp import">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">


            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($ens->getCodeEns()) ?>"
                       type="text" id="codeEns" name="codeEns"
                       required <?php if ($_GET['action'] == 'update') echo 'disabled' ?>>
                <label class="mdl-textfield__label" for="codeEns">Code Enseignant</label>
            </div>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input"
                       value="<?php echo htmlspecialchars($ens->getNomEns()) ?>"
                       type="text" id="nomEns" name="nomEns" required>
                <label class="mdl-textfield__label" for="nomEns">Nom</label>
            </div>

            <label class="select">Département</label>
            <select style="display: block;" required name="codeDepartement">
                <?php foreach ($departements as $departement) {
                    echo '<option value"' . $departement->getCodeDepartement().'"';
                    if($ens->getCodeDepartement() == $departement) echo ' selected';
                    echo '>' . $departement->getNomDepartement() . '</option>';
                }
                ?>
            </select>

            <label class="select">Statut</label>
            <select style="display: block;" required name="codeStatut">
                <?php
                foreach ($statuts as $statut) {
                    echo '<option value="' . $statut->getCodeStatut() . '"' ;
                    if($ens->getCodeStatut() == $statut) echo ' selected';
                    echo '>'. $statut->getStatut() . " " . $statut->getTypeStatut() . '</option>';
                }
                ?>
            </select>

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <textarea class="mdl-textfield__input"
                          value="<?php echo htmlspecialchars($ens->getRemarque()) ?>"
                          type="text" id="remarque" name="remarque" rows="5"></textarea>
                <label class="mdl-textfield__label" for="remarque">Remarque</label>
            </div>

            <?php
            if ($_GET['action'] == 'update') echo '<input type="hidden" name="codeEns" value="' . $_GET['codeEns'] . '">'
            ?>
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect bouton" type="submits">
                <i class="material-icons">send</i>
            </button>
        </div>
    </div>

</form>

<?php
if (isset($_GET['action']) && $_GET['action'] == 'connected') {
    echo '<div class="snackbar">
    <div class="snackbar__text">Mauvais mot de passe</div>
</div>';
}
?>

