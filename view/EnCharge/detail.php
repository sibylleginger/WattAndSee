<div class="detailBatiment1">
    <div class="mdl-card mdl-shadow--2dp detailBatiment2">
        <div class="mdl-card__title">
            <h2 class="mdl-card__title-text"><?php echo $pagetitle ?></h2>
        </div>
        <div class="mdl-card__supporting-text">
            Diplome : <?php echo $module->getNUE()->getCodeDiplome()->nommer() ?><br>
            Semestre : <?php echo $module->getNUE()->getSemestre() ?><br>
            UE : <?php echo $module->getNUE()->nommer() ?>
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp detailBatiment3">
                <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Types d'heures</th>
                    <th class="mdl-data-table__cell--non-numeric">Volume horaire</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">TD</td>
                    <td><?php echo htmlspecialchars($module->getHeuresTD()) ?></td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">TP</td>
                    <td><?php echo htmlspecialchars($module->getHeuresTP()) ?></td>
                </tr>
                <tr>
                    <td class="mdl-data-table__cell--non-numeric">Cours Magistraux</td>
                    <td><?php echo htmlspecialchars($module->getHeuresCM()) ?></td>
                </tr>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Total</th>
                    <th><?php echo htmlspecialchars($module->getVolumeHoraire()) ?></th>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="mdl-card__menu">
            <a href="index.php?controller=module&action=update&codeModule=<?php echo htmlspecialchars($module->getCodeModule()) ?>">
                <button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect">
                    <i class="material-icons">edit</i>
                </button>
            </a>
        </div>
    </div>

</div>
