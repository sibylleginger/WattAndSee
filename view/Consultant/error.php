<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
    <thead>
    <tr>
        <th class="mdl-data-table__cell--non-numeric">Nom Enseignant</th>
        <th class="mdl-data-table__cell--non-numeric">Code Enseignant</th>
        <th class="mdl-data-table__cell--non-numeric">Département Ens</th>
        <th class="mdl-data-table__cell--non-numeric">Statut Enseignant</th>
        <th class="mdl-data-table__cell--non-numeric">Type Statut</th>
        <th class="mdl-data-table__cell--non-numeric">Date</th>
        <th class="mdl-data-table__cell--non-numeric">Durée</th>
        <th class="mdl-data-table__cell--non-numeric">Code Activité</th>
        <th class="mdl-data-table__cell--non-numeric">Type Activité</th>
        <th class="mdl-data-table__cell--non-numeric"><i class="material-icons">report_problem</i></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($tab as $value) {
        echo '      <tr>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getNomEns()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getCodeEns()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getDepartementEns()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getStatut()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getTypeStatut()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getDateCours()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getDuree()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getActivitee()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getTypeActivitee()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric">' . htmlspecialchars($value->getTypeErreur()) . '</td>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=extraction&action=update&idErreur=' . htmlspecialchars($value->getIdErreur()) . '"><i class="material-icons">mode_edit</i></a></td>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=extraction&action=delete&idErreur=' . htmlspecialchars($value->getIdErreur()) . '"><i class="material-icons">delete</i></a></td>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=extraction&action=tentative&idErreur=' . htmlspecialchars($value->getIdErreur()) . '"><i class="material-icons">send</i></a></td>
                    </tr>
            ';
    }
    ?>
    </tbody>
</table>

<div style="margin: auto; text-align: center; margin-bottom: 15px">
    <a class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect"
       href="index.php?controller=extraction&action=readAll&p=<?php echo intval($p) - 1 ?>" <?php if ($p <= 1) echo 'disabled' ?>>
        <i class="material-icons">navigate_before</i>
    </a>
    <a class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect"
       href="index.php?controller=extraction&action=readAll&p=<?php echo intval($p) + 1; ?>" <?php if ($p >= $max) echo 'disabled' ?>>
        <i class="material-icons">navigate_next</i>
    </a>
</div>
