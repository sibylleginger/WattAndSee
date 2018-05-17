<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Nom</th>
            <th class="mdl-data-table__cell--non-numeric">Prénom</th>
            <th class="mdl-data-table__cell--non-numeric">Mail</th>
            <th class="mdl-data-table__cell--non-numeric">Modifier</th>
            <th class="mdl-data-table__cell--non-numeric">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            if ($value->getcodeEntite() != null) {
                echo '<tr style="backgroung-color: orange;">';
            } else {
                echo '<tr>';
            }
            echo '<td><a href="index.php?controller=contact&action=read&codeContact=' . htmlspecialchars($value->getCodeContact()) . '">' . htmlspecialchars($value->getNomContact()).'</a></td>
                    <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getPrenomContact()) . '</td>
                    <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getMail()) . '</td>
                    <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=update&codeContact=' . htmlspecialchars($value->getCodeContact()) . '"><i class="material-icons">mode_edit</i></a></td>
                    <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=contact&action=delete&codeContact=' . htmlspecialchars($value->getCodeContact()) . '"><i class="material-icons">delete</i></a></td>
                </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>

<a href="index.php?controller=contact&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>