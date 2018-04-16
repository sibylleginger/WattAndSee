<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
    <thead>
    <tr>
        <th>Details</th>
        <th class="mdl-data-table__cell--non-numeric">Code Enseignant</th>
        <th class="mdl-data-table__cell--non-numeric">Nom</th>
        <th class="mdl-data-table__cell--non-numeric">Département</th>
        <th class="mdl-data-table__cell--non-numeric">Statut 1</th>
        <th class="mdl-data-table__cell--non-numeric">Statut 2</th>
        <th class="mdl-data-table__cell--non-numeric">Etat service</th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($tab as $value) {
        $statut = $value->getCodeStatut();
        echo '<tr>
                        <td><a href="index.php?controller=enseignant&action=read&codeEns=' . htmlspecialchars($value->getCodeEns()) . '">' . '<i class="material-icons">expand_more</i></a></td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getCodeEns()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomEns()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getCodeDepartement()->getNomDepartement()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($statut->getStatut()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($statut->getTypeStatut()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getEtatService()) . '</td>
                    </tr>
            ';
    }
    ?>
    </tbody>
</table>

<a href="index.php?controller=enseignant&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>