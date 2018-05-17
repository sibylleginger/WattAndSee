<div>
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp users">
        <thead>
        <tr>
            <th class="mdl-data-table__cell--non-numeric">Nom du programme</th>
            <th class="mdl-data-table__cell--non-numeric">Nombre projets</th>
            <th class="mdl-data-table__cell--non-numeric">Modifier</th>
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
                        <td class="mdl-data-table__cell--non-numeric"><a href="index.php?controller=sourceFin&action=update&codeSourceFin=' . htmlspecialchars($sourceFin->getCodeSourceFin()).'"><i class="material-icons">edit</i></a></td>
                    </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>

<!--
<a href="index.php?controller=departement&action=create" class="new">
    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored new">
        <i class="material-icons">add</i>
    </button>
</a>

-->
<a href="index.php?controller=projet&action=create" class="new">
    <button id="demo-menu-top-right"
            class="mdl-button mdl-js-button mdl-button--fab">
        <i class="material-icons">add</i>
    </button>

    <!--<ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect"
        for="demo-menu-top-right">
        <a href="index.php?controller=departement&action=create"><li class="mdl-menu__item">Ajouter un nouveau projet</li></a>
        <a href="index.php?controller=diplome&action=create"><li class="mdl-menu__item">Créer un diplome</li></a>
        <a href="index.php?controller=uniteDEnseignement&action=create"><li class="mdl-menu__item">Créer une unité d'enseignement</li></a>
    </ul>-->
</a>