<div>

    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Nom</th>
            <th class="mdl-data-table__cell--non-numeric">Mail</th>
            <th class="mdl-data-table__cell--non-numeric">Nationalité</th>
            <th class="mdl-data-table__cell--non-numeric">Affiliation</th>
            <th class="mdl-data-table__cell--non-numeric">Modifier</th>
            <th class="mdl-data-table__cell--non-numeric">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($tab as $value) {
            echo '<tr>
                <td><a href="index.php?controller=participant&action=read&codeParticipant=' . htmlspecialchars($value->getCodeParticipant()) . '">' . htmlspecialchars($value->getNomParticipant()).'</a></td>
                    <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getMailParticipant()) . '</td>
                    <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNationalite()) . '</td>
                    <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getAffiliation()) . '</td>
                    <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=participant&action=update&codeParticipant=' . htmlspecialchars($value->getCodeParticipant()) . '"><i class="material-icons">mode_edit</i></a></td>
                    <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=participant&action=delete&codeParticipant=' . htmlspecialchars($value->getCodeParticipant()) . '"><i class="material-icons">delete</i></a></td>
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