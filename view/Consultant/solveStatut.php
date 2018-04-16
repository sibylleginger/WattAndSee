<?php

echo '<form method="post" action="index.php?controller=extraction&action=solvedStatuts">';

echo '
<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
    <thead>
    <tr>
        <th class="mdl-data-table__cell--non-numeric">Statut</th>
        <th class="mdl-data-table__cell--non-numeric">Type Statut</th>
        <th class="mdl-data-table__cell--non-numeric">Solution</th>
    </tr>
    </thead>
    <tbody>
';

foreach ($statuts as $cle => $statut) {
    echo '
        <tr>
            <td class="mdl-data-table__cell--non-numeric">' . $statut["statut"] . '</td>
            <td class="mdl-data-table__cell--non-numeric">' . $statut["typeStatut"] . '</td>
            <td class="mdl-data-table__cell--non-numeric">
     ';
// DropDown statuts existants

    echo '<div>
            <select style="display: block;" required name="' . $statut["statut"] . '/' . $statut["typeStatut"] . '">';
    echo '<option value="rien" selected>Ne rien faire</option>';
    echo '<option value="nouveau">Créer un nouveau statut correspondant</option>';
    echo '<optgroup label="Statuts existants">';

    foreach ($modelStatuts as $statut) {
        echo '<option value="' . $statut->getCodeStatut() . '"';
        echo '>' . $statut->getStatut() . " " . $statut->getTypeStatut() . '</option>';
    }
    echo '</optgroup>';
    echo '</select></div>';
// FIN DROPDOWN

    echo '
    </td>
        </tr>
';
}

echo '</tbody>
</table>
';
echo '<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect"
       type="submit"
       style="margin-bottom: 15px">
        <i class="material-icons">send</i>
    </button>';
echo '</form>';

?>