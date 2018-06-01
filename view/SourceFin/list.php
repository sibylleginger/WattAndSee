<div>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Nom du programme</th>
            <th class="mdl-data-table__cell--non-numeric">Nombre projets</th>
            <th class="mdl-data-table__cell--non-numeric">Modifier</th>
            <th class="mdl-data-table__cell--non-numeric">Supprimer</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($sourcesFin as $sourceFin) {
            $tabProjet = ModelProjet::selectAllBySource($sourceFin->getCodeSourceFin());
            $nbProjets = count($tabProjet);
            echo '<tr>
                        <td><a href="index.php?controller=sourceFin&action=read&codeSourceFin=' . htmlspecialchars($sourceFin->getCodeSourceFin()) . '">'. htmlspecialchars($sourceFin->getNomSourceFin()).'</a></td>
                        <td class="mdl-data-table__cell--non-numeric">'; if($nbProjets == false) {
                            echo '0';
                        }else {
                            echo htmlspecialchars($nbProjets);
                        }
                        echo '</td>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=sourceFin&action=update&codeSourceFin=' . htmlspecialchars($sourceFin->getCodeSourceFin()).'"><i class="material-icons">edit</i></a>
                            <a href="index.php?controller=contact&action=create&codeSourceFin=' . htmlspecialchars($sourceFin->getCodeSourceFin()).'"><i class="material-icons">person_add</i></a></td>
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=sourceFin&action=delete&codeSourceFin=' . htmlspecialchars($sourceFin->getCodeSourceFin()).'"><i class="material-icons">delete</i></a></td>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>
<a href="index.php?controller=sourceFin&action=create">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>