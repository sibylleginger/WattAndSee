<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Détails</th>
            <th class="mdl-data-table__cell--non-numeric">Statut</th>
            <th class="mdl-data-table__cell--non-numeric">TypeStatut</th>
            <th class="mdl-data-table__cell--non-numeric">Volume horaire</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($statuts as $value) {
            echo '<tr>
                        <td><a href="index.php?controller=statutEnseignant&action=read&codeStatut=' . htmlspecialchars($value->getCodeStatut()) . '">' . '<i class="material-icons">expand_more</i></a></td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getStatut()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getTypeStatut()).'</td>
                        <td class="mdl-data-table__cell--non-numeric">'.htmlspecialchars($value->getNombresHeures()).'</td>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>

<a href="index.php?controller=statutEnseignant&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>