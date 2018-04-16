<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
    <thead>
    <tr>
        <th class="mdl-data-table__cell--non-numeric">Date</th>
        <th class="mdl-data-table__cell--non-numeric">Durée</th>
        <th class="mdl-data-table__cell--non-numeric">Code Module</th>
        <th class="mdl-data-table__cell--non-numeric">Type Activité</th>
        <th class="mdl-data-table__cell--non-numeric">Classe</th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($listCours as $value) {
        $module = $value->getCodeModule();
        echo '      <tr>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getDateCours()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getDuree()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($module->getNomModule()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getTypeCours()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomClasse()) . '</td>
                    </tr>
            ';
    }
    ?>
    </tbody>
</table>

<a href="index.php?controller=enseignant&action=read&codeEns=<?php echo $ens->getCodeEns()  ?>" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">person</i>
    </button>
</a>